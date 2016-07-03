<table class="table">
    <tr>
        <th colspan="2"
            class="text-center">{{ trans('bitrix_iblocks_form.default_access_permissions') }}</th>
    </tr>
    <tr>
        <th>{{ trans('bitrix_iblocks_form.for_everyone') }} [2]: {{--это походу всегда вторая группа--}}</th>
        </td>
        <td>
            <select class="form-control"
                    name="GROUP_ID"
                    id="group_2">
                <option value="Array('2' => 'D')" {{$iblock && isset($iblock->params->GROUP_ID) && $iblock->params->GROUP_ID == "Array('2' => 'D')" ? 'selected' : ''}}>
                    {{ trans('bitrix_iblocks_form.access_type_d') }}
                </option>
                <option value="Array('2' => 'R')" {{$iblock && isset($iblock->params->GROUP_ID) && $iblock->params->GROUP_ID == "Array('2' => 'R')" ? 'selected' : ''}}  {{!$iblock || !isset($iblock->params->GROUP_ID) ? 'selected' : ''}}>
                    {{ trans('bitrix_iblocks_form.access_type_r') }}
                </option>
                <option value="Array('2' => 'S')" {{$iblock && isset($iblock->params->GROUP_ID) && $iblock->params->GROUP_ID == "Array('2' => 'S')" ? 'selected' : ''}}>
                    {{ trans('bitrix_iblocks_form.access_type_s') }}
                </option>
                <option value="Array('2' => 'T')" {{$iblock && isset($iblock->params->GROUP_ID) && $iblock->params->GROUP_ID == "Array('2' => 'T')" ? 'selected' : ''}}>
                    {{ trans('bitrix_iblocks_form.access_type_t') }}
                </option>
                <option value="Array('2' => 'W')" {{$iblock && isset($iblock->params->GROUP_ID) && $iblock->params->GROUP_ID == "Array('2' => 'W')" ? 'selected' : ''}}>
                    {{ trans('bitrix_iblocks_form.access_type_w') }}
                </option>
                <option value="Array('2' => 'X')" {{$iblock && isset($iblock->params->GROUP_ID) && $iblock->params->GROUP_ID == "Array('2' => 'X')" ? 'selected' : ''}}>
                    {{ trans('bitrix_iblocks_form.access_type_x') }}
                </option>
            </select>
        </td>
    </tr>
</table>