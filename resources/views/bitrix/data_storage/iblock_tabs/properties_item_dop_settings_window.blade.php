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
                    <div class="form-group"
                         data-for_type_ids="_FOR_ALL_">
                        <label class="col-md-3">Подсказка:</label>
                        <div class="col-md-9">
                            <input type="text"
                                   name="properties[HINT][{{$i}}]"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="_FOR_ALL_">
                        <label class="col-md-3">Значения свойства участвуют в поиске:</label>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           name="properties[SEARCHABLE][{{$i}}]"
                                           value="Y">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="L">
                        <label class="col-md-3">Внешний вид:</label>
                        <div class="col-md-9">
                            <select name="properties[LIST_TYPE][{{$i}}]"
                                    class="form-control">
                                <option value="">Выберите</option>
                                <option value="L">Список</option>
                                <option value="C">Флажки
                                </option>
                            </select>
                        </div>
                    </div>
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
                    <div class="form-group"
                         data-for_type_ids="S S:HTML N">
                        <label class="col-md-3">Значение по умолчанию:</label>
                        <div class="col-md-9">
                            <input type="text"
                                   name="properties[DEFAULT_VALUE][{{$i}}]"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="F">
                        <label class="col-md-3">Типы загружаемых файлов (расширения через запятую):</label>
                        <div class="col-md-9">
                            <input type="text"
                                   name="properties[FILE_TYPE][{{$i}}]"
                                   class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>