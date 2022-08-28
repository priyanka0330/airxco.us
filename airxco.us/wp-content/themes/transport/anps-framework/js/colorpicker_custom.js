"use strict";
jQuery(document).ready(function( $ ) {
    var currentlyClickedElement = '';

    $('.color-pick-color').bind("click", function(){
        currentlyClickedElement = this;
    });

    $('.color-pick-color').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).css("background","#"+hex);
            $(el).attr("data-value", "#"+hex);
            $(el).parent().children(".color-pick").val("#"+hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor($(this).attr("data-value"));
        },
        onChange: function (hsb, hex, rgb) {
            $(currentlyClickedElement).css("background","#"+hex);
            $(currentlyClickedElement).attr("data-value", "#"+hex);
            $(currentlyClickedElement).parent().children(".color-pick").val("#"+hex);
        }
    })
    .bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
    });


    /* Scheme Creator */

    window.anpsGetColors = function() {
        var allColors = [];

        $('.color-pick').each(function() {
            allColors.push($(this).val());
        });

        console.log(allColors);
    };

    $('.color-pick').bind('keyup', function(){
        $(this).parent().children(".color-pick-color").css("background", $(this).val());
    });

    var default_val = ["#727272", "#292929", "#153d5c", "#000000", "", "", "", "", "#3178bf", "#000000", "#c1c1c1", "#f9f9f9", "#ffffff", "#ffffff", "#000000", "#000000", "#26507a", "#fff", "", "", "#16354f", "#9bb3c7", "#fff", "#ffffff", "#1874c1", "#fff", "#435b6e", "#122c40", "#1874c1", "#ffffff", "#292929", "#fff", "#1874c1", "#fff", "#000000", "#fff", "#000000", "#fff", "#ffffff", "#ffffff", "#ffffff", "#ffffff", "#1874c1", "#ffffff", "#1874c1", "#94cfff", "#1874c1", "#fff", "#000000", "#ffffff", "#c3c3c3", "#fff", "#737373", "#fff", "#1874c1", "#fff", "#000", "#fff"];
    var light_blue = ["#727272", "#292929", "#4ab9cf", "#000000", "#4ab9cf", "", "", "", "#4ab9cf", "#fff", "#8e9ba7", "#eaedf0", "#ffffff", "#ffffff", "#4ab9cf", "#000000", "#4ab9cf", "#fff", "", "", "#1f425d", "#9bb3c7", "#fff", "", "", "#385870", "#385870", "#1f425d", "#4ab9cf", "#ffffff", "#42c7de", "#fff", "#4ab9cf", "#fff", "#42c7de", "#fff", "#000000", "#fff", "#ffffff", "#ffffff", "#ffffff", "#ffffff", "#42c7de", "#ffffff", "#4ab9cf", "#42c7de", "#4ab9cf", "#fff", "#42c7de", "#ffffff", "#c3c3c3", "#fff", "#737373", "#fff", "#4ab9cf", "#fff", "#42c7de", "#fff"];
    var green = ["#727272", "#86d33b", "#74b830", "#000000", "#86d33b", "", "", "", "#ffffff", "#333333", "#8e9ba7", "#eaedf0", "#ffffff", "#ffffff", "#86d33b", "#000000", "#86d33b", "#fff", "", "", "#242424", "#a3a3a3", "#fff", "", "", "#383838", "#828282", "#242424", "#86d33b", "#ffffff", "#74b830", "#fff", "#86d33b", "#fff", "#74b830", "#fff", "#000000", "#fff", "#ffffff", "#ffffff", "#ffffff", "#ffffff", "#74b830", "#ffffff", "#86d33b", "#74b830", "#86d33b", "#fff", "#42c7de", "#ffffff", "#c3c3c3", "#fff", "#737373", "#fff", "#86d33b", "#fff", "#42c7de", "#fff"];
    var red   = ["#727272", "#292929", "#bf2626", "#000000", "#d82a2a", "", "", "", "#bf2626", "#1c1c1c", "#8e9ba7", "#eaedf0", "#ffffff", "#ffffff", "#d82a2a", "#000000", "#d82a2a", "#fff", "", "", "#242424", "#a3a3a3", "#fff", "", "", "#383838", "#828282", "#242424", "#d82a2a", "#ffffff", "#bf2626", "#fff", "#d82a2a", "#fff", "#bf2626", "#fff", "#000000", "#fff", "#ffffff", "#ffffff", "#ffffff", "#ffffff", "#bf2626", "#ffffff", "#d82a2a", "#bf2626", "#d82a2a", "#fff", "#bf2626", "#ffffff", "#c3c3c3", "#fff", "#737373", "#fff", "#d82a2a", "#fff", "#bf2626", "#fff"];

    $("#predefined_colors label").bind("click", function(){
        var table;
        switch($('input', this).val()) {
            case "default" :
                table = default_val;
                break;
            case "light_blue" :
                table = light_blue;
                break;
            case "green" :
                table = green;
                break;
            case "red" :
                table = red;
                break;
        }

        $(".color-pick").each(function(index){
            $(".color-pick").eq(index).val(table[index]);
            $(".color-pick").eq(index).parent().children(".color-pick-color").css("background", table[index]);
            $(".color-pick").eq(index).parent().children(".color-pick-color").attr("data-value", table[index]);
        });
    });
    $(".input-type").change(function(){
        if($(this).val() == "dropdown") {
            $(this).parent().parent().children(".validation").hide();
            $(this).parent().parent().children(".label-place-val").children("label").html("Values");
        }
        else {
            $(this).parent().parent().children(".validation").show();
            $(this).parent().parent().children(".label-place-val").children("label").html("Placeholder");
        }
    });
});
