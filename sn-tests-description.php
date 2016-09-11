<?php
/*
 * Security Ninja
 * Test descriptions and help
 * (c) 2011. - 2016. Web factory Ltd
 */
?>
<table class="wp-list-table widefat" cellspacing="0" id="sn-tests-help">
  <thead>
    <tr>
      <th width="20%">Test</th>
      <th>Detailed explanation &amp; help</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td id="ver_check">Check if WordPress core is up to date</td>
      <td><p>Keeping the WordPress core up to date is one of the most important aspects of site security. If vulnerabilities are discovered in WordPress and a new version is released to address the issue, the information required to exploit the vulnerability is definitely in the public domain. This makes old versions more open to attacks, and is one of the primary reasons you should always keep WordPress up to date.</p>
      <p>Thanks to automatic updates updating is very easy. Just go to <a target="_blank" href="update-core.php">Dashboard - Updates</a> and click "Upgrade". <b>Remember</b> - always backup your files and database before upgrading!</p></td>
    </tr>
    <tr>
      <td id="core_updates_check">Check if automatic core updates are enabled</td>
      <td><p>Unless you're running a highly customized WordPress site wich requires rigorous testing of all updates we recommend having automatic minor core updates enabled. These are usually security fixes that don't alter WP in any significant way and should be applied as soon as WP releases them.</p>
      <p>Updates can be disabled via constants in <i>wp-config.php</i> or by a plugin. For details please see <a href="http://codex.wordpress.org/Configuring_Automatic_Background_Updates" target="_blank">WP Codex</a>.</p></td>
    </tr>
    <tr>
      <td id="plugins_ver_check">Check if plugins are up to date</td>
      <td><p>As with the WordPress core, keeping plugins up to date is one of the most important and easiest ways to keep your site secure. Since most plugins are free and therefore their code is available to anyone, having the latest version will ensure you're not prone to attacks based on known vulnerabilities.</p>
      <p>If you downloaded a plugin from the official WP repository you can easily check if there are any updates available, and update it by opening <a target="_blank" href="update-core.php">Dashboard - Updates</a>. If you bought the plugin from somewhere else check the item's support on instructions how to upgrade manually. <b>Remember</b> - always backup your files and database before upgrading!</p></td>
    </tr>
    <tr>
      <td id="deactivated_plugins">Check if there are any deactivated plugins</td>
      <td><p>If you're not using a plugin remove it from the WP <i>plugins</i> folder. It's that simple. There's no reason to keep it there and in case the code is malicious or it has some vulnerabilities it can still be exploited by a hacker regardless of the fact the plugin is not active.</p>
      <p>Open <a target="_blank" href="plugins.php">plugins</a> and simply delete all plugins that are not active. Or login via FTP and move them to some folder that's not <i>/wp-content/plugins/</i>.</p></td>
    </tr>
    <tr>
      <td id="themes_ver_check">Check if themes are up to date</td>
      <td><p>As with the WordPress core, keeping the themes up to date is one of the most important and easiest ways to keep your site secure. Since most themes are free and therefore their code is available to anyone having the latest version will ensure you're not prone to attacks based on known vulnerabilities. Also, having the latest version will ensure your theme is compatible with the latest version of WP.</p>
      <p>If you downloaded a theme from the official WP repository you can easily check if there are any updates available, and upgrade it by opening <a target="_blank" href="themes.php">Appearance - Themes</a>. If you bought the theme from a theme shop check their support and upgrade manually. <b>Remember</b> - always backup your files and database before upgrading!</p></td>
    </tr>
    <tr>
      <td id="deactivated_themes">Check if there are any deactivated themes</td>
      <td><p>If you're not using a theme remove it from the WP <i>themes</i> folder. It's that simple. There's no reason to keep it there and in case the code is malicious or it has some vulnerabilities it can still be exploited by a hacker regardless of the fact the theme is not active.</p>
      <p>Open <a target="_blank" href="themes.php">Appearance - Themes</a> and simply delete all themes that are not active. Or login via FTP and move them to some folder that's not <i>/wp-content/themes/</i>.</p></td>
    </tr>
    <tr>
    <td id="wp_header_meta">Check if full WP version info is revealed in page's meta data</td>
      <td><p>You should be proud that your site is powered by WordPress and there's no need to hide that information. However disclosing the full WP version info in the default location (page header meta) is not wise. People with bad intentions can easily use Google to find site's that use a specific version of WordPress and target them with (0-day) exploits.</p>
      <p>Place the following code in your theme's <i>functions.php</i> file in order to remove the header meta version info:</p>
      <pre>function remove_version() {
  return '';
}
add_filter('the_generator', 'remove_version');</pre>
      </td>
    </tr>
    <tr>
    <td id="readme_check">Check if WordPress <i>readme.html</i> file is accessible via HTTP on the default location</td>
      <td><p>As mentioned in the previous test - you should be proud that your site is powered by WordPress but also hide the exact version you're using. <i>readme.html</i> contains WP version info and if left on the default location (WP root) attackers can easily find out your WP version.</p>
      <p>This is a very easy problem to solve. Rename the file to something more unique like "readme-876.html"; delete it; move it to another location or chmod it so that it's not accessible via HTTP.</p>
      </td>
    </tr>
    <tr>
    <td id="php_headers">Check if server response headers contain detailed PHP version info</td>
      <td><p>As with the WordPress version it's not wise to disclose the exact PHP version you're using because it makes the job of attacking your site much easier. This issue is not directly WP related but it definitely affects your site.</p>
      <p>You'll most probably have to ask your hosting company to configure the HTTP server not to show PHP version info but you can also try adding these directives to the <i>.htacces</i> file: </p>
      <pre>&lt;IfModule mod_headers.c&gt;
  Header unset X-Powered-By
  Header unset Server
