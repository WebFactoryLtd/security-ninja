/*
 * Security Ninja
 * Main backend JS
 * (c) Web factory Ltd, 2015 - 2016
 */

 
jQuery(document).ready(function($){
  if (typeof wf_sn_pointers  == 'undefined') {
    return;
  }

  $.each(wf_sn_pointers, function(index, pointer) {
    $(pointer.target).pointer({
        content: '<h3>Security Ninja</h3><p>' + pointer.content + '</p>',
        position: {
            edge: pointer.edge,
            align: pointer.align
        },
        width: 320,
        close: function() {
                $.post(ajaxurl, {
                    pointer: index,
                    _ajax_nonce: wf_sn.nonce_dismiss_pointer,
                    action: 'sn_dismiss_pointer'
                });
        }
      }).pointer('open');
  });
});