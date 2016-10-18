<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="infoblok_prop_dop_settings_window_{{$i}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix_admin_options.additional_settings_title') }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                  {{--  <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <div class="col-md-offset-3 col-md-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           name="PROPERTY_SEARCHABLE"
                                           value="Y">
                                    Значения свойства участвуют в поиске:
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <div class="col-md-offset-3 col-md-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           id="PROPERTY_FILTRABLE_Y"
                                           name="PROPERTY_FILTRABLE"
                                           value="Y">
                                    Выводить на странице списка элементов поле для фильтрации по этому свойству:
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <div class="col-md-offset-3 col-md-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           id="PROPERTY_WITH_DESCRIPTION_Y"
                                           name="PROPERTY_WITH_DESCRIPTION"
                                           value="Y">
                                    Выводить поле для описания значения:
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <label class="col-md-3"
                               for="PROPERTY_MULTIPLE_CNT">Количество полей для ввода новых множественных значений:
                        </label>
                        <div class="col-md-9">
                            <input type="text"
                                   id="PROPERTY_MULTIPLE_CNT"
                                   name="PROPERTY_MULTIPLE_CNT"
                                   placeholder="5"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <label class="col-md-3">Подсказка:</label>
                        <div class="col-md-9">
                            <input type="text"
                                   id="PROPERTY_HINT"
                                   name="PROPERTY_HINT"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <div class="col-md-offset-3 col-md-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           id="PROPERTY_SECTION_PROPERTY_Y"
                                           name="PROPERTY_SECTION_PROPERTY"
                                           value="Y">
                                    Показывать на странице редактирования элемента:
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <label class="col-md-3">Размер поля для ввода значения (Строк х Столбцов):</label>
                        <div class="col-md-4">
                            <input type="text"
                                   name="PROPERTY_ROW_COUNT"
                                   placeholder="1"
                                   class="form-control">
                        </div>
                        <div class="col-md-1">x</div>
                        <div class="col-md-4">
                            <input type="text"
                                   name="PROPERTY_COL_COUNT"
                                   placeholder="30"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <label class="col-md-3">Значение по умолчанию:</label>
                        <div class="col-md-9">
                            <input type="text"
                                   name="PROPERTY_DEFAULT_VALUE"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <label class="col-md-3">Внешний вид:</label>
                        <div class="col-md-9">
                            <select id="PROPERTY_LIST_TYPE"
                                    name="PROPERTY_LIST_TYPE"
                                    class="form-control">
                                <option value="">Выберите</option>
                                <option value="L">Список</option>
                                <option value="C">Флажки</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="OLOLO">
                        <label class="col-md-3">Количество строк (для внешнего вида "список"):</label>
                        <div class="col-md-9">
                            <input type="text"
                                   id="PROPERTY_ROW_COUNT"
                                   name="PROPERTY_ROW_COUNT"
                                   placeholder="1"
                                   class="form-control">
                        </div>
                    </div>--}}
                    <div class="form-group"
                         data-for_type_ids="L">
                        <div class="item">
                            <div class="clearfix">
                                <div class="col-md-4">
                                    <b>{{ trans('bitrix_iblocks_form.val_xml_id') }}</b>
                                </div>
                                <div class="col-md-4">
                                    <b>{{ trans('bitrix_iblocks_form.val_value') }}</b>
                                </div>
                                <div class="col-md-2">
                                    <b>{{ trans('bitrix_iblocks_form.val_sort') }}</b>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <br>
                            @if ($property && $property->vals)
                                @foreach($property->vals as $io => $val)
                                    @include('bitrix.data_storage.iblock_tabs.properties_vals', ['val' => $val, 'i' => $i, 'j' => $io])
                                @endforeach
                                @for($j = count($property->vals); $j<=count($property->vals)+5; $j++)
                                    @include('bitrix.data_storage.iblock_tabs.properties_vals', ['val' => null, 'i' => $i, 'j' => $j])
                                @endfor
                            @else
                                @for($j = 0; $j<=5; $j++)
                                    @include('bitrix.data_storage.iblock_tabs.properties_vals', ['val' => null, 'i' => $i, 'j' => $j])
                                @endfor
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>