<?php
/*
 * Security Ninja
 * Remote access functions based on REST API; disabled by default
 * (c) Web factory Ltd, 2011 - 2016
 */

class wf_sn_remote extends WF_SN {
  // if enabled, add endpoints
  static function init() {
    $options = self::get_options();
    if ($options['remote_access']) {  
      self::add_endpoints();
    }
  } // init
  
  
  // add custom endpoints
  static function add_endpoints() {
    $namespace = 'security_ninja';
    $ver = 'v1';

    register_rest_route($namespace . '/' . $ver,
                        'connect', array('methods' => WP_REST_Server::READABLE,
                                         'callback' => array(__CLASS__, 'endpoint_connect'),
                                         'args' => array('access_key' => array(
                                                           'required' => true,
                                                           'validate_callback' => array(__CLASS__, 'validate_access_key'),
                                                         ),
                                                         'dashboard_name' => array(
                                                           'required' => true,
                                                           'validate_callback' => array(__CLASS__, 'validate_dashboard_name'),
                                                         ),
                                                         'dashboard_url' => array(
                                                           'required' => true,
                                                           'validate_callback' => array(__CLASS__, 'validate_dashboard_url'),
                                                      ),),
                                         'show_in_index' => false),
                        true);
    register_rest_route($namespace . '/' . $ver,
                        'get_info', array('methods' => WP_REST_Server::READABLE,
                                          'callback' => array(__CLASS__, 'endpoint_get_info'),
                                          'show_in_index' => false,
                                          'permission_callback' => array(__CLASS__, 'check_auth')),
                        true);
    register_rest_route($namespace . '/' . $ver,
                        'scan_site', array('methods' => WP_REST_Server::READABLE,
                                           'callback' => array(__CLASS__, 'endpoint_scan_site'),
                                           'show_in_index' => false,
                                           'permission_callback' => array(__CLASS__, 'check_auth')),
                        true);
    register_rest_route($namespace . '/' . $ver,
                        'scan_core_files', array('methods' => WP_REST_Server::READABLE,
                                                 'callback' => array(__CLASS__, 'endpoint_scan_core_files'),
                                                 'show_in_index' => false,
                                                 'permission_callback' => array(__CLASS__, 'check_auth')),
                        true);
                        

                        
  } // add_endpoints
  
  
  static function validate_access_key($access_key, $request) {
    if (strlen($access_key) == 32 && ctype_xdigit($access_key) === true) {
      return true;
    } else {
      return false;
    }
  } // validate_access_key
  
  
  static function validate_dashboard_name($dashboard_name, $request) {
    if (strlen($dashboard_name) > 2 && strlen($dashboard_name) < 256) {
      return true;
    } else {
      return false;
    }
  } // validate_dashboard_name
  
  
  static function validate_dashboard_url($dashboard_url, $request) {
    if (filter_var($dashboard_url, FILTER_VALIDATE_URL) !== false) {
      return true;
    } else {
      return false;
    }
  } // validate_dashboard_url
  
  
  // make sure response is unified
  static function prepare_response_error($data = false) {
    $response = array('success' => false, 'data' => $data);
    $response = rest_ensure_response($response);
    
    return $response;
  } // prepare_response_success
  
  
  // make sure response is unified
  static function prepare_response_success($data = false) {
    $response = array('success' => true, 'data' => $data);
    $response = rest_ensure_response($response);
    
    return $response;
  } // prepare_response_success
  
  
  static function endpoint_connect($request) {
    if (self::is_ip_banned()) {
      $response = self::prepare_response_error('IP banned because of too many failed connection attempts.');
    }
    
    $options = self::get_options();
    $params = $request->get_params();
    
    if ($params['access_key'] == $options['access_key']) {
      if (empty($options['connected_dashboard']) && empty($options['connected_dashboard_url'])) {
        $options['connected_dashboard'] = trim(strip_tags($params['dashboard_name']));
        $options['connected_dashboard_url'] = trim(strip_tags($params['dashboard_url']));
        update_option(WF_SN_REMOTE_OPTIONS_KEY, $options);
        
        $response = self::prepare_response_success(array('reconnected' => false, 'site_name' => get_bloginfo('name'), 'wp_ver' => get_bloginfo('version'), 'sn_ver' => (string) wf_sn::$version));
      } elseif ($options['connected_dashboard_url'] == $params['dashboard_url']) {
        $response = self::prepare_response_success(array('reconnected' => true, 'site_name' => get_bloginfo('name'), 'wp_ver' => get_bloginfo('version'), 'sn_ver' => (string) wf_sn::$version));
      } else {
        $response = self::prepare_response_error('Unregistered Remote Dashboard.');
        self::add_failed_auth_attempt();
      }
    } else {
      $response = self::prepare_response_error('Invalid access key.');
      self::add_failed_auth_attempt();
    }
    
    return $response;
  } // endpoint_connect
  
  
  static function endpoint_get_info($request) {
    global $wpdb; 
    if (!function_exists('get_plugins')) {
      include ABSPATH . '/wp-admin/includes/plugin.php';
    }
    
    $data['site_name'] = get_bloginfo('name');
    $data['home_url'] = get_bloginfo('url');
    $data['site_url'] = get_bloginfo('wpurl');
    $data['admin_email'] = get_bloginfo('admin_email');
    $data['wp_ver'] = get_bloginfo('version');
    $data['sn_ver'] = (string) wf_sn::$version;
    $data['php_ver'] = PHP_VERSION;
    $data['php_max_memory'] = ini_get('memory_limit');
    $data['mysql_ver'] = $wpdb->get_var('SELECT VERSION()');
    
    $theme = wp_get_theme();
    $outdated_themes = get_site_transient('update_themes');
    $data['theme_name'] = $theme->Name;
    $data['theme_version'] = $theme->Version;
    $data['themes_total'] = sizeof(wp_get_themes());
    $data['themes_outdated'] = empty($outdated_themes->response)? 0: sizeof($outdated_themes->response);
    
    $plugins = get_plugins();
    $outdated_plugins = get_site_transient('update_plugins');
    $data['plugins_total'] = sizeof($plugins);
    $data['plugins_active'] = sizeof(get_option('active_plugins', array()));
    $data['plugins_outdated'] = empty($outdated_plugins->response)? 0: sizeof($outdated_plugins->response);
    
    $data['users'] = count_users('memory');
    $data['posts'] = wp_count_posts();
    $data['pages'] = wp_count_posts('page');
    $data['comments'] = wp_count_comments();
    
    $response = self::prepare_response_success($data);
    return $response;
  } // endpoint_get_info
  
  
  static function endpoint_scan_core_files($request) {
    if (!class_exists('wf_sn_cs') || !version_compare(wf_sn_cs::$version, '2.65',  '>=')) {
      $response = self::prepare_response_error('Core Scanner add-on is not activated.');
    } else {
      $result = wf_sn_cs::scan_files(true);
      if (is_null($result)) {
        $response = self::prepare_response_error('Core file definitions are missing.');
      } else {
        $response = self::prepare_response_success($result);
      }
    }
    
    return $response;
  } // endpoint_scan_core_files
  
  
  static function endpoint_scan_site($request) {
    $result = WF_SN::run_tests(true);
    $response = self::prepare_response_success($result);
    
    return $response;
  } // endpoint_scan_site
  
  
  static function check_auth($request) {
    if (self::is_ip_banned()) {
      return new WP_Error('rest_forbidden', 'IP banned because of too many failed connection attempts.', array('status' => 403));
    }

    $options = self::get_options();
    $params = $request->get_headers();

    if (!empty($params['x_sn_access_key'][0]) && $params['x_sn_access_key'][0] == $options['access_key'] &&
        !empty($params['x_sn_dashboard_url'][0]) && $params['x_sn_dashboard_url'][0] == $options['connected_dashboard_url']) {
      return true;      
    } else {
      self::add_failed_auth_attempt();
      return false;
    }
  } // check_auth
  
  
  // generates key for remote access
  static function generate_access_key() {
    $tmp = strtoupper(md5(rand()));

    return $tmp;
  } // generate_access_key
  
  
  // retrieves remote related options
  static function get_options() {
    $tmp = get_option(WF_SN_REMOTE_OPTIONS_KEY, false);
    // todo add defaults and merge
    if ($tmp === false || !is_array($tmp)) {
      $tmp = array('remote_access' => false, 'access_key' => '', 'connected_dashboard' => '', 'connected_dashboard_url' => '');
    }

    return $tmp;
  } // get_options
  
  
  // clear all IP ban records
  static function reset_ip_bans() {
    global $wpdb;
    
    $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->options . ' WHERE option_name LIKE %s', array('%transient%sn_remote_ip_log_%')));
    delete_option('sn_remote_banned_ips');
  } // reset_ip_bans
  
  
  // enables, disables and resets remote access
  static function admin_actions() {
    if (!current_user_can('administrator'))  {
      wp_die('You do not have sufficient permissions to access this page.');
    }
    
    if (empty($_GET['module'])) {
      wp_die('Unknown module or action');
    }
    
    if ($_GET['module'] == 'enable') {
      $options = array('remote_access' => true, 'access_key' => self::generate_access_key(), 'connected_dashboard' => '', 'connected_dashboard_url' => '');
      update_option(WF_SN_REMOTE_OPTIONS_KEY, $options);
      self::reset_ip_bans();
      do_action('security_ninja_remote_access', 'enabled');
    } elseif ($_GET['module'] == 'disable') {
      $options = array('remote_access' => false, 'access_key' => '', 'connected_dashboard' => '', 'connected_dashboard_url' => '');
      update_option(WF_SN_REMOTE_OPTIONS_KEY, $options);
      self::reset_ip_bans();
      do_action('security_ninja_remote_access', 'disabled');
    } elseif ($_GET['module'] == 'reset') {
      $options = array('remote_access' => true, 'access_key' => self::generate_access_key(), 'connected_dashboard' => '', 'connected_dashboard_url' => '');
      update_option(WF_SN_REMOTE_OPTIONS_KEY, $options);
      self::reset_ip_bans();
      do_action('security_ninja_remote_access', 'reset');
    } else {
      wp_die('Unknown module or action');
    }
    
    wp_redirect(admin_url('tools.php?page=wf-sn'));
    exit;
  } // admin_actions
  
  
  static function is_ip_banned() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $banned = get_option('sn_remote_banned_ips', array());

    if (isset($banned[$ip])) {
      if ($banned[$ip] > time()) {
        return true;
      } else {
        // cleanup
        unset($banned[$ip]);
        update_option('sn_remote_banned_ips', $banned, true);
        return false;
      }
    } else {
      return false;
    }
  } // is_ip_banned
  
  
  static function add_failed_auth_attempt() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $banned = get_option('sn_remote_banned_ips', array());

    $ban_time = DAY_IN_SECONDS;
    $request_cnt = 15;
    $request_delta = 180;
    $log = get_transient('sn_remote_ip_log_' . $ip);

    if (!is_array($log)) {
      $log = array(time());
    } else {
      $tmp2 = array();
      foreach ($log as $tmp) {
        if ($tmp > time() - $request_delta) {
          $tmp2[] = $tmp;
        }
      } // foreach
      $log = $tmp2;
      $log[] = time();

      if (sizeof($log) >= $request_cnt) {
        $banned[$ip] = time() + $ban_time;
        update_option('sn_remote_banned_ips', $banned, true);
      }
    }
    set_transient('sn_remote_ip_log_' . $ip, $log, $request_delta + 10);
  } // add_failed_auth_attempt
} // class wf_sn_remote