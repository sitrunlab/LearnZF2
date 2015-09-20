/*!
 * AJAX Image upload gallery
 *
 * Copyright 2015 Stanimir Dimitrov - stanimirdim92@gmail.com
 * Released under the MIT license
 *
 * More tutorials at http://learnzf2.sitrun-tech.com/
 */

/**
 * This will create a local scope for all objects defined in this script.
 * 
 * @param  {Object} win
 * @param  {Object} doc
 * @param  {Object} $
 * @param  {Undefined} undefined
 *
 * @return {Object}
 */
;(function (win, doc, $, undefined) {
    /**
     * use strict doesn't play nice with IIS/.NET
     * http://bugs.jquery.com/ticket/13335
     */
    'use strict';

    var request,
        ajaxImageUpload = {

        /**
         * Attach event listeners
         */
        init: function () {
            /**
             * Listen for click event and show the upload button
             *
             * @param  {Object} event
             *
             * @return {void}
             */
            $("button.upload").on("click", function (event) {
                event.preventDefault();
                $(".uploader-inline").show();
                $(".gallery-view").hide().find("figure.centered").remove();
            });

            /**
             * Listen for click event and show uploaded images
             *
             * @param  {Object} event
             *
             * @return {void}
             */
            $(".gallery").on("click", function (event) {
                event.preventDefault();
                ajaxImageUpload.showFiles();
            });

            /**
             * Listen for click event and show the upload form
             *
             * @param  {Object} event
             *
             * @return {void}
             */
            $("button.modal-toggle").on("click", function (event) {
                event.preventDefault();
                $("#modal-imgupload").fadeToggle(850);
            });

            ajaxImageUpload.abourtXHR(request);

            /**
             * Listen for change event and submit the form
             *
             * @param  {Object} event
             *
             * @return {void}
             */
            $("#imgajax").on("change", function (event) {
                event.preventDefault();
                $("#upload").submit();

                /**
                 * Clear file input
                 */
                $("#imgajax").replaceWith($("#imgajax").val('').clone(true));

            });

            /**
             * Listen for submit event and prevent the request from refreshing the page
             *
             * @param  {Object} event
             *
             * @return {void}
             */
            $("#upload").on("submit", function (event) {
                event.preventDefault();

                /**
                 * Performe AJAX POST request 
                 */
                request = $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: new FormData($(this)[0]),
                    processData: false,
                    contentType: false,
                    cache: false,
                });

                /**
                 * Callback for success response
                 *
                 * @method $.ajax.done
                 *
                 * @param  {Object} result
                 * @param  {Mixed} request
                 * @param  {Mixed} headers
                 *
                 * @return {Object}
                 */
                request.done(function (result, request, headers) {
                    ajaxImageUpload.showFiles();
                    ajaxImageUpload.setAjaxResponse(result, "p", "div.col-lg-9");
                });
                
                /**
                 * Callback for error response
                 *
                 * @method $.ajax.fail
                 *
                 * @param  {String} error 
                 * @param  {Mixed} textStatus 
                 * @param  {Mixed} errorThrown             } 
                 *
                 * @return {Mixed} 
                 */
                request.fail(function (error, textStatus, errorThrown) {
                    console.error(error, textStatus, errorThrown); //TODO must create a dialog popup
                });
            });
        },

        /**
         * Create DOM nodes with text, class and appends them to elementAppend
         *
         * @method showMessages
         *
         * @param  {String} text
         * @param  {String} elementCreate
         * @param  {String} elementAppend
         * @param  {String} className
         *
         * @return {void}
         */
        showMessages: function (text, elementCreate, elementAppend, className) {
            var el = doc.createElement(elementCreate);
            el.className += className;
            el.innerHTML = text;

            $(elementAppend).append(el).slideDown(1000, function (event) {
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
         *
         * @method setAjaxResponse
         *
         * @param  {Object} response
         * @param  {String} elementCreate
         * @param  {String} elementAppend
         *
         * @return {void}
         */
        setAjaxResponse: function (response, elementCreate, elementAppend) {
            if (typeof response !== "undefined" && typeof response !== undefined) {
                $(elementAppend).append($("<div class='dinamicly-div-append-wrapper'></div>"));
                $.each(response, function (className, text) {
                    if (text.length > 1) {
                        $.each(text, function (i, t) {
                            ajaxImageUpload.showMessages(t, elementCreate, 'div.dinamicly-div-append-wrapper', "image-upload-message " + className);
                        });
                    } else {
                        ajaxImageUpload.showMessages(text, elementCreate, 'div.dinamicly-div-append-wrapper', "image-upload-message " + className);
                    }
                });
            }
        },
        
        /**
         * Gallery view
         *
         * @method showFiles
         *
         * @return {Object}
         */
        showFiles: function () {
            $(".large-image").attr("src", "img/default.png");
            $(".uploader-inline, .large-image").hide();
            $(".gallery-view").find("figure.centered").not(".large-image").remove();
            $(".gallery-view, .ajax-loader").show();

            ajaxImageUpload.abourtXHR(request);

            request = $.get("/learn-zf2-ajax-image-gallery/index/files", function (files) {
                $(".ajax-loader").hide();
                $(".large-image").show();
                if (files["files"]) {
                    $.each(files["files"], function (key, imgFile) {
                        $("div.image-grid").append("<figure class='centered'><i class='glyphicon glyphicon-remove deleteimg'></i><img aria-checked='false' aria-label='"+imgFile["filename"]+"' src='"+imgFile["filelink"]+"' class='thumbnail' alt='"+imgFile["filename"]+"' title='"+imgFile["filename"]+"' /></figure>");
                    });
                    ajaxImageUpload.viewImage();
                    ajaxImageUpload.deleteImage();
                }
            });
        },

        /**
         * The big image on the right, next to thumbnails
         *
         * @method viewImage
         * 
         * @return {void}
         */
        viewImage: function () {
            $(".thumbnail").on("click", function (event) {
                event.preventDefault();
                $(".thumbnail").removeClass('image-border').attr("aria-checked", false);
                $(this).addClass('image-border').attr("aria-checked", true);
                $(".large-image").attr("src", $(this).attr("src"));
            });
            $(".large-image").attr("src", $(".thumbnail").first().attr("src"));
        },

        /**
         * Send a request to the server, where the script will check to see if the image exists
         * and if it does it will be deleted
         *
         * @method deleteImage
         *
         * @return {Bool}
         */
        deleteImage: function () {
            ajaxImageUpload.abourtXHR(request);

            $(".deleteimg").on("click", function (event) {
                request = $.post("/learn-zf2-ajax-image-gallery/index/deleteimage", {"img": $(this).next("img").attr("src")}, function () {
                    ajaxImageUpload.showFiles();
                });
            });
        },

        /**
         * Abort every previous AJAX request if new is made.
         * The method will abort on both client and server sides.
         */
        
        /**
         * Abort every previous AJAX request if new is made.
         * The method will abort on both client and server sides.
         *
         * @method abourtXHR
         *
         * @param  {Object} xhr
         *
         * @return {void}
         */
        abourtXHR: function (xhr) {
            if (xhr && xhr.readyState !== 4) {
                xhr.abort();
                xhr = null;
            }
        }
    };

    /**
     * Init everyhing
     *
     * @method $.ready()
     *
     * @param  {Object} $
     *
     * @return {void}
     */
    $(doc).ready(function ($) {
        'use strict';
        ajaxImageUpload.init();
    });
})(this, document, jQuery);
