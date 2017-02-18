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
                        <label class="col-md-5">{{ trans('bitrix_iblocks_form.prop_dop_param_hint') }}:</label>
                        <div class="col-md-7">
                            <input type="text"
                                   name="properties[dop_params][{{$i}}][HINT]"
                                   class="form-control"
                                   @if ($property && $property->dop_params && isset($property->dop_params["HINT"]))
                                   value="{{ $property->dop_params["HINT"] }}"
                                    @endif
                            >
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="_FOR_ALL_">
                        <label class="col-md-5">{{ trans('bitrix_iblocks_form.prop_dop_param_searchable') }}:</label>
                        <div class="col-md-7">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           name="properties[dop_params][{{$i}}][SEARCHABLE]"
                                           value="Y"
                                           @if ($property && $property->dop_params && isset($property->dop_params["SEARCHABLE"]) && $property->dop_params["SEARCHABLE"] == "Y")
                                           checked
                                            @endif
                                    >
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="L">
                        <label class="col-md-5">{{ trans('bitrix_iblocks_form.prop_dop_param_list_type') }}:</label>
                        <div class="col-md-7">
                            <select name="properties[dop_params][{{$i}}][LIST_TYPE]"
                                    class="form-control">
                                <option value="">{{ trans('app.select') }}</option>
                                <option value="L"
                                        @if ($property && $property->dop_params && isset($property->dop_params["LIST_TYPE"]) && $property->dop_params["LIST_TYPE"] == "L") selected @endif>
                                    {{ trans('bitrix_iblocks_form.prop_dop_param_list_type_list') }}
                                </option>
                                <option value="C"
                                        @if ($property && $property->dop_params && isset($property->dop_params["LIST_TYPE"]) && $property->dop_params["LIST_TYPE"] == "C") selected @endif>
                                    {{ trans('bitrix_iblocks_form.prop_dop_param_list_type_checkbox') }}
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
                        <label class="col-md-5">{{ trans('bitrix_iblocks_form.prop_dop_param_default') }}:</label>
                        <div class="col-md-7">
                            <input type="text"
                                   name="properties[dop_params][{{$i}}][DEFAULT_VALUE]"
                                   class="form-control"
                                   @if ($property && $property->dop_params && isset($property->dop_params["DEFAULT_VALUE"]))
                                   value="{{ $property->dop_params["DEFAULT_VALUE"] }}"
                                    @endif>
                        </div>
                    </div>
                    <div class="form-group"
                         data-for_type_ids="F">
                        <label class="col-md-5">{{ trans('bitrix_iblocks_form.prop_dop_param_file_type') }}:</label>
                        <div class="col-md-7">
                            <input type="text"
                                   name="properties[dop_params][{{$i}}][FILE_TYPE]"
                                   class="form-control"
                                   @if ($property && $property->dop_params && isset($property->dop_params["FILE_TYPE"]))
                                   value="{{ $property->dop_params["FILE_TYPE"] }}"
                                    @endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>