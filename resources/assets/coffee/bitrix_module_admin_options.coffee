# показ модального окна с доп. настройками
$('.options .modal').on 'show.bs.modal', (event) ->
	button = $(event.relatedTarget)
	row = button.parents(".row.option")
	type_id = row.find("[name *= _type]").val()
	modal_form = row.next(button.attr('data-target'))

	# скрываем все поля
	modal_form.find('.form-group').hide()
	# показываем поля доступные для этого типа поля
	modal_form.find('[data-for_type_ids ~= "' + type_id + '"]').show()
	# блокируем исключающиеся варианты, если нужно
	modal_form.find(".only-one input:not([type=radio])").prop("disabled", true)
	if (!modal_form.find(".only-one input[type=radio]:checked").length)
		modal_form.find(".only-one input[type=radio]:first").click()
	else
		modal_form.find(".only-one input[type=radio]:checked").parents(".item").find("input:not([type=radio])").prop("disabled",
			false)

	return


# блокировка и разблокировка вариантов опшионов у свойств - списков
$(document).on "change", ".options .modal .only-one [type=radio]", () ->
	item = $(this).parents(".item")
	items = $(".only-one .item")
	items.each(() ->
		$(this).find("input:not([type=radio])").prop("disabled", true)
	)
	item.find("input:not([type=radio])").prop("disabled", false)

	return

$(document).on "click", ".add-dop-row", () ->
    row = $(this).parents('.row.overlast-row')
    number = Number($('.sort-val:last').val()) + 1
    module_id = $('[name=module_id\\[\\]]').val()
    newRow = "<div class='row option '>
    <input type='hidden' name='module_id[]' value='#{module_id}'>
    <input type='hidden' class='sort-val' name='option_sort[]' value='#{number}'>
    <div class='col-md-3'>
        <label class='sr-only' for='option_#{number}_id'>Код</label>
        <input type='text' class='form-control' name='option_code[]' id='option_#{number}_id' placeholder='Код' value=''>
    </div>
    <div class='col-md-3'>
        <label class='sr-only' for='option_#{number}_name'>Название</label>
        <input type='text' class='form-control' name='option_name[]' id='option_#{number}_name' placeholder='Название' value=''>
    </div>
    <div class='col-md-2'>
        <label class='sr-only' for='option_#{number}_type'>Тип</label>
        <select class='form-control' name='option_type[]' id='option_#{number}_type'>
            <option value='1'>Строка</option>
            <option value='2'>Многострочный текст</option>
            <option value='3'>Селект</option>
            <option value='4'>Множественный селект</option>
            <option value='5'>Чекбокс</option>
        </select>
    </div>
    <div class='col-md-2'>
        <a href='#' class='btn btn-default' data-toggle='modal' data-target='#admin_options_dop_settings_window_6'>Редактировать</a>
        <div class='modal fade' tabindex='-1' role='dialog' id='admin_options_dop_settings_window_6'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span
                                    aria-hidden='true'>×</span></button>
                        <h4 class='modal-title'>Дополнительные настройки</h4>
                    </div>
                    <div class='modal-body'>
                        <div class='form-group' data-for_type_ids='2'>
                            <label for='option_#{number}_height'>Высота</label>
                            <input class='form-control' type='text' name='option_height[]' id='option_#{number}_height'>
                        </div>
                        <div class='form-group' data-for_type_ids='1,2'>
                            <label for='option_#{number}_width'>Ширина</label>
                            <input class='form-control' type='text' name='option_width[]' id='option_#{number}_width'>
                        </div>
                        <div class='form-group' data-for_type_ids='5'>
                            <label for='option_#{number}_spec_args'>Значение</label>
                            <input class='form-control' type='text' name='option_#{number}_spec_args[]' id='option_#{number}_spec_args'>
                        </div>
                        <div class='form-group only-one' data-for_type_ids='3,4'>
                            <div class='item'>
                                <label>
                                    <input type='radio' name='option_#{number}_vals_type' value='array'>
                                    <b>Конкретные значения</b>
                                </label>
                                <div class='row'>
                                    <div class='col-md-5'>
                                        <input class='form-control' type='text' name='option_0_vals_key[]'>
                                    </div>
                                    <div class='col-md-1'>=&gt;</div>
                                    <div class='col-md-6'>
                                        <input class='form-control' type='text' name='option_0_vals_value[]'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-5'>
                                        <input class='form-control' type='text' name='option_1_vals_key[]'>
                                    </div>
                                    <div class='col-md-1'>=&gt;</div>
                                    <div class='col-md-6'>
                                        <input class='form-control' type='text' name='option_1_vals_value[]'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-5'>
                                        <input class='form-control' type='text' name='option_2_vals_key[]'>
                                    </div>
                                    <div class='col-md-1'>=&gt;</div>
                                    <div class='col-md-6'>
                                        <input class='form-control' type='text' name='option_2_vals_value[]'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-5'>
                                        <input class='form-control' type='text' name='option_3_vals_key[]'>
                                    </div>
                                    <div class='col-md-1'>=&gt;</div>
                                    <div class='col-md-6'>
                                        <input class='form-control' type='text' name='option_3_vals_value[]'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-5'>
                                        <input class='form-control' type='text' name='option_4_vals_key[]'>
                                    </div>
                                    <div class='col-md-1'>=&gt;</div>
                                    <div class='col-md-6'>
                                        <input class='form-control' type='text' name='option_4_vals_value[]'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-5'>
                                        <input class='form-control' type='text' name='option_5_vals_key[]'>
                                    </div>
                                    <div class='col-md-1'>=&gt;</div>
                                    <div class='col-md-6'>
                                        <input class='form-control' type='text' name='option_5_vals_value[]'>
                                    </div>
                                </div>
                            </div>
                            <div>или</div>
                            <div class='item'>
                                <label>
                                    <input type='radio' name='option_#{number}_vals_type' value='iblocks_list'>
                                    <b>Список инфоблоков</b>
                                </label>
                            </div>
                            <div>или</div>
                            <div class='item'>
                                <label>
                                    <input type='radio' name='option_#{number}_vals_type' value='iblock_items_list'>
                                    <b>Список элементов инфоблока</b>
                                </label>
                                <input type='text' name='option_#{number}_spec_args[]' class='form-control'
                                       placeholder='Инфоблок'>
                            </div>
                            <div>или</div>
                            <div class='item'>
                                <label>
                                    <input type='radio' name='option_#{number}_vals_type' value='iblock_props_list'>
                                    <b>Список свойств инфоблока</b>
                                </label>
                                <input type='text' name='option_#{number}_spec_args[]' class='form-control'
                                       placeholder='Инфоблок'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-2'>
    </div>
</div>"

    row.before(newRow)

    return false