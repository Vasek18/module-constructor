<table class="table">
    <tr>
        <th>{{ trans('bitrix_iblocks_form.props_tab_name') }}</th>
        <th>{{ trans('bitrix_iblocks_form.props_tab_type') }}</th>
        <th>{{ trans('bitrix_iblocks_form.props_tab_plural') }}</th>
        <th>{{ trans('bitrix_iblocks_form.props_tab_require') }}</th>
        <th>{{ trans('bitrix_iblocks_form.props_tab_sort') }}</th>
        <th>{{ trans('bitrix_iblocks_form.props_tab_code') }}</th>
        <th>{{ trans('bitrix_iblocks_form.props_tab_change') }}</th>
        <th>{{ trans('bitrix_iblocks_form.props_tab_delete') }}</th>
    </tr>
    @if ($iblock)
        @foreach($properties as $i => $property)
            {{--{{dd($property)}}--}}
            @include('bitrix.data_storage.iblock_tabs.properties_item', ['property' => $property, 'i' => $i, 'iblock' => $iblock])
        @endforeach
        {{-- Дополнительно показываем ещё несколько пустых строк --}}
        @for ($j = count($properties); $j < count($properties)+5; $j++)
            @include('bitrix.data_storage.iblock_tabs.properties_item', ['property' => null, 'i' => $j, 'iblock' => $iblock])
        @endfor
    @else
        @for ($j = 0; $j < 5; $j++)
            @include('bitrix.data_storage.iblock_tabs.properties_item', ['property' => null, 'i' => $j, 'iblock' => $iblock])
        @endfor
    @endif
</table>