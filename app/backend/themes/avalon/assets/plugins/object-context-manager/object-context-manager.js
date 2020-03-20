/**
 * Created by extead on 07.05.15.
 */

;(function($) {
    var options = null;

    var elem_interface;
    var elem_modals;
    var elem_data;
    var selectedImages = [];

    var methods = {
        init: function(settings) {
            options = $.extend({}, $.fn.objectContextManager.defaults, settings);

            var self = this,
                that = $(this),
                id   = that.attr('id');

            if (id === undefined || id === '') {
                id = methods._hash.call(self);

                that.attr('id', id);
            }

            that.append($('<div class="object-context-interface">'));
            $("body").append($('<div class="object-context-modals">'));
            that.append($('<div class="object-context-data">'));

            elem_interface = that.find(".object-context-interface");
            elem_modals = $("body").find(".object-context-modals");
            elem_data = that.find(".object-context-data");

            methods._removeElements();
            methods._loadBaseImages();
            methods._processImagesContainers();
            methods._loadBasePlanningImages();
            methods._processPlanningImagesContainers();
            methods._loadBaseDocuments();
            methods._processDocumentsContainers();
            methods._render();
            methods._bindFormChanges();

            $('.selection_control').show();
        },

        _hash: function() {
            this.hash = 'flats-' + Math.random().toString().substring(2);

            return this.hash;
        },

        _rand: function() {
            return Math.floor(Math.random() * 26) + Date.now();
        },

        _removeElements: function() {
            $(".tab-pane#images .control").remove();
            $(".tab-pane#documents .control").remove();
            $(".tab-pane#planning_images .control").remove();
        },

        _checkHasSelectedImages: function() {
            if ($("#image-grid .image_row [data-image-attribute='true'][name*='"+options.formName+"']").length == 0) {
                $("#image-grid").append($('<input type="hidden" name="'+options.formName+'[images]" value=""/>'));
            } else {
                $("[name='"+options.formName+"[images]']").remove();
            }
        },

        _checkHasSelectedPlanningImages: function() {
            if ($("#planning-image-grid .image_row [data-image-attribute='true'][name*='"+options.formName+"']").length == 0) {
                $("#planning-image-grid").append($('<input type="hidden" name="'+options.formName+'[planning_images]" value=""/>'));
            } else {
                $("[name='"+options.formName+"[planning_images]']").remove();
            }
        },

        _loadBaseImages: function() {
            $('#image-grid').empty();
            $.each(options.imagesHtmlData, function(file_name, image) {
                var $el = $('<div class="row image_row m-xs" data-widget="{\"id\":\"'+Math.random().toString(36).substr(2, 9)+'\"}"/>').html(image);
                $('#image-grid').append($el);
            });
            methods._checkHasSelectedImages();
        },

        _loadBasePlanningImages: function() {
            if(!options.planningImagesHtmlData) return;
            $('#planning-image-grid').empty();
            $.each(options.planningImagesHtmlData, function(file_name, image) {
                var $el = $('<div class="row image_row m-xs"/>').html(image);
                $('#planning-image-grid').append($el);
            });
            methods._checkHasSelectedPlanningImages();
        },

        _processImagesContainers: function() {
            $(".tab-pane#images #image-grid .image_row .panel-heading .panel-ctrls").empty();

            $("#image-grid .image_row").each(function(id, elem) {
                if ($(elem).find("[data-image-attribute='true'][name*='FAKE']").length > 0) {
                    $(elem).find(".panel-ctrls").append('<a href="#" style="color: red" data-action="image_select">Использовать для текущего сайта  <i class="fa fa-square-o"></i></a>');
                    $(elem).find("[data-image-attribute='true']").prop('readonly', true);
                } else {
                    $(elem).find(".panel-ctrls").append('<a href="#" style="color: green" data-action="image_select">Использовать для текущего сайта  <i class="fa fa-check-square-o"></i></a>');
                }
            });

            $("#image-grid .image_row .panel-ctrls a[data-action='image_select']").on('click', function(event) {
                event.preventDefault();
                var row_elem = $(this).closest(".image_row");
                if ($(row_elem).find("[data-image-attribute='true'][name*='FAKE']").length > 0) {
                    $(this).css("color", "green");
                    $(this).find("i").removeClass("fa-square-o");
                    $(this).find("i").addClass("fa-check-square-o");

                    $(row_elem).find("[data-image-attribute='true']").prop('readonly', false);
                    $(row_elem).find("[data-image-attribute='true']").each(function(key, element) {
                        old_name = $(element).attr('name');
                        new_name = old_name.replace('FAKE', options.formName);
                        $(element).attr('name', new_name);
                    });

                } else {
                    $(this).css("color", "red");
                    $(this).find("i").removeClass("fa-check-square-o");
                    $(this).find("i").addClass("fa-square-o");
                    $(row_elem).find("[data-image-attribute='true']").prop('readonly', true);
                    $(row_elem).find("[data-image-attribute='true']").each(function(key, element) {
                        old_name = $(element).attr('name');
                        new_name = old_name.replace(options.formName, 'FAKE');
                        $(element).attr('name', new_name);
                    });
                }
                methods._checkHasSelectedImages();
            });



        },

        _processPlanningImagesContainers: function() {
            $(".tab-pane#planning_images #planning-image-grid .image_row .panel-heading .panel-ctrls").empty();

            $("#planning-image-grid .image_row").each(function(id, elem) {
                if ($(elem).find("[data-image-attribute='true'][name*='FAKE']").length > 0) {
                    $(elem).find(".panel-ctrls").append('<a href="#" style="color: red" data-action="planning_image_select">Использовать для текущего сайта  <i class="fa fa-square-o"></i></a>');
                    $(elem).find("[data-image-attribute='true']").prop('readonly', true);
                } else {
                    $(elem).find(".panel-ctrls").append('<a href="#" style="color: green" data-action="planning_image_select">Использовать для текущего сайта  <i class="fa fa-check-square-o"></i></a>');
                }
            });

            $("#planning-image-grid .image_row .panel-ctrls a[data-action='planning_image_select']").on('click', function(event) {
                event.preventDefault();
                var row_elem = $(this).closest(".image_row");
                if ($(row_elem).find("[data-image-attribute='true'][name*='FAKE']").length > 0) {
                    $(this).css("color", "green");
                    $(this).find("i").removeClass("fa-square-o");
                    $(this).find("i").addClass("fa-check-square-o");

                    $(row_elem).find("[data-image-attribute='true']").prop('readonly', false);
                    $(row_elem).find("[data-image-attribute='true']").each(function(key, element) {
                        old_name = $(element).attr('name');
                        new_name = old_name.replace('FAKE', options.formName);
                        $(element).attr('name', new_name);
                    });

                } else {
                    $(this).css("color", "red");
                    $(this).find("i").removeClass("fa-check-square-o");
                    $(this).find("i").addClass("fa-square-o");
                    $(row_elem).find("[data-image-attribute='true']").prop('readonly', true);
                    $(row_elem).find("[data-image-attribute='true']").each(function(key, element) {
                        old_name = $(element).attr('name');
                        new_name = old_name.replace(options.formName, 'FAKE');
                        $(element).attr('name', new_name);
                    });
                }
                methods._checkHasSelectedPlanningImages();
            });



        },

        _checkHasSelectedDocuments: function() {
            if ($("#document-grid .document_row [data-document-attribute='true'][name*='"+options.formName+"']").length == 0) {
                $("#document-grid").append($('<input type="hidden" name="'+options.formName+'[documents]" value=""/>'));
            } else {
                $("[name='"+options.formName+"[documents]']").remove();
            }
        },

        _loadBaseDocuments: function() {
            if(!options.documentsHtmlData) return;
            
            $('#document-grid').empty();
            $.each(options.documentsHtmlData, function(file_name, document) {
                var $el = $('<div class="row document_row m-xs"/>').html(document);
                $('#document-grid').append($el);
            });
            methods._checkHasSelectedDocuments();
        },

        _processDocumentsContainers: function() {
            $(".tab-pane#documents #document-grid .document_row .panel-heading .panel-ctrls").empty();

            $("#document-grid .document_row").each(function(id, elem) {
                if ($(elem).find("[data-document-attribute='true'][name*='FAKE']").length > 0) {
                    $(elem).find(".panel-ctrls").append('<a href="#" style="color: red" data-action="document_select">Использовать для текущего сайта  <i class="fa fa-square-o"></i></a>');
                    $(elem).find("[data-document-attribute='true']").prop('readonly', true);
                } else {
                    $(elem).find(".panel-ctrls").append('<a href="#" style="color: green" data-action="document_select">Использовать для текущего сайта  <i class="fa fa-check-square-o"></i></a>');
                }
            });

            $("#document-grid .document_row .panel-ctrls a[data-action='document_select']").on('click', function(event) {
                event.preventDefault();
                var row_elem = $(this).closest(".document_row");
                if ($(row_elem).find("[data-document-attribute='true'][name*='FAKE']").length > 0) {
                    $(this).css("color", "green");
                    $(this).find("i").removeClass("fa-square-o");
                    $(this).find("i").addClass("fa-check-square-o");

                    $(row_elem).find("[data-document-attribute='true']").prop('readonly', false);
                    $(row_elem).find("[data-document-attribute='true']").each(function(key, element) {
                        old_name = $(element).attr('name');
                        new_name = old_name.replace('FAKE', options.formName);
                        $(element).attr('name', new_name);
                    });

                } else {
                    $(this).css("color", "red");
                    $(this).find("i").removeClass("fa-check-square-o");
                    $(this).find("i").addClass("fa-square-o");
                    $(row_elem).find("[data-document-attribute='true']").prop('readonly', true);
                    $(row_elem).find("[data-document-attribute='true']").each(function(key, element) {
                        old_name = $(element).attr('name');
                        new_name = old_name.replace(options.formName, 'FAKE');
                        $(element).attr('name', new_name);
                    });
                }
                methods._checkHasSelectedDocuments();
            });



        },

        _highlight: function() {
            var data = $("#object-form").serialize();

            $.ajax({
                url: options.compareUrl,
                dataType: "JSON",
                method: "POST",
                data: data
            }).done(function(data) {
                $("*").removeClass("object-context-changed");
                if (data) {
                    $.each(data, function(id, value) {
                        field_name = options.formName+"["+id+"]";

                        if (id == 'images' || id == 'flats' || id == 'documents' || id == 'planning_images') {
                            elem = $("[name*='"+field_name+"']").closest(".tab-content").closest(".panel").find(".panel-heading li a[href='#"+id+"']");

                        } else {
                            elem = $("[name*='"+field_name+"']").closest(".form-group");
                        }

                        $(elem).addClass("object-context-changed");
                    });
                }

            });
        },

        _render: function() {
            methods._highlight();
        },

        _bindFormChanges: function() {
            $("#object-form, input, select").on("change", function() {
                methods._highlight();
            });
        },

    };


    $.fn.objectContextManager = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist!');
        }
    };

    $.fn.objectContextManager.defaults = {
        formName: null,
        compareUrl: null,
        imagesHtmlData: null,
        planningImagesHtmlData: null,
        documentHtmlData: null
    };

    })(jQuery);
