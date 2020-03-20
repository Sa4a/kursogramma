/**
 * Created by extead on 11.03.15.
 */

;(function($) {
    var options = null;
    var housingData = null;

    var elem_interface;
    var elem_modals;
    var elem_data;

    var rand_number = 0;

    var methods = {
        init: function(settings) {
            options = $.extend({}, $.fn.flatsManager.defaults, settings);

            var self = this,
                that = $(this),
                id   = that.attr('id');

            if (id === undefined || id === '') {
                id = methods._hash.call(self);

                that.attr('id', id);
            }

            housingData = methods._groupData(options.flatsData);

            that.append($('<div class="flats-manager-interface">'));
            $("body").append($('<div class="flats-manager-modals">'));
            that.append($('<div class="flats-manager-data">'));

            elem_interface = that.find(".flats-manager-interface");
            elem_modals = $("body").find(".flats-manager-modals");
            elem_data = that.find(".flats-manager-data");

            methods._render();
            methods._renderModal();
        },

        _hash: function() {
            this.hash = 'flats-' + Math.random().toString().substring(2);

            return this.hash;
        },

        _rand: function() {
            return rand_number++;
        },

        _groupData: function(data) {
            var groupedData = {};

            $.each(data, function (i, v) {
                var key = $.md5(v.housing);
                if (groupedData[key] == undefined) {
                    groupedData[key] = {
                        'id': key,
                        'construction_completed': v.construction_completed,
                        'construction_stage': v.construction_stage,
                        'completion_quarter': v.completion_quarter,
                        'completion_year': v.completion_year,
                        'housing': v.housing,
                        'flats': {}
                    };
                }
                v.id = methods._rand();
                groupedData[key]['flats'][v.id] = v;
            });

            return groupedData;
        },

        _renderInputs: function() {
            //Выводим таблицы
            elem_data.empty();
            var counter = 0;
            var formName = options.formName;
            var attributeName = options.attributeName;

            $.each(housingData, function (i, housing) {

                $.each(housing['flats'], function (iflat, flat) {
                    var inputBaseName = formName + "[" + attributeName + "]" + "[" + flat['id'] + "]";

                    $.each(flat, function (attr, val) {
                        if (attr == 'id') return true;

                        if (attr == 'construction_completed' || attr == 'completion_quarter' || attr == 'completion_year' || attr == 'construction_stage') {
                            val = housing[attr];
                        }

                        var inputName = inputBaseName + "[" + attr + "]";
                        elem_data.append($('<input type="hidden" name="' + inputName + '" value="' + val + '">'));
                        counter++;
                    });
                });
            });

            //Квартир нет
            if (counter == 0) {
                var inputName = formName + "[" + attributeName + "]";
                elem_data.append($('<input type="hidden" name="' + inputName + '" value="">'));
            }

        },

        _renderModal: function() {
            //Выводим модальное окно для добавления/редактирования квартир

            var typeSelectOptions = '';
            var sub_typeSelectOptions = '';

            $.each(options.dictionary['type'], function(id, val) {
                typeSelectOptions += '<option value="'+id+'">'+val+'</option>';
            });

            $.each(options.dictionary['sub_type'], function(id, val) {
                sub_typeSelectOptions += '<option value="'+id+'">'+val+'</option>';
            });

            elem_modals.append($('<div class="modal fade" id="flats-manager-flat-modal">\
                                <div class="modal-dialog">\
                                    <div class="modal-content">\
                                        <div class="modal-header">\
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                                            <h4 class="modal-title">Modal title</h4>\
                                        </div>\
                                    <div class="modal-body">\
                                        <form class="form-horizontal">\
                                            <div class="form-group required">\
                                                <label for="type" class="col-sm-3 control-label">Предложение</label>\
                                                <div class="col-sm-8">\
                                                    <select class="form-control" id="type" name="sub_type">'+sub_typeSelectOptions+'</select>\
                                                </div>\
                                                <div class="col-sm-1">\
                                                    <p class="help-block"></p>\
                                                </div>\
                                            </div>\
                                            <div class="form-group required">\
                                                <label for="type" class="col-sm-3 control-label">Тип</label>\
                                                <div class="col-sm-8">\
                                                    <select class="form-control" id="type" name="type">'+typeSelectOptions+'</select>\
                                                </div>\
                                                <div class="col-sm-1">\
                                                    <p class="help-block"></p>\
                                                </div>\
                                            </div>\
                                            <div class="form-group required">\
                                                <label for="area_min" class="col-sm-3 control-label">Общая площадь мин.</label>\
                                                <div class="col-sm-8">\
                                                    <input type="text" class="form-control" id="area_min" name="area_min" required>\
                                                </div>\
                                                <div class="col-sm-1">\
                                                    <p class="help-block"></p>\
                                                </div>\
                                            </div>\
                                            <div class="form-group required">\
                                                <label for="area_max" class="col-sm-3 control-label">Общая площадь макс.</label>\
                                                <div class="col-sm-8">\
                                                    <input type="text" class="form-control" id="area_max" name="area_max" required>\
                                                </div>\
                                                <div class="col-sm-1">\
                                                    <p class="help-block"></p>\
                                                </div>\
                                                </div>\
                                                <div class="form-group required">\
                                                    <label for="price_min" class="col-sm-3 control-label">Цена за квартиру мин.</label>\
                                                    <div class="col-sm-8">'
                                                    +options.autoNumericFields['price_min']+
                                                    '</div>\
                                                    <div class="col-sm-1">\
                                                        <p class="help-block"></p>\
                                                    </div>\
                                                </div>\
                                                <div class="form-group">\
                                                    <label for="price_max" class="col-sm-3 control-label">Цена за квартиру макс.</label>\
                                                    <div class="col-sm-8">'
                                                    +options.autoNumericFields['price_max']+
                                                    '</div>\
                                                    <div class="col-sm-1">\
                                                        <p class="help-block"></p>\
                                                    </div>\
                                                </div>\
                                                <div class="form-group">\
                                                    <label for="square_meter_price_min" class="col-sm-3 control-label">Цена за м<sup>2</sup> мин.</label>\
                                                    <div class="col-sm-8">'
                                                    +options.autoNumericFields['square_meter_price_min']+
                                                    '</div>\
                                                    <div class="col-sm-1">\
                                                        <p class="help-block"></p>\
                                                    </div>\
                                                </div>\
                                                <div class="form-group">\
                                                    <label for="square_meter_price_max" class="col-sm-3 control-label">Цена за м<sup>2</sup> макс.</label>\
                                                    <div class="col-sm-8">'
                                                    +options.autoNumericFields['square_meter_price_max']+
                                                    '</div>\
                                                <div class="col-sm-1">\
                                                    <p class="help-block"></p>\
                                                </div>\
                                            </div>\
                                            <input type="hidden" id="housing_id" name="housing_id">\
                                            <input type="hidden" id="id" name="id">\
                                        </form>\
                                    </div>\
                                    <div class="modal-footer">\
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>\
                                        <button type="button" class="btn btn-primary flats-manager-flat-modal-save-button">Сохранить</button>\
                                    </div>\
                                    </div>\
                                    </div>\
                                </div>'
            ));

            methods._bindFlatFormValidation();
            methods._bindModalSaveButton();

        },
        _render: function() {
            elem_interface.empty();

            //Выводим таблицы
            $.each(housingData, function(i, v) {
                var housing = $('<div></div>');

                housing.addClass('housing');
                housing.attr('id', v.id);

                var constructionStageSelectOptions = '<option value="">Не указано</option>';

                $.each(options.dictionary['construction_stage'], function(id, val) {
                    constructionStageSelectOptions += '<option '+((v.construction_stage == id) ? "selected" : "")+' value="'+id+'">'+val+'</option>';
                });

                var completionQuarterSelectOptions = '<option value="">Не указано</option>';

                $.each(options.dictionary['completion_quarter'], function(id, val) {
                    completionQuarterSelectOptions += '<option '+((v.completion_quarter == id) ? "selected" : "")+' value="'+id+'">'+val+'</option>';
                });

                var constructionCompletedSelectOptions = '';

                $.each(options.dictionary['construction_completed'], function(id, val) {
                    constructionCompletedSelectOptions += '<option '+((v.construction_completed == id) ? "selected" : "")+' value="'+id+'">'+val+'</option>';
                });

                var completionYearSelectOptions = '<option value="">Не указано</option>';

                $.each(options.dictionary['completion_year'], function(id, val) {
                    completionYearSelectOptions += '<option '+((v.completion_year == id) ? "selected" : "")+' value="'+id+'">'+val+'</option>';
                });

                housing.append('<div class="panel panel-default" id="panel-editable"> \
                                    <div class="panel-heading"> \
                                        <h2>'+ v.housing +'</h2> \
                                        <div class="panel-ctrls">\
                                        <a href="#" data-housing-id="'+v.id+'" class="flats-manager-housing-remove-button"><i class="fa fa-remove"></i></a>\
                                        </div>\
                                    </div> \
                                    <div class="panel-body"> \
                                        <div class="row" style="padding-bottom: 10px;">\
                                        <div class="col-md-6">\
                                            <div class="row">\
                                                <label class="control-label">Срок сдачи</label>\
                                            </div>\
                                            <div class="row">\
                                                <div class="col-md-4">\
                                                    <div class="form-group">\
                                                        <select data-housing-id="'+v.id+'" name="housing-completion_quarter" class="form-control">'
                                                        +completionQuarterSelectOptions+
                                                        '</select>\
                                                    </div> \
                                                </div>\
                                                <div class="col-md-1">\
                                                    <label class="control-label">кв.</label>\
                                                </div>\
                                                <div class="col-md-4">\
                                                    <div class="form-group">\
                                                        <select data-housing-id="'+v.id+'" name="housing-completion_year" class="form-control">'
                                                        +completionYearSelectOptions+
                                                        '</select>\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-3">\
                                                    <label class="control-label">года</label>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-6">\
                                            <div class="row">\
                                                <div class="col-md-4">\
                                                    <div class="form-group">\
                                                        <label class="control-label">Сдан</label>\
                                                        <select data-housing-id="'+v.id+'" name="housing-construction_completed" class="form-control">'
                                                                +constructionCompletedSelectOptions+
                                                        '</select>\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-1">\
                                                </div>\
                                                <div class="col-md-7">\
                                                    <div class="form-group">\
                                                        <label class="control-label">Стадия строительства</label>\
                                                        <select data-housing-id="'+v.id+'" name="housing-construction_stage" class="form-control">'
                                                            +constructionStageSelectOptions+
                                                            '</select>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        </div>\
                                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"> \
                                        <thead> \
                                            <tr> \
                                                <th>Предложение</th>\
                                                <th>Тип</th> \
                                                <th>S мин.</th> \
                                                <th>S макс.</th> \
                                                <th>Цена за кв. мин.</th> \
                                                <th>Цена за кв. макс.</th> \
                                                <th>Цена за м<sup>2</sup> мин.</th> \
                                                <th>Цена за м<sup>2</sup> макс.</th> \
                                                <th></th> \
                                            </tr> \
                                            </thead> \
                                            <tbody>\
                                            \
                                            </tbody>\
                                        </table> \
                                        <div class="panel-footer">\
                                        <button data-housing-id="'+v.id+'" class="btn btn-sm btn-info flats-manager-flat-add-button"><i class="fa fa-plus"></i> Добавить квартиру</button>\
                                        </div>\
                                    </div> \
                                </div>');

                $.each(v.flats, function(flat_index, flat) {
                    var flat_element = $('<tr><td>'+options.dictionary['sub_type'][flat.sub_type]+'</td>' +
                        '<td>'+options.dictionary['type'][flat.type]+'</td>\
                                                <td>'+flat.area_min+'</td><td>'+flat.area_max+'</td>\
                                                <td>'+flat.price_min+'</td>\
                                                <td>'+flat.price_max+'</td>\
                                                <td>'+flat.square_meter_price_min+'</td>\
                                                <td>'+flat.square_meter_price_max+'</td>\
                                                <td>\
                                                    <div class="btn-group">\
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">\
                                                            <i class="fa fa-bars fa-fw"></i> <span class="caret"></span>\
                                                        </button>\
                                                        <ul class="dropdown-menu" role="menu">\
                                                        <li><a href="#" data-housing-id="'+v.id+'" data-id="'+flat.id+'" class="flats-manager-flat-update-button"><i class="fa fa-pencil"></i> Редактировать</a></li>\
                                                        <li><a href="#" data-housing-id="'+v.id+'" data-id="'+flat.id+'" class="flats-manager-flat-remove-button"><i class="fa fa-remove"></i> Удалить</a></li>\
                                                        </ul>\
                                                    </div>\
                                                </td></tr>');
                    housing.find("table tbody").append(flat_element);
                });

                elem_interface.append(housing);
            });

            //Выводим кнопку добавления корпуса
            elem_interface.append($('<div class="row">\
                                <div class="col-md-3">\
                                    <div class="input-group">\
                                        <span class="input-group-addon">\
                                            Название корпуса:\
                                        </span>\
                                        <input id="flats-manager-housing" class="form-control" />\
                                    </div>\
                                </div>\
                                <div class="col-md-2">\
                                    <button id="flats-manager-housing-add-button" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Добавить корпус</button>\
                                </div>\
                                </div>'
            ));

            methods._renderInputs();

            methods._bindAddHousing();
            methods._bindRemoveHousing();
            methods._bindAddFlat();
            methods._bindUpdateFlat();
            methods._bindRemoveFlat();
            methods._bindUpdateHousing();

        },

        _bindFlatFormValidation: function() {
            $.validator.addMethod('le', function(value, element, param) {
                return this.optional(element) || parseInt(value) <= parseInt($(param).val());
            }, 'Invalid value');

            $.validator.addMethod('ge', function(value, element, param) {
                return this.optional(element) || parseInt(value) >= parseInt($(param).val());
            }, 'Invalid value');

            elem_modals.find("#flats-manager-flat-modal form").validate({
                    lang: 'ru',
                    ignore: "", //Для работы валидации скрытых полей
                    rules: {
                        "price_min": {
                            required: true
                        },
                        area_max: {ge: '#area_min'},
                        price_max: {ge: '#price_min'},
                        square_meter_price_max: {ge: '#square_meter_price_min'}
                    },

                    messages: {
                        area_max: {ge: 'Должна быть больше или равна Общая площадь мин.'},
                        price_max: {ge: 'Должна быть больше или равна Цена за квартиру мин.'},
                        square_meter_price_max: {ge: 'Должна быть больше или равна Цена за м<sup>2</sup> мин.'}
                    },

                    highlight: function(element) {
                        $(element).closest('.form-group').addClass("has-error");
                    },
                    unhighlight: function(element) {
                        $(element).closest('.form-group').removeClass("has-error");
                    },
                    errorElement: "p",
                    errorClass: "help-block help-block-error"
            });
        },


        _bindAddHousing: function() {

            elem_interface.find("#flats-manager-housing-add-button").on('click', function() {
                var housing_name = elem_interface.find("#flats-manager-housing").val();
                var key = $.md5($.trim(housing_name));
                if (housingData[key] != undefined) {
                    alert("Корпус с таким обозначением уже существует.");
                    return false;
                }
                var housing = {
                    'id': key,
                    'construction_completed': '',
                    'completion_quarter': '',
                    'completion_year': '',
                    'construction_stage': '',
                    'housing': housing_name,
                    'flats': {}
                };
                housingData[key] = housing;
                methods._render();
                showMessageNotSaved();
                return false;
            });
        },

        _bindRemoveHousing: function() {
            elem_interface.find(".flats-manager-housing-remove-button").on('click', function() {
                if (!confirm('Все квартиры в этом корпусе будут удалены. Удалить корпус?')) return false;
                var housing_id = $(this).data('housing-id');
                delete housingData[housing_id];
                methods._render();
                showMessageNotSaved();
                return false;
            });

        },

        _bindAddFlat: function() {
            elem_interface.find(".flats-manager-flat-add-button").on('click', function() {
                elem_modals.find('#flats-manager-flat-modal .modal-title').text('Добавление квартиры');
                elem_modals.find('#flats-manager-flat-modal form').trigger('reset');
                elem_modals.find('#flats-manager-flat-modal form input:hidden').val('');

                var housing_id = $(this).data('housing-id');

                elem_modals.find('#flats-manager-flat-modal [name="housing_id"]').val(housing_id);
                elem_modals.find('#flats-manager-flat-modal [name="id"]').val('');

                elem_modals.find('#flats-manager-flat-modal').modal('show');

                return false;
            });
        },

        _bindUpdateFlat: function() {
            elem_interface.find(".flats-manager-flat-update-button").on('click', function() {
                elem_modals.find('#flats-manager-flat-modal .modal-title').text('Редактирование квартиры');
                var housing_id = $(this).data('housing-id');
                var id = $(this).data('id');

                var flatData = housingData[housing_id]['flats'][id];

                $.each(flatData, function(key, value) {
                    elem_modals.find('#flats-manager-flat-modal [name='+key+']').val(value);
                    //Устанавливаем значение в поля autoNumeric
                    elem_modals.find('#flats-manager-flat-modal [name='+key+'-disp]').autoNumeric('set', value);
                });

                elem_modals.find('#flats-manager-flat-modal [name="id"]').val(id);
                elem_modals.find('#flats-manager-flat-modal [name="housing_id"]').val(housing_id);

                elem_modals.find('#flats-manager-flat-modal').modal('show');

                return false;
            });
        },

        _bindRemoveFlat: function() {
            elem_interface.find(".flats-manager-flat-remove-button").on('click', function() {
                if (!confirm('Удалить квартиру?')) return false;
                var housing_id = $(this).data('housing-id');
                var id = $(this).data('id');

                delete housingData[housing_id]['flats'][id];

                methods._render();

                showMessageNotSaved();
                return false;
            });
        },

        _bindModalSaveButton: function() {
            elem_modals.find("#flats-manager-flat-modal .flats-manager-flat-modal-save-button").on('click', function() {
                if (!elem_modals.find("#flats-manager-flat-modal form").valid()) {
                    return false;
                }

                var serialized = elem_modals.find("#flats-manager-flat-modal form").serializeArray();
                var flat_object = {};

                $.each(serialized, function(i, item) {
                    flat_object[item.name] = item.value;
                });

                var housing_id = flat_object['housing_id'];
                flat_object['id'] = (flat_object['id'] == '') ? methods._rand() : flat_object['id'];
                var id = flat_object['id'];

                delete flat_object['housing_id'];

                flat_object['housing'] = housingData[housing_id]['housing'];
                flat_object['completion_year'] = housingData[housing_id]['completion_year'];
                flat_object['completion_quarter'] = housingData[housing_id]['completion_quarter'];
                flat_object['construction_completed'] = housingData[housing_id]['construction_completed'];
                flat_object['construction_stage'] = housingData[housing_id]['construction_stage'];

                if (id) {
                    housingData[housing_id]['flats'][id] = flat_object;
                } else {
                    housingData[housing_id]['flats'][flat_object['id']] = flat_object;
                }

                elem_modals.find('#flats-manager-flat-modal').on('hidden.bs.modal', function () {
                    methods._render();
                });

                elem_modals.find("#flats-manager-flat-modal").modal('hide');

                showMessageNotSaved();
            });
        },

        _bindUpdateHousing: function() {
            elem_interface.find("[name='housing-construction_completed']").on('change', function(event) {
                var housing_id = $(this).data('housing-id');
                housingData[housing_id]['construction_completed'] = $(this).val();
                methods._renderInputs();
                showMessageNotSaved();
            });
            elem_interface.find("[name='housing-construction_stage']").on('change', function(event) {
                var housing_id = $(this).data('housing-id');
                housingData[housing_id]['construction_stage'] = $(this).val();
                methods._renderInputs();
                showMessageNotSaved();
            });
            elem_interface.find("[name='housing-completion_quarter']").on('change', function(event) {
                var housing_id = $(this).data('housing-id');
                housingData[housing_id]['completion_quarter'] = $(this).val();
                methods._renderInputs();
                showMessageNotSaved();
            });
            elem_interface.find("[name='housing-completion_year']").on('change keyup', function(event) {
                var housing_id = $(this).data('housing-id');
                housingData[housing_id]['completion_year'] = $(this).val();
                methods._renderInputs();
                showMessageNotSaved();
            });


        }

    };


    $.fn.flatsManager = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist!');
        }
    };

    $.fn.flatsManager.defaults = {
        flatsData: null,
        dictionary: null,
        formName: null,
        attributeName: null,
        autoNumericFields: null
    };

    })(jQuery);
