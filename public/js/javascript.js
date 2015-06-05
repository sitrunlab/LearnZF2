/**
 * Created by mockie on 11/7/14.
 */

jQuery('document').ready(function(){

    jQuery('a.btn-donate').click(function(){
        var state = jQuery(this).data('toggleState');
        if(!state){
            jQuery(this).next('.donation-desc').slideDown();
        } else {
            jQuery(this).next('.donation-desc').slideUp();
        }
        $(this).data('toggleState', !state);
        return false;
    });

    jQuery('ul.contributor-gallery li').hover(function(){
        $(this).find('.gallery-overlay').stop(true).fadeIn(1500);
    },function(){
        $(this).find('.gallery-overlay').stop(true).fadeOut(1500);
    });

});

;(function (w, d, $, undefined) {
    'use strict';

    var ajaxImageUpload = {

        /**
         * Attach event listeners
         */
        init: function () {

            $("button.upload").on("click", function () {
                $(".uploader-inline").show();
                $(".gallery-view").hide().find("figure.centered").remove();
            });

            $(".gallery").on("click", function() {
                ajaxImageUpload.showFiles();
            });

            $("button.media-modal-toggle").on("click", function () {
                $("#modal-imgupload").fadeToggle(850);
            });

            /**
             * AJAX image upload
             */
            $("#imgajax").change(function (e) {
                var $form = $("#content").submit();
                $.ajax({
                    url: $form.attr("action"),
                    type: "POST",
                    data: new FormData($form[0]),
                    processData:false,
                    contentType:  false,
                    cache: false,
                }).done(function (result, request, headers) {
                    var $resp = $.parseJSON(result);
                    ajaxImageUpload.getAjaxResponse($resp["successFiles"], "p", ".demo-box", "image-upload-message successFiles");
                    ajaxImageUpload.getAjaxResponse($resp["errorFiles"], "p", ".demo-box", "image-upload-message errorFiles");
                    ajaxImageUpload.showFiles();
                }).fail(function (result, request, headers) {
                    console.error("Error:", result.responseText);
                });
                // clear file input
                $("#imgajax").replaceWith($("#imgajax").val('').clone(true));
                e.preventDefault();
                return false;
            });
        },

        /**
         * Create DOM nodes with text, class and appends them to elementAppend
         */
        showMessages: function (text, elementCreate, elementAppend, className) {
            var el = document.createElement(elementCreate);
            el.className += className;
            el.innerHTML = text;

            $(elementAppend).append(el).slideDown(1000, function (e) {
                e.preventDefault();
                setTimeout(function() {
                    $(elementCreate).slideUp(1000, function () {
                        $(this).fadeOut("slow", function () {
                            $(this).remove();
                         });
                    });
                }, 6000);
            });
        },

        /**
         * Show AJAX reponse
         */
        getAjaxResponse: function (response, elementCreate, elementAppend, className) {
            if (typeof response !== "undefined" && typeof response !== undefined) {
                $(elementAppend).append($("<div class='dinamicly-div-append-wrapper'></div>"));
                $.each(response, function(key, text) {
                    ajaxImageUpload.showMessages(text, elementCreate, 'div.dinamicly-div-append-wrapper', className);
                });
            }
        },

        /**
         * Gallery view
         */
        showFiles: function () {
                $(".uploader-inline, .large-image").hide();
                $(".gallery-view").find("figure.centered").not(".large-image").remove();
                $(".gallery-view, .ajax-loader").show();
            $.get( "/learn-zf2-ajax-image-gallery/index/files", function (files) {
                $(".ajax-loader").hide();
                $(".large-image").show();
                $.each(files, function (key, file) {
                    $("div.image-grid").append("<figure class='centered'><img src='"+$.parseJSON(file["link"])+"' class='thumbnail' alt='"+$.parseJSON(file["filename"])+"' title='"+$.parseJSON(file["filename"])+"' /></figure>");
                });
                ajaxImageUpload.viewImage();
            });
        },

        /**
         * View the selected image on the right side
         */
        viewImage: function () {
            $(".large-image").attr("src",$(".thumbnail").first().attr("src"));
            $(".thumbnail").on("click", function () {
                $(".large-image").attr("src",$(this).attr("src"));
            });
        }
    };

    $(document).ready(function ($) {
        'use strict';

        ajaxImageUpload.init();
    });
})(this, document, jQuery);
