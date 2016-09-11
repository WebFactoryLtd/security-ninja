/*
 * Security Ninja
 * Main backend JS
 * (c) Web factory Ltd, 2015 - 2016
 */

function sn_block_ui(content_el) {
  jQuery('html.wp-toolbar').addClass('sn-overlay-active');
  jQuery('#wpadminbar').addClass('sn-overlay-active');
  jQuery('#sn_overlay .wf-sn-overlay-outer').css('height', (jQuery(window).height() - 200) + 'px');
  jQuery('#sn_overlay').show();

  if (content_el) {
    jQuery(content_el, '#sn_overlay').show();
  }
} // sn_block_ui


function sn_unblock_ui(content_el) {
  jQuery('html.wp-toolbar').removeClass('sn-overlay-active');
  jQuery('#wpadminbar').removeClass('sn-overlay-active');
  jQuery('#sn_overlay').hide();

  if (content_el) {
    jQuery(content_el, '#sn_overlay').hide();
  }
} // sn_block_ui


jQuery(document).ready(function($){
  // init tabs
  $('#tabs').tabs({
    activate: function( event, ui ) {
        $.cookie('sn_tabs_selected', $('#tabs').tabs('option', 'active'));
    },
    active: $('#tabs').tabs({ active: $.cookie('sn_tabs_selected') })
  });

  // run tests, via ajax
  $('#run-tests').click(function(){
    var data = {action: 'sn_run_tests', '_ajax_nonce': wf_sn.nonce_run_tests};

    sn_block_ui('#sn-site-scan');

    $.post(ajaxurl, data, function(response) {
      if (response != '1') {
        alert('Undocumented error. Page will automatically reload.');
        window.location.reload();
      } else {
        window.location.reload();
      }
    });
  }); // run tests

  // show test details/help tab
  $('.sn-details a.button').live('click', function(){
    if ($('#wf-ss-dialog').length){
      $('#wf-ss-dialog').dialog('close');
    }
    $('#tabs').tabs('option', 'active', 1);

    // get the link anchor and scroll to it
    target = this.href.split('#')[1];
    $.scrollTo('#' + target, 500, {offset: {top:-50, left:0}});

    return false;
  }); // show test details

  // hide add-on tab
  $('.hide_tab').on('click', function(e){
    e.preventDefault();
    data = {action: 'sn_hide_tab', 'tab': $(this).data('tab-id'), '_ajax_nonce': wf_sn.nonce_hide_tab};

    $.post(ajaxurl, data, function(response) {
      if (!response.success) {
        alert('Undocumented error. Page will automatically reload.');
        window.location.reload();
      } else {
        window.location.reload();
      }
    });
  }); // hide add-on tab

  // abort scan by refreshing
  $('#abort-scan').on('click', function(e){
    e.preventDefault();
    if (confirm('Are you sure you want to stop scanning?')) {
      window.location.reload();
    }
  }); // abort scan
  
  // remote access buttons click
  $('.confirm-click').on('click', function(e){
    if (confirm($(this).data('confirm-msg'))) {
      return true;
    } else {
      e.preventDefault();
      return false;  
    }
  }); // confirm click
  

  // refresh update info
  $('#sn-refresh-update').on('click', function(e){
    e.preventDefault();
    $.post(ajaxurl, {action: 'sn_refresh_update', '_ajax_nonce': wf_sn.nonce_refresh_update}, function(response) {
      window.location.replace('tools.php?page=wf-sn');
    });
  }); // refresh update info
});