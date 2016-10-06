<?php
$WATERMARK_FILE_POSITION = [
        "tl" => trans('bitrix_iblocks_form.tl'),
        "tc" => trans('bitrix_iblocks_form.tc'),
        "tr" => trans('bitrix_iblocks_form.tr'),
        "ml" => trans('bitrix_iblocks_form.ml'),
        "mc" => trans('bitrix_iblocks_form.mc'),
        "mr" => trans('bitrix_iblocks_form.mr'),
        "bl" => trans('bitrix_iblocks_form.bl'),
        "bc" => trans('bitrix_iblocks_form.bc'),
        "br" => trans('bitrix_iblocks_form.br'),
];
?>
<table class="table">
    <tr>
        <th>{{ trans('bitrix_iblocks_form.column_field_name_title' ) }}</th>
        <th>{{ trans('bitrix_iblocks_form.column_required_title' ) }}</th>
        <th>{{ trans('bitrix_iblocks_form.column_default_value_title' ) }}</th>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_binding_to_section' ) }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[IBLOCK_SECTION][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->IBLOCK_SECTION->IS_REQUIRED) && $iblock->params->FIELDS->IBLOCK_SECTION->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td>
            <input type="checkbox"
                   name="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]"
                   id="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]"
                   value="Y"
                    {{isset($iblock) && isset($iblock->params->FIELDS->IBLOCK_SECTION->DEFAULT_VALUE->KEEP_IBLOCK_SECTION_ID) && $iblock->params->FIELDS->IBLOCK_SECTION->DEFAULT_VALUE->KEEP_IBLOCK_SECTION_ID == 'Y'?'checked':''}}
            >
            <label for="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]">
                {{ trans('bitrix_iblocks_form.var_allow_selection_of_the_main_section_for_binding') }}
            </label>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_activity' ) }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[ACTIVE][IS_REQUIRED]"
                   checked
                   disabled>
        </td>
        <td>
            <select class="form-control"
                    name="FIELDS[ACTIVE][DEFAULT_VALUE]">
                <option value="Y"
                        {{isset($iblock) && isset($iblock->params->FIELDS->ACTIVE->DEFAULT_VALUE) && $iblock->params->FIELDS->ACTIVE->DEFAULT_VALUE == 'Y'?'selected':''}}>
                    {{ trans('bitrix_iblocks_form.var_activity_yes') }}
                </option>
                <option value="N"
                        {{isset($iblock) && isset($iblock->params->FIELDS->ACTIVE->DEFAULT_VALUE) && $iblock->params->FIELDS->ACTIVE->DEFAULT_VALUE == 'N'?'selected':''}}>
                    {{ trans('bitrix_iblocks_form.var_activity_no' ) }}
                </option>
            </select>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_activity_start') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[ACTIVE_FROM][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->ACTIVE_FROM->IS_REQUIRED) && $iblock->params->FIELDS->ACTIVE_FROM->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td>
            <select class="form-control"
                    name="FIELDS[ACTIVE_FROM][DEFAULT_VALUE]">
                <option value="">{{ trans('bitrix_iblocks_form.var_not_specified') }}</option>
                <option value="=now"
                        {{isset($iblock) && isset($iblock->params->FIELDS->ACTIVE_FROM->DEFAULT_VALUE) && $iblock->params->FIELDS->ACTIVE_FROM->DEFAULT_VALUE== '=now'?'selected':''}}
                >{{ trans('bitrix_iblocks_form.var_current_date_and_time') }}
                </option>
                <option value="=today"
                        {{isset($iblock) && isset($iblock->params->FIELDS->ACTIVE_FROM->DEFAULT_VALUE) && $iblock->params->FIELDS->ACTIVE_FROM->DEFAULT_VALUE== '=today'?'selected':''}}
                >{{ trans('bitrix_iblocks_form.var_current_date') }}
                </option>
            </select>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_activity_end') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[ACTIVE_TO][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->ACTIVE_TO->IS_REQUIRED) && $iblock->params->FIELDS->ACTIVE_TO->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td>
            <label for="FIELDS[ACTIVE_TO][DEFAULT_VALUE]">{{ trans('bitrix_iblocks_form.var_days_until_expiration') }}:
            </label>
            <input class="form-control"
                   name="FIELDS[ACTIVE_TO][DEFAULT_VALUE]"
                   type="text"
                   value="{{isset($iblock)&&isset($iblock->params->FIELDS->ACTIVE_TO)?$iblock->params->FIELDS->ACTIVE_TO->DEFAULT_VALUE:''}}">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_sort') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[SORT][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->SORT->IS_REQUIRED) && $iblock->params->FIELDS->SORT->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td></td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_name') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[NAME][IS_REQUIRED]"
                   checked
                   disabled>
        </td>
        <td>
            <input class="form-control"
                   name="FIELDS[NAME][DEFAULT_VALUE]"
                   type="text"
                   value="{{isset($iblock)&&isset($iblock->params->FIELDS->NAME)?$iblock->params->FIELDS->NAME->DEFAULT_VALUE:''}}">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_preview_picture') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[PREVIEW_PICTURE][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->IS_REQUIRED) && $iblock->params->FIELDS->PREVIEW_PICTURE->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td>
            <div>
                <input type="checkbox"
                       value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                        {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->FROM_DETAIL) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->FROM_DETAIL == 'Y'?'checked':''}}>
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]">{{ trans('bitrix_iblocks_form.auto_create_preview_image_from_detail_image_if_no') }}</label>
            </div>
            <div>
                <input type="checkbox"
                       value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                        {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->DELETE_WITH_DETAIL) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->DELETE_WITH_DETAIL == 'Y'?'checked':''}}
                >
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]">{{ trans('bitrix_iblocks_form.delete_preview_image_when_detail_image_is_deleted') }}</label>
            </div>
            <div>
                <input type="checkbox"
                       value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                        {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->UPDATE_WITH_DETAIL) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->UPDATE_WITH_DETAIL == 'Y'?'checked':''}}
                >
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]">{{ trans('bitrix_iblocks_form.auto_create_preview_image_from_detail_image') }}</label>
            </div>
            <div>
                <input type="checkbox"
                       value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]"
                        {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->SCALE) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->SCALE == 'Y'?'checked':''}}
                >
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]">{{ trans('bitrix_iblocks_form.auto_resize_large_images') }}</label>
                <div>
                    {{ trans('bitrix_iblocks_form.maximum_width') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WIDTH:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.maximum_height') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->HEIGHT:''}}">
                </div>
                <div>
                    <input type="checkbox"
                           value="Y"
                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->IGNORE_ERRORS) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->IGNORE_ERRORS == 'Y'?'checked':''}}
                    >
                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">{{ trans('bitrix_iblocks_form.ignore_scaling_error') }}
                    </label>
                </div>
                <div>
                    <input type="checkbox"
                           value="resample"
                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]"
                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->METHOD) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->METHOD == 'resample'?'checked':''}}
                    >
                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]">{{ trans('bitrix_iblocks_form.preserve_quality_when_scaling') }}
                    </label>
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.quality') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]"
                           type="text"
                           placeholder="95"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->COMPRESSION:''}}">
                    <input type="checkbox"
                           value="Y"
                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->USE_WATERMARK_FILE) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->USE_WATERMARK_FILE == 'Y'?'checked':''}}
                    >
                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">{{ trans('bitrix_iblocks_form.apply_watermark_as_image') }}</label>
                </div>
            </div>
            <div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_image') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                           id="FIELDS_PREVIEW_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WATERMARK_FILE:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_transparency') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WATERMARK_FILE_ALPHA:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_position') }}:
                    <select class="form-control"
                            name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                            id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]">
                        <option value="">{{ trans('app.select') }}</option>
                        @foreach($WATERMARK_FILE_POSITION as $posCode => $posName)
                            <option value="{{$posCode}}"
                                    @if (isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WATERMARK_FILE_POSITION == $posCode)selected
                                    @endif
                            >{{$posName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <input type="checkbox"
                       value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                        {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->USE_WATERMARK_TEXT) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->USE_WATERMARK_TEXT == 'Y'?'checked':''}}
                >
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">{{ trans('bitrix_iblocks_form.apply_watermark_as_text') }}</label>
                <div>{{ trans('bitrix_iblocks_form.watermark_text') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_font_file') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                           id="FIELDS_PREVIEW_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT_FONT:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_text_color') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT_COLOR:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_size') }}:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE)?$iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT_SIZE:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_position') }}:
                    <select class="form-control"
                            name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                            id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]">
                        <option value="">{{ trans('app.select') }}</option>
                        @foreach($WATERMARK_FILE_POSITION as $posCode => $posName)
                            <option value="{{$posCode}}"
                                    @if (isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_PICTURE) && $iblock->params->FIELDS->PREVIEW_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT_POSITION == $posCode)selected
                                    @endif
                            >{{$posName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_preview_text_type') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[PREVIEW_TEXT_TYPE][IS_REQUIRED]"
                   checked
                   disabled>
        </td>
        <td>
            <select class="form-control"
                    name="FIELDS[PREVIEW_TEXT_TYPE][DEFAULT_VALUE]">
                <option value="text" {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_TEXT_TYPE) && $iblock->params->FIELDS->PREVIEW_TEXT_TYPE->DEFAULT_VALUE == 'text' ? 'selected' : ''}}>
                    text
                </option>
                <option value="html" {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_TEXT_TYPE) && $iblock->params->FIELDS->PREVIEW_TEXT_TYPE->DEFAULT_VALUE == 'html' ? 'selected' : ''}}>
                    html
                </option>
            </select>
            <input type="hidden"
                   name="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   value="N">
            <input type="checkbox"
                   value="Y"
                   id="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   name="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                    {{(isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_TEXT_TYPE_ALLOW_CHANGE->DEFAULT_VALUE) && $iblock->params->FIELDS->PREVIEW_TEXT_TYPE_ALLOW_CHANGE->DEFAULT_VALUE == 'Y')?'checked':''}}
            >
            <label for="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">{{ trans('bitrix_iblocks_form.allow_to_switch_editing_mode') }}</label>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_preview_text') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[PREVIEW_TEXT][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_TEXT->IS_REQUIRED) && $iblock->params->FIELDS->PREVIEW_TEXT->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td>
            <textarea class="form-control"
                      name="FIELDS[PREVIEW_TEXT][DEFAULT_VALUE]">{{isset($iblock) && isset($iblock->params->FIELDS->PREVIEW_TEXT)?$iblock->params->FIELDS->PREVIEW_TEXT->DEFAULT_VALUE:''}}</textarea>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_detail_picture') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[DETAIL_PICTURE][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE->IS_REQUIRED) && $iblock->params->FIELDS->DETAIL_PICTURE->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td>
            <div>
                <input type="checkbox"
                       value="Y"
                       id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"
                       name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"
                        {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->SCALE) && $iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->SCALE == 'Y'?'checked':''}}>
                <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"> {{ trans('bitrix_iblocks_form.auto_resize_large_images') }}</label>
                <div>
                    {{ trans('bitrix_iblocks_form.maximum_width') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WIDTH:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.maximum_height') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->HEIGHT:''}}">
                </div>
                <div>
                    <input type="checkbox"
                           value="Y"
                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->IGNORE_ERRORS) && $iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->IGNORE_ERRORS == 'Y'?'checked':''}}>
                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">
                        {{ trans('bitrix_iblocks_form.ignore_scaling_error') }}
                    </label>
                </div>
                <div>
                    <input type="checkbox"
                           value="resample"
                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"
                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->METHOD) && $iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->METHOD == 'resample'?'checked':''}}>
                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]">
                        {{ trans('bitrix_iblocks_form.preserve_quality_when_scaling') }}
                    </label>
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.quality') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]"
                           type="text"
                           placeholder="95"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->COMPRESSION:''}}">
                    <input type="checkbox"
                           value="Y"
                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->USE_WATERMARK_FILE) && $iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->USE_WATERMARK_FILE == 'Y'?'checked':''}}>
                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">{{ trans('bitrix_iblocks_form.apply_watermark_as_text') }}</label>
                </div>
            </div>
            <div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_image') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                           id="FIELDS_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WATERMARK_FILE:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_transparency') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WATERMARK_FILE_ALPHA:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_position') }}:
                    <select class="form-control"
                            name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                            id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]">
                        <option value="">{{ trans('app.select') }}</option>
                        @foreach($WATERMARK_FILE_POSITION as $posCode => $posName)
                            <option value="{{$posCode}}"
                                    @if (isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE) && $iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WATERMARK_FILE_POSITION == $posCode)selected
                                    @endif
                            >{{$posName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <input type="checkbox"
                       value="Y"
                       id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                       name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                        {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->USE_WATERMARK_TEXT) && $iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->USE_WATERMARK_TEXT == 'Y'?'checked':''}}
                >
                <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">{{ trans('bitrix_iblocks_form.apply_watermark_as_image') }}</label>
                <div>{{ trans('bitrix_iblocks_form.watermark_text') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_font_file') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                           id="FIELDS_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT_FONT:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_text_color') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT_COLOR:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_size') }}:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"
                           type="text"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE)?$iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT_SIZE:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.watermark_position') }}:
                    <select class="form-control"
                            name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                            id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]">
                        <option value="">{{ trans('app.select') }}</option>
                        @foreach($WATERMARK_FILE_POSITION as $posCode => $posName)
                            <option value="{{$posCode}}"
                                    @if (isset($iblock) && isset($iblock->params->FIELDS->DETAIL_PICTURE) && $iblock->params->FIELDS->DETAIL_PICTURE->DEFAULT_VALUE->WATERMARK_TEXT_POSITION == $posCode)selected
                                    @endif
                            >{{$posName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_detail_text_type') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[DETAIL_TEXT_TYPE][IS_REQUIRED]"
                   checked
                   disabled>
        </td>
        <td>
            <select class="form-control"
                    name="FIELDS[DETAIL_TEXT_TYPE][DEFAULT_VALUE]">
                <option value="text" {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_TEXT_TYPE) && $iblock->params->FIELDS->DETAIL_TEXT_TYPE->DEFAULT_VALUE == 'text' ? 'selected' : ''}}>
                    text
                </option>
                <option value="html" {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_TEXT_TYPE) && $iblock->params->FIELDS->DETAIL_TEXT_TYPE->DEFAULT_VALUE == 'html' ? 'selected' : ''}}>
                    html
                </option>
            </select>
            <input type="hidden"
                   name="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   value="N">
            <input type="checkbox"
                   value="Y"
                   id="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   name="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                    {{(isset($iblock) && isset($iblock->params->FIELDS->DETAIL_TEXT_TYPE_ALLOW_CHANGE->DEFAULT_VALUE) && $iblock->params->FIELDS->DETAIL_TEXT_TYPE_ALLOW_CHANGE->DEFAULT_VALUE == 'Y')?'checked':''}}
            >
            <label for="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">{{ trans('bitrix_iblocks_form.allow_to_switch_editing_mode') }}
            </label>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_detail_text') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[DETAIL_TEXT][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_TEXT->IS_REQUIRED) && $iblock->params->FIELDS->DETAIL_TEXT->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td>
            <textarea class="form-control"
                      name="FIELDS[DETAIL_TEXT][DEFAULT_VALUE]">{{isset($iblock) && isset($iblock->params->FIELDS->DETAIL_TEXT)?$iblock->params->FIELDS->DETAIL_TEXT->DEFAULT_VALUE:''}}</textarea>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_external_code') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[XML_ID][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->XML_ID->IS_REQUIRED) && $iblock->params->FIELDS->XML_ID->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td></td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_code') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[CODE][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->CODE->IS_REQUIRED) && $iblock->params->FIELDS->CODE->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td>
            <div>
                <input type="checkbox"
                       value="Y"
                       id="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"
                       name="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"
                        {{isset($iblock) && isset($iblock->params->FIELDS->CODE->DEFAULT_VALUE->UNIQUE) && $iblock->params->FIELDS->CODE->DEFAULT_VALUE->UNIQUE == 'Y'?'checked':''}}
                >
                <label for="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]">{{ trans('bitrix_iblocks_form.check_uniqueness_if_the_code_is_specified') }}
                </label>
            </div>
            <div>
                <div>
                    <input type="checkbox"
                           value="Y"
                           id="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]"
                           name="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANSLITERATION) && $iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANSLITERATION == 'Y'?'checked':''}}
                    >
                    <label for="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]">{{ trans('bitrix_iblocks_form.derive_from_the_name_transliteration_when_adding_an_element') }}
                    </label>
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.max_transliteration_result_length') }}:
                    <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_LEN]"
                           type="text"
                           placeholder="100"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->CODE)?$iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANS_LEN:''}}">
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.transform_case') }}:
                    <select class="form-control"
                            name="FIELDS[CODE][DEFAULT_VALUE][TRANS_CASE]">
                        <option value="">{{ trans('bitrix_iblocks_form.preserve') }}</option>
                        <option value="L"
                                {{isset($iblock) && isset($iblock->params->FIELDS->CODE->DEFAULT_VALUE) && $iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANS_CASE == 'L'?'selected':''}}
                        >
                            {{ trans('bitrix_iblocks_form.lower') }}
                        </option>
                        <option value="U"
                                {{isset($iblock) && isset($iblock->params->FIELDS->CODE->DEFAULT_VALUE) && $iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANS_CASE == 'U'?'selected':''}}
                        >
                            {{ trans('bitrix_iblocks_form.upper') }}
                        </option>
                    </select>
                </div>
                <div>
                    {{ trans('bitrix_iblocks_form.replace_whitespace_with') }}:
                    <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_SPACE]"
                           type="text"
                           placeholder="-"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->CODE)?$iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANS_SPACE:''}}">
                </div>
                <div>{{ trans('bitrix_iblocks_form.replace_other_characters_with') }}:
                    <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_OTHER]"
                           type="text"
                           placeholder="-"
                           class="form-control"
                           value="{{isset($iblock) && isset($iblock->params->FIELDS->CODE)?$iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANS_OTHER:''}}">
                </div>
                <div>
                    <input type="checkbox"
                           value="Y"
                           id="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]"
                           name="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANS_EAT) && $iblock->params->FIELDS->CODE->DEFAULT_VALUE->TRANS_EAT == 'Y'?'checked':''}}>
                    <label for="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]">{{ trans('bitrix_iblocks_form.remove_redundant_characters') }}
                    </label>
                </div>
                <div>
                    <input type="checkbox"
                           value="Y"
                           id="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]"
                           name="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]"
                            {{isset($iblock) && isset($iblock->params->FIELDS->CODE->DEFAULT_VALUE->USE_GOOGLE) && $iblock->params->FIELDS->CODE->DEFAULT_VALUE->USE_GOOGLE == 'Y'?'checked':''}}
                    >
                    <label for="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]">{{ trans('bitrix_iblocks_form.use_external_translation_engine') }}
                    </label>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.fields_param_tags') }}</th>
        <td>
            <input type="checkbox"
                   value="Y"
                   name="FIELDS[TAGS][IS_REQUIRED]"
                    {{isset($iblock) && isset($iblock->params->FIELDS->TAGS->IS_REQUIRED) && $iblock->params->FIELDS->TAGS->IS_REQUIRED == 'Y'?'checked':''}}
            >
        </td>
        <td></td>
    </tr>
</table>