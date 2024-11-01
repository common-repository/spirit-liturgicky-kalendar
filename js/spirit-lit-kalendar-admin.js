(function( $ ) {
    'use strict';

    var tsslk_button_block_switch = jQuery('#tsslk_options_ShowButton').is(":checked");
    var tsslk_CustomCSS_block_switch = jQuery('#tsslk_options_CustomCSS').is(":checked");

    if (!tsslk_button_block_switch) jQuery('.tsslk_button_block').hide();
    if (!tsslk_CustomCSS_block_switch) jQuery('.tsslk_CustomCSS_block').hide();

    $('#tsslk_options_ShowButton').change(function() {
        if(this.checked) jQuery('.tsslk_button_block').slideDown( "slow" );
        else jQuery('.tsslk_button_block').slideUp( "slow" );
    });

    $('#tsslk_options_CustomCSS').change(function() {
        if(this.checked) jQuery('.tsslk_CustomCSS_block').slideDown( "slow" );
        else jQuery('.tsslk_CustomCSS_block').slideUp( "slow" );
    });  

    jQuery('.tsslk-color-picker').wpColorPicker();

    //tsslk-font-button controls
   jQuery('.tsslk-font-button').click(function() {
        if(jQuery(this).hasClass('selected')) {
            jQuery(this).removeClass('selected');
            jQuery(this).parent().find('input[type=hidden]').val(0);
        }
        else {
            jQuery(this).addClass('selected');
            jQuery(this).parent().find('input[type=hidden]').val(1);
        }
    })


})( jQuery );
