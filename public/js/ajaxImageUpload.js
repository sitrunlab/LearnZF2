;(function (win, doc, $, undefined) {
    /**
     * use strict doesn't play nice with IIS/.NET
     */
    'use strict';

    var request,
        ajaxImageUpload = {

        /**
         * Attach event listeners
         */
        init: function () {
            $("button.upload").on("click", function (event) {
                event.preventDefault();
                $(".uploader-inline").show();
                $(".gallery-view").hide().find("figure.centered").remove();
            });

            $(".gallery").on("click", function (event) {
                event.preventDefault();
                ajaxImageUpload.showFiles();
            });

            $("button.modal-toggle").on("click", function (event) {
                event.preventDefault();
                $("#modal-imgupload").fadeToggle(850);
            });

            ajaxImageUpload.abourtXHR(request);

            /**
             * AJAX image upload
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
             *Listen for submit event and prevent the request from refreshing the page
             */
            $("#upload").on("submit", function (event) {
                event.preventDefault();
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
                 */
                request.done(function (result, request, headers) {
                    ajaxImageUpload.showFiles();
                    ajaxImageUpload.setAjaxResponse($.parseJSON(result), "p", "div.col-lg-9");
                });

                /**
                 * Callback for error response
                 */
                request.fail(function (jqXHR, status, error) {
                    console.error(status, error); //TODO must create a dialog popup
                });
            });
        },

        /**
         * Create DOM nodes with text, class and appends them to elementAppend
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
         */
        showFiles: function () {
            $(".large-image").attr("src", "/img/default.png");
            $(".uploader-inline, .large-image").hide();
            $(".gallery-view").find("figure.centered").not(".large-image").remove();
            $(".gallery-view, .ajax-loader").show();

            ajaxImageUpload.abourtXHR(request);

            request = $.get("/learn-zf2-ajax-image-gallery/index/files", function (files) {
                $(".ajax-loader").hide();
                $(".large-image").show();
                $.each(files["files"], function (key, imgFile) {
                    $("div.image-grid").append("<figure class='centered'><i class='glyphicon glyphicon-remove deleteimg'></i><img aria-checked='false' aria-label='"+imgFile["filename"]+"' src='"+imgFile["filelink"]+"' class='thumbnail' alt='"+imgFile["filename"]+"' title='"+imgFile["filename"]+"' /></figure>");
                });
                ajaxImageUpload.viewImage();
                ajaxImageUpload.deleteImage();
            });
        },

        /**
         * The big image on the right, next to thumbnails
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
         */
        deleteImage: function () {
            ajaxImageUpload.abourtXHR(request);

            $(".deleteimg").on("click", function (event) {
                event.preventDefault();
                request = $.post("/learn-zf2-ajax-image-gallery/index/deleteimage", {"img": $(this).next("img").attr("src")}, function() {
                    ajaxImageUpload.showFiles();
                });
            });
        },

        /**
         * Abort every previous AJAX request if new is made.
         * The method will abort on both client and server sides.
         */
        abourtXHR: function (xhr) {
            if (xhr && xhr.readystate != 4) {
                xhr.abort();
                xhr = null;
            }
        }
    };

    $(doc).ready(function ($) {
        'use strict';
        ajaxImageUpload.init();
    });
})(this, document, jQuery);