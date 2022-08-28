"use strict";
jQuery(document).ready(function($) {
    /* Menu type */
    $('.onoff').hide();
    $('#headerstyle > label > input').change(function() {
        if($(this).is(':checked')) {
            var get_id_to_show = '.' + $(this).closest("label").attr("id");
            //alert (get_id_to_show);
            $('.onoff').hide(100);
            //alert (get_id_to_show);
            $(get_id_to_show).show(200);
            }
    }).change();


    $('#auto_adjust_logo').change(function() {
        if($(this).is(':checked')) {
            $('.onoff').hide(100);
            }
            else {
                $('.onoff').show(100);
            }
    }).change();



    $(".style-images").each(function( index ) {
        if( $("input[type=radio]").eq(index).is(':checked')) {
            $(".style-images").eq( index ).css({
                "border":"2px solid #2187c0",
                "cursor":"default"
            });
        }
    });

    $(".style-images").click(function(){

        $("input[type=radio]").eq( $(this).index(".style-images") ).click();

        $(".style-images").each(function( index ) {
            $(".style-images").eq( index ).css({
                "border":"2px solid #efefef",
                "cursor":"pointer"
            });
        });

        $(this).css({
            "border":"2px solid #2187c0",
            "cursor":"default"
        });
    });

    $("input.dummy").click(function() {

        $(".absolute.fullscreen.importspin").addClass('visible');
        /*alert ('visible');*/
    })

    $(window).on('scroll', function(){
       var ScrollTop = $(window).scrollTop();
       $('.submit-right button.fixsave').css('transform', 'translateY(' + ( ScrollTop + 100 )+ 'px)');
    })


    /* dimm toggle */
    function dimmToggle() {
        $('.dimm-master').each(function(){

            var dimMaster = $(this);
            var dimmSlaves = dimMaster.siblings('.dimm');
            var dimmRebels = dimMaster.siblings('.dimmreverse');

            if( dimMaster.find('input').is(":checked")) {
                dimmSlaves.css('opacity', '1');
                dimmSlaves.css('pointer-events', 'auto');

                dimmRebels.css('pointer-events', 'none');
                dimmRebels.css('opacity', '0.2');
            } else {
                dimmSlaves.css('pointer-events', 'none');
                dimmSlaves.css('opacity', '0.2');

                dimmRebels.css('opacity', '1');
                dimmRebels.css('pointer-events', 'auto');
            }
        })
    }

    $('.dimm-master input').on('change', function() {
        dimmToggle();
    });

    dimmToggle();

    if( $('#copy-clipboard').length ) {
        /* Copy to clipboard */
        var clipboard = new Clipboard('#copy-clipboard');
    }
});

jQuery(function ($) {
    if (typeof ace !== 'undefined') {
        ace.config.set("basePath", anps['theme_url'] + "/anps-framework/js");
        var editor = ace.edit("editor");
        editor.getSession().setMode("ace/mode/css");

        jQuery('#anps_custom_css_wrapper').hide();

        var textarea = jQuery('#anps_custom_css');
        editor.getSession().on('change', function () {
            textarea.val(editor.getSession().getValue());
        });
    }
});
