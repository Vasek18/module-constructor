<table class="table">
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Множ.</th>
        <th>Обяз.</th>
        <th>Сорт.</th>
        <th>Код</th>
        <th>Изм.</th>
        <th>Удал.</th>
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