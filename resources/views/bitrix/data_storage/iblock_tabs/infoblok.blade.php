<table class="table">
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_property_values_are_stored') }}:
        </th>
        <td>
            <label>
                <input type="radio"
                       name="VERSION"
                       value="1"
                       checked="">
                {{ trans('bitrix_iblocks_form.in_a_common_data_table') }}
            </label>
            <br>
            <label>
                <input type="radio"
                       name="VERSION"
                       value="2">
                {{ trans('bitrix_iblocks_form.in_a_separate_table') }}
            </label>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_code') }}:</th>
        <td>
            <input type="text"
                   class="form-control"
                   id="CODE"
                   name="CODE"
                   size="50"
                   maxlength="50"
                   value="{{isset($iblock)?$iblock->params->CODE:''}}"
                   data-translit_from="NAME"
                   required>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_name') }}:</th>
        <td>
            <input type="text"
                   class="form-control"
                   id="NAME"
                   name="NAME"
                   size="55"
                   maxlength="255"
                   value="{{isset($iblock)?$iblock->params->NAME:''}}"
                   required>
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_sort') }}:</th>
        <td>
            <input type="text"
                   class="form-control"
                   name="SORT"
                   value="{{isset($iblock)?$iblock->params->SORT:'500'}}">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_index_url') }}:</th>
        <td>
            <input type="text"
                   class="form-control"
                   name="LIST_PAGE_URL"
                   id="LIST_PAGE_URL"
                   value="{{isset($iblock)?$iblock->params->LIST_PAGE_URL:'#SITE_DIR#/'.$module->code.'/index.php?ID=#IBLOCK_ID#'}}">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_section_url') }}:</th>
        <td>
            <input type="text"
                   class="form-control"
                   name="SECTION_PAGE_URL"
                   id="SECTION_PAGE_URL"
                   value="{{isset($iblock)?$iblock->params->SECTION_PAGE_URL:'#SITE_DIR#/'.$module->code.'/list.php?SECTION_ID=#SECTION_ID#'}}">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_element_url') }}:</th>
        <td>
            <input type="text"
                   class="form-control"
                   name="DETAIL_PAGE_URL"
                   id="DETAIL_PAGE_URL"
                   value="{{isset($iblock)?$iblock->params->DETAIL_PAGE_URL:'#SITE_DIR#/'.$module->code.'/detail.php?ID=#ELEMENT_ID#'}}">
        </td>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.param_canonic_url') }}:
        </th>
        <td>
            <input type="text"
                   class="form-control"
                   name="CANONICAL_PAGE_URL"
                   id="CANONICAL_PAGE_URL"
                   value="{{isset($iblock)?$iblock->params->CANONICAL_PAGE_URL:''}}">
        </td>
    </tr>
    <tr>
        <th>
            <label for="INDEX_SECTION">{{ trans('bitrix_iblocks_form.param_index_section') }}:
            </label>
        </th>
        <td>
            <input type="hidden"
                   name="INDEX_SECTION"
                   value="N">
            <input type="checkbox"
                   id="INDEX_SECTION"
                   name="INDEX_SECTION"
                   value="Y" {{(isset($iblock) && isset($iblock->params->INDEX_SECTION) && $iblock->params->INDEX_SECTION == 'Y') ?'checked':''}}>
            <label for="INDEX_SECTION"></label>
        </td>
    </tr>
    <tr>
        <th>
            <label for="INDEX_ELEMENT">{{ trans('bitrix_iblocks_form.param_index_element') }}:
            </label>
        </th>
        <td>
            <input type="hidden"
                   name="INDEX_ELEMENT"
                   value="N">
            <input type="checkbox"
                   id="INDEX_ELEMENT"
                   name="INDEX_ELEMENT"
                   value="Y" {{(isset($iblock) && isset($iblock->params->INDEX_ELEMENT) && $iblock->params->INDEX_ELEMENT == 'Y')?'checked':''}}>
            <label for="INDEX_ELEMENT"></label>
        </td>
    </tr>
    {{--<tr>--}}
    {{--<th>Участвует в документообороте или бизнес процессах</th>--}}
    {{--<td>--}}
    {{--<select class="form-control" name="WF_TYPE">--}}
    {{--<option value="N" selected="">нет</option>--}}
    {{--<option value="WF">документооборот</option>--}}
    {{--<option value="BP">бизнес процессы</option>--}}
    {{--</select>--}}
    {{--</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
    {{--<th>Изображение:</th>--}}
    {{--<td>--}}
    {{--<a href="#" class="btn btn-primary">Добавить файл</a>--}}
    {{--</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
    {{--<td colspan="2">--}}
    {{--<label for="bxed_DESCRIPTION_text">--}}
    {{--<input checked="checked" type="radio"--}}
    {{--name="DESCRIPTION_TYPE"--}}
    {{--id="bxed_DESCRIPTION_text"--}}
    {{--value="text">--}}
    {{--Текст--}}
    {{--</label>--}}
    {{--<label for="bxed_DESCRIPTION_html">--}}
    {{--<input type="radio" name="DESCRIPTION_TYPE"--}}
    {{--id="bxed_DESCRIPTION_html"--}}
    {{--value="html">--}}
    {{--HTML--}}
    {{--</label>--}}
    {{--<textarea class="form-control" style="height:450px;" name="DESCRIPTION"--}}
    {{--id="bxed_DESCRIPTION" wrap="virtual"></textarea>--}}
    {{--</td>--}}
    {{--</tr>--}}
</table>