&lt;/IfModule&gt;</pre>
      </td>
    </tr>
    <tr>
    <td id="user_exists">Check if user with username "admin" exists</td>
      <td><p>If someone tries to guess your username and password or tries a brute-force attack they'll most probably start with username "admin". This is the default username used by too many sites and should be removed.</p>
      <p><a target="_blank" href="user-new.php">Create a new user</a> and assign him the "administrator" role. Try not to use usernames like: "root", "god", "null" or similar ones. Once you have the new user created delete the "admin" one and assign all post/pages he may have created to the new user.</p>
      </td>
    </tr>

    <tr>
    <td id="check_failed_login_info">Check for display of unnecessary information on failed login attempts</td>
      <td><p>By default on failed login attempts WordPress will tell you whether username or password is wrong. An attacker can use that to find out which usernames are active on your system and then use brute-force methods to hack the password.</p>
      <p>Solution to this problem is simple. Whether user enters wrong username or wrong password we always tell him "wrong username or password" so that he doesn't know which of the two is wrong. Open your theme's <i>functions.php</i> file and copy/paste the following code:</p>
      <pre>function wrong_login() {
  return 'Wrong username or password.';
}
add_filter('login_errors', 'wrong_login');</pre>
      </td>
    </tr>
    <tr>
    <td id="salt_keys_check">Check if all security keys and salts have proper values</td>
      <td><p>Security keys are used to ensure better encryption of information stored in the user's cookies and hashed passwords. They make your site harder to hack and access harder to crack by adding random elements to the password. You don't have to remember these keys. In fact once you set them you'll never see them again. Therefore there's no excuse for not setting them properly.</p>
      <p>Security keys (there are eight) are defined in <i>wp-config.php</i> as constants on lines #49-56. They should be as unique and as long as possible. WordPress made a <a target="_blank" href="https://api.wordpress.org/secret-key/1.1/salt/">great script</a> which helps you generate those strings. Please use it! After the script generates strings those 8 lines of code should look something like this:</p>
      <pre>define('AUTH_KEY',         '}D4@p&lt;0VFKb*pdhM8c&lt;bb:qB%Fr8:- dc}U(,[K?hobrzsn*:r?,e^/eHsm6nHls');
define('SECURE_AUTH_KEY',  'M2wEPuf7.%FWW1xvy]ar&amp;vy3gj,:1Go&gt;qs7d_N)nX}O[-(+AaDsiPbvAOdLG~dt}');
define('LOGGED_IN_KEY',    'iA#+3)Xhf0E*oyN1A4#:0wVp|d&lt;F-rQQ Sf_HNMk,rVj,F,GdKF|b-:xBEM,y(,f');
define('NONCE_KEY',        'ctGmyOSSfm1-WR/V:J6[;Zh|?a$slsWs_9BIKcM[}uh~+C|R}ylW4cU%D tIOG=d');
define('AUTH_SALT',        '|@tYo .T&amp;-{wMmP&gt;ggj4p{,HKs!&gt;vsUXz/aPDlZ=1.D54m+#1xyt+%w)3r&amp;j]r?:');
define('SECURE_AUTH_SALT', '`^mxb~AvK*Agn+h&gt;U!0GL2*2|R+HHyY%h1b%Aoo,Jy|M{}TP`mSTt&lt;fcm=O9`=bA');
define('LOGGED_IN_SALT',   'Ow||n$:: HWM5%H7k+MW7{!Z[Z|G-UJZ6Pp8;Id^&lt;lK-&amp;W+}Q?wHw!xlp2g(1% w');
define('NONCE_SALT',       'IoLWhDF-d&lt;&gt;`u}R4oEe5kXf+)&lt;.}Ib?BPE&lt;C9R=NQivhZ|8k^b@LhkpuqojnzdVI');
</pre>

<p><b>Warning</b>: do NOT use the keys above. They are just an example, publically available and therefore not safe. Generate your own ones.</p>
      </td>
    </tr>
    <tr>
    <td id="salt_keys_age_check">Check if security keys and salts have been updated in the last 3 months</td>
      <td><p>It's recommended to change the security keys and salts once in a while. The process will invalidate all existing cookies. This does mean that all users will have to login again. It's a minor inconvenience that will ensure nobody can login with an old or stolen cookie.
      </p>
      <p>To edit the keys open <i>wp-config.php</i>, <a target="_blank" href="https://api.wordpress.org/secret-key/1.1/salt/">generate new keys</a> and copy/paste them to overwrite the old ones.</p>
      </td>
    </tr>
    <tr>
    <td id="db_password_check">Test the strength of WordPress database password</td>
      <td><p>There is no such thing as an "unimportant password"! The same goes for WordPress database password. Although most servers are configured so that the database can't be accessed from other hosts (or from outside of the local network) that doesn't mean your database passsword should be "12345". Choose a proper password, at least 8 characters long with a combination of letters, numbers and special characters.</p>

      <p>To change the database password open cPanel, Plesk or any other hosting control panel you have. Find the option to change the database password and make the new password strong enough. If you can't find that option or you're uncomfortable changing it contact your hosting provider. After the password is changed open wp<i>-config.php</i> and change the password on line #29:</p>
      <pre>/** MySQL database password */
define('DB_PASSWORD', 'YOUR_NEW_DB_PASSWORD_GOES_HERE');</pre>
      </td>
    </tr>
    <tr>
    <td id="db_table_prefix_check">Check if database table prefix is the default one (<i>wp_</i>)</td>
      <td><p>Knowing the names of your database tables can help an attacker dump the table's data and get to sensitive information like password hashes. Since WP table names are predefined the only way you can change table names is by using a unique prefix. One that's different from "wp_" or any similar variation such as "wordpress_".</p>
      <p>If you're doing a fresh installation defining a unique table prefix is easy. Open <i>wp-config.php</i> and go to line #61 where the table prefix is defined. Enter something unique like "frog99_" and install WP.</p>
      <p>If you already have WP site running and want to change the table prefix things are a bit more complicated and you should only do the change if you're comfortable doing some changes to your DB data via phpMyAdmin or a similar GUI. Detailed 6-step instruction can be found on <a target="_blank" href="http://tdot-blog.com/wordpress/6-simple-steps-to-change-your-table-prefix-in-wordpress">Tdot blog</a>. <b>Remember</b> - always backup your files and database before making any changes to the database!</p>
      </td>
    </tr>
    <tr>
    <td id="debug_check">Check if site debug mode is enabled</td>
      <td><p>Having any kind of debug mode (general WP debug mode in this case) or error reporting mode enabled on a production site is extremely bad. Not only will it slow down your site, confuse your visitors with weird messages it will also give the potential attacker valuable information about your system.</p>
      <p>General WordPress debugging mode is enabled/disabled by a constant defined in <i>wp-config.php</i>. Open that file and look for a line similar to:</p>
      <pre>define('WP_DEBUG', true);</pre>
      <p>Comment it out, delete it or replace with the following to disable debugging:</p>
      <pre>define('WP_DEBUG', false);</pre>
      <p>If your blog still fails on this test after you made the changes it means some plugin is enabling debug mode. Disable plugins one by one to find out which one is doing it.</p>
      </td>
    </tr>
    <tr>
    <td id="db_debug_check">Check if database debug mode is enabled</td>
      <td><p>Having any kind of debug mode (WP database debug mode in this case) or error reporting mode enabled on a production server is extremely bad. Not only will it slow down your site, confuse your visitors with weird messages it will also give the potential attacker valuable information about your system.</p>
      <p>WordPress DB debugging mode is enabled with the following command:</p>
      <pre>$wpdb-&gt;show_errors();</pre>
      <p>In most cases this debugging mode is enabled by plugins so the only way to solve the problem is to disable plugins one by one and find out which one enabled debugging.</p>
      </td>
    </tr>
    <tr>
    <td id="script_debug_check">Check if JavaScript debug mode is enabled</td>
      <td><p>Having any kind of debug mode (WP JavaScript debug mode in this case) or error reporting mode enabled on a production server is extremely bad. Not only will it slow down your site, confuse your visitors with weird messages it will also give the potential attacker valuable information about your system.</p>
      <p>WordPress JavaScript debugging mode is enabled/disabled by a constant defined in <i>wp-config.php</i> open your config file and look for a line similar to:</p>
      <pre>define('SCRIPT_DEBUG', true);</pre>
      <p>Comment it out, delete it or replace with the following to disable debugging:</p>
      <pre>define('SCRIPT_DEBUG', false);</pre>
      <p>If your blog still fails on this test after you made the change it means some plugin is enabling debug mode. Disable plugins one by one to find out which one is doing it.</p>
      </td>
    </tr>
        <tr>
    <td id="display_errors_check">Check if <i>display_errors</i> PHP directive is turned off</td>
      <td><p>Displaying any kind of debug info or similar information is extremely bad. If any PHP errors happen on your site they should be logged in a safe place and not displayed to visitors or potential attackers.</p>
      <p>Open <i>wp-config.php</i> and place the following code just above the <i>require_once</i> function at the end of the file:</p>
      <pre>ini_set('display_errors', 0);</pre>
      <p>If that doesn't work add the following line to your <i>.htaccess</i> file:</p>
      <pre>php_flag display_errors Off</pre>
      <p>If that fails as well, contact your hosting provider or try disabling plugins, one by one to find out which one enabled error displaying.</p>
      </td>
    </tr>
    <tr>
    <td id="blog_site_url_check">Check if WordPress installation address is the same as the site address</td>
      <td><p>Moving WP core files to any non-standard folder will make your site less vulnerable to automated attacks. Most scripts that script kiddies use rely on default file paths. If your blog is setup on <i>www.site.com</i> you can put WP files in ie: <i>/var/www/vhosts/site.com/www/my-app/</i> instead of the obvious <i>/var/www/vhosts/site.com/www/</i>.</p>
      <p>Site and WP address can easily be changed in <a target="_blank" href="options-general.php">Options - General</a>. Before doing so please watch this detailed <a target="_blank" href="http://www.youtube.com/watch?v=PFfvBJVtzqA">video tutorial</a> which describes what other steps are necessary to move your WP core files to another location.</p>
      </td>
    </tr>

    <tr>
    <td id="config_chmod">Check if <i>wp-config.php</i> file has the right permissions (chmod) set</td>
      <td><p><i>wp-config.php</i> file contains sensitive information (database username and password) in plain text and should not be accessible to anyone except you and WP (or the web server to be more precise).</p>
      <p>What's the best chmod for your <i>wp-config.php</i> depends on the way your server is configured but there are some general guidelines you can follow. If you're hosting on a Windows based server ignore all of the following.</p>
      <ul>
      <li>try setting chmod to 0400 or 0440 and if the site works normally that's the best one to use</li>
      <li>"other" users should have no privileges on the file so set the last octal digit to zero</li>
      <li>"group" users shouldn't have any access right as well unless Apache falls under that category, so set group rights to 0 or 4</li>
      </ul>
      </td>
    </tr>
    <tr>
    <td id="install_file_check">Check if <i>install.php</i> file is accessible via HTTP on the default location</td>
      <td><p>There have already been a couple of security issues regarding the <i>install.php</i> file. Once you install WP this file becomes useless and there's no reason to keep it in the default location and accessible via HTTP.</p>
      <p>This is a very easy problem to solve. Rename <i>install.php</i> (you'll find it in the <i>wp-admin</i> folder) to something more unique like "install-876.php"; delete it; move it to another location or chmod it so it's not accessible via HTTP.</p>
      </td>
    </tr>
    <tr>
    <td id="upgrade_file_check">Check if <i>upgrade.php</i> file is accessible via HTTP on the default location</td>
      <td><p>There have already been a couple of security issues regarding this file. Besides the security issue it's never a good idea to let people run any database upgrade scripts without your knowledge. This is a useful file but it should not be accessible on the default location.</p>
      <p>This is a very easy problem to solve. Rename <i>upgrade.php</i> (you'll find it in the <i>wp-admin</i> folder) to something more unique like "upgrade-876.php"; move it to another location or chmod it so it's not accessible via HTTP. Don't delete it! You may need it later on.</p>
      </td>
    </tr>
    <tr>
    <td id="bruteforce_login">Check users' password strength with a brute-force attack</td>
      <td><p>By using a dictionary of 600 most commonly used passwords Security Ninja does a brute-force attach on your site's user accounts. Any accounts that fail this test pose a serious security issue for the site because they are using passwords like "12345", "qwerty" or "god" which anyone can guess within minutes. Alert those users or change their passwords immediately.</p>
      <p>Please note that Security Ninja (by default) tests only the first 5 users (starting from administrators). This limit is imposed to be sure we don't temporarily kill the DB while doing the brute-force attack.<br />
      If you want to test more or all users open <i>sn-test.php</i> and change the line #763 which defines this limit.</p>
      <pre>$max_users_attack = 5;</pre>
      </td>
    </tr>
    <tr>
    <td id="anyone_can_register">Check if "anyone can register" option is enabled</td>
      <td><p>Unless you're running some kind of community based site this option needs to be disabled. Although it only provides the attacker limited access to your backend it's enough to start exploiting other security issues.</p>
      <p>Go to <a target="_blank" href="options-general.php">Options - General</a> and uncheck the "Membership - anyone can register" checkbox.</p>
      </td>
    </tr>
    <tr>
    <td id="register_globals_check">Check if <i>register_globals</i> PHP directive is turned off</td>
      <td><p>This is one of the biggest security issues you can have on your site! If your hosting company has this this directive enabled by default switch to another company immediately! <a target="_blank" href="http://php.net/manual/en/security.globals.php">PHP manual</a> has more info why this is so dangerous.</p>
      <p>If you have access to php.ini file locate</p>
      <pre>register_globals = on</pre>
      <p>and change it to:</p>
      <pre>register_globals = off</pre>
      <p>Alternatively open <i>.htaccess</i> and put this directive into it:</p>
      <pre>php_flag register_globals off</pre>
      <p>If you're still unable to disable <i>register_globals</i> contact a security professional.</p>
      </td>
    </tr>
    <tr>
    <td id="safe_mode_check">Check if safe mode is disabled</td>
      <td><p>PHP safe mode is an attempt to solve the shared-server security problem. It is architecturally incorrect to try to solve this problem at the PHP level, but since the alternatives at the web server and OS levels aren't very realistic, many people, especially ISP's, use safe mode for now. If your hosting company still uses safe mode it might be a good idea to switch. This feature is deprecated in new version of PHP (5.3) which is also old by now.</p>
      <p>If you have access to php.ini file locate</p>
      <pre>safe_mode = on</pre>
      <p>and change it to:</p>
      <pre>safe_mode = off</pre>
      </td>
    </tr>

        <tr>
    <td id="expose_php_check">Check if <i>expose_php</i> PHP directive is turned off</td>
      <td><p>It's not wise to disclose the exact PHP version you're using because it makes the job of attacking your site much easier.</p>
      <p>If you have access to php.ini file locate</p>
      <pre>expose_php = on</pre>
      <p>and change it to:</p>
      <pre>expose_php = off</pre>
      </td>
    </tr>

        <tr>
    <td id="allow_url_include_check">Check if <i>allow_url_include</i> PHP directive is turned off</td>
      <td><p>Having this PHP directive enabled will leave your site exposed to cross-site attacks (XSS). There's absolutely no valid reason to enable this directive and using any PHP code that requires it is very risky.</p>
      <p>If you have access to php.ini file locate</p>
      <pre>allow_url_include = on</pre>
      <p>and change it to:</p>
      <pre>allow_url_include = off</pre>
      <p>If you're still unable to disable <i>allow_url_include</i> contact a security professional.</p>
      </td>
    </tr>
    <tr>
      <td id="file_editor">Check if plugins/themes file editor is enabled</td>
      <td><p>Plugins and themes file editor is a very convenient tool because it enables you to make quick changes without the need to use FTP. Unfortunately it's also a security issue because it not only shows PHP source but it also enables the attacker to inject malicious code in your site if he manages to gain access to the admin.</p>
      <p>Editor can easily be disabled by placing the following code in theme's <i>functions.php</i> file.</p>
      <pre>define('DISALLOW_FILE_EDIT', true);</pre>
      </td>
    </tr>
    <tr>
<?php
  $tmp = wp_upload_dir();
?>
      <td id="uploads_browsable">Check if <i>uploads</i> folder is browsable</td>
      <td><p>Allowing anyone to view all files in the <a href="<?php echo $tmp['baseurl']; ?>" target="_blank">uploads folder</a> just by point the browser to it will allow them to easily download all your uploaded files.
      It's a security and a copyright issue.</p>
      <p>To fix the problem open <i>.htaccess</i> and add this directive into it:</p>
      <pre>Options -Indexes</pre>
      </td>
    </tr>
    <tr>
      <td id="id1_user_check">Check if user with ID "1" exists</td>
      <td><p>Although technically not a security issue having a user (which is in 99% cases the admin) with the ID 1 can help an attacker in some circumstances.</p>
      <p>Fixing is easy; create a new user with the same privileges. Then delete the old one with ID 1 and tell WP to transfer all of his content to the new user.</p>
      </td>
    </tr>
    <tr>
      <td id="wlw_meta">Check if Windows Live Writer link is present in pages' header data</td>
      <td><p>If you're not using Windows Live Writer there's really no valid reason to have it's link in the page header thus telling the whole world you're using WordPress.</p>
      <p>Fixing is very easy. Open your theme's <i>functions.php</i> file and add the following line:</p>
      <pre>remove_action('wp_head', 'wlwmanifest_link');</pre>
      </td>
    </tr>
    <tr>
      <td id="config_location">Check if <i>wp-config.php</i> is present on the default location</td>
      <td><p>If someone gains FTP access to your server this will not save you but it certainly can't hurt to obfuscate your installation a bit.</p>
      <p>In order to fix this issue you have to move wp-config.php one level up in the folder structure. If the original location was:</p>
      <pre>/home/www/wp-config.php</pre>
      <p>move the file to:</p>
      <pre>/home/wp-config.php</pre>
      <p>Or for instance from</p>
      <pre>/home/www/my-blog/wp-config.php</pre>
      <p>to:</p>
      <pre>/home/www/wp-config.php</pre>
      </td>
    </tr>
    <tr>
      <td id="mysql_external">Check if MySQL server is connectable from outside of the local network with the WP account</td>
      <td><p>Since MySQL username and password are written in plain-text in <i>wp-config.php</i> it's advisable not to allow any client to use that account unless he's connecting to MySQL from your server (localhost). Allowing him to connect from any host will make some attacks much easier.</p>
      <p>Fixing this issue involves changing the MySQL user or server config and it's not something that can be described in a few words so we advise asking someone to fix it for you. If you're really eager to do it we suggest creating a new MySQL user and under "hostname" enter "localhost". Set other properties such as username and password to your own liking and, of course, update <i>wp-config.php</i> with the new user details.</p>
      </td>
    </tr>
    <tr>
      <td id="rpc_meta">Check if EditURI (XML-RPC) link is present in pages' header data</td>
      <td><p>If you're not using any Really Simple Discovery services such as pingbacks there's no need to advertise that endpoint (link) in the header. Please note that for most sites this is not a security issue because they "want to be discovered" but if you want to hide the fact that you're using WP this is the way to go.</p>
      <p>Open your theme's <i>functions.php</i> file and add the following line:</p>
      <pre>remove_action('wp_head', 'rsd_link');</pre>
      <p>Additionally, to completely disable XML-RPC functions put the following code in <i>wp-config.php</i> just below the  <i>require_once(ABSPATH . 'wp-settings.php');</i> line:</p>
      <pre>add_filter('xmlrpc_enabled', '__return_false');</pre>
      <p>And also add this code to <i>.htaccess</i> to prevent DDoS attacks:
      <pre>&lt;Files xmlrpc.php&gt;
  Order Deny,Allow
  Deny from all
&lt;/Files&gt;</pre>
      </td>
    </tr>
    <tr>
      <td id="tim_thumb">Check if Timthumb script is used in the active theme</td>
      <td><p>We don't recommend using the Timthumb script to manipulate images. Apart from the security issues some versions had, WordPress has its own built-in functions for manipulating images that should be used instead.<br>
      Contact the theme developer and have him update the theme. It's unlikely you'll be able to fix this issue yourself.</p>
      </td>
    </tr>
    <tr>
      <td id="shellshock_6271">Check if the server is vulnerable to the Shellshock bug #6271</td>
      <td><p>Shellshock, also known as Bashdoor, is a family of security bugs in the widely used Unix Bash shell. Web servers use Bash to process certain commands, allowing an attacker to cause vulnerable versions of Bash to execute arbitrary commands. This can allow an attacker to gain unauthorized access to the system. Although this bug is not related to WordPress directly it's very problematic. <a target="_blank" href="http://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2014-6271">More details.</a><br>
      Contact your server administrator and update the server's Bash shell immediately. </p>
      </td>
    </tr>
    <tr>
      <td id="shellshock_7169">Check if the server is vulnerable to the Shellshock bug #7169</td>
      <td><p>Shellshock, also known as Bashdoor, is a family of security bugs in the widely used Unix Bash shell. Web servers use Bash to process certain commands, allowing an attacker to cause vulnerable versions of Bash to execute arbitrary commands. This can allow an attacker to gain unauthorized access to the system. Although this bug is not related to WordPress directly it's very problematic. <a target="_blank" href="http://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2014-7169">More details.</a><br>
      Contact your server administrator and update the server's Bash shell immediately. </p>
      </td>
    </tr>
    <tr>
      <td id="admin_ssl">Check if admin interface is delivered via SSL</td>
      <td><p>You should run your entire site via HTTPS, it makes it more secure and <a target="_blank" href="https://webmasters.googleblog.com/2014/08/https-as-ranking-signal.html">Google will love it</a> too. If for some reason you don't want to run the entire, at least make the admin secure. Some hosting companies charge a lot for SSL certificates but you can get free ones on <a target="_blank" href="https://letsencrypt.org/">Let's Encrypt</a>. If you don't have an SSL certificate you can still try and run the admin via HTTPS. Depending on how your server is configured, it might work. But getting a valid certificate is definitely a smarter thing to do.</p>
      <p>To enable SSL in admin open <i>wp-config.php</i> and add the following line to it:</p>
      <pre>define('FORCE_SSL_ADMIN', true);</pre>
      </td>
    </tr>
    <tr>
      <td id="mysql_permissions">Check if MySQL account used by WordPress has too many permissions</td>
      <td><p>If an attacker gains access to your <i>wp-config.php</i> file and gets the MySQL username and password, he'll be able to login to that database and do whatever that account allows him to. That's why it's important to keep the account's privileges to a bare minimum. For instance, if you're not installing any new plugins or updating WP that account doesn't need the CREATE or DROP table privileges.<br>For regular, day-to-day usage these are the recommended privileges: SELECT, INSERT, UPDATE, and DELETE. When updating WP you'll also need the ALTER one. MySQL account privileges can be adjusted in cPanel, but we recommend getting a professional to do it if you've never done this kind of modifications before.</p>
      </td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <th>Test</th>
      <th>Detailed explanation &amp; help</th>
    </tr>
  </tfoot>
</table>