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
    @foreach($iblock->properties as $i => $property)
        {{--{{dd($property)}}--}}
        @include('bitrix.data_storage.iblock_tabs.properties_item', ['property' => $property, 'i' => $i, 'iblock' => $iblock])
    @endforeach
    {{-- Дополнительно показываем ещё несколько пустых строк --}}
    @for ($j = count($iblock->properties); $j < count($iblock->properties)+5; $j++)
        @include('bitrix.data_storage.iblock_tabs.properties_item', ['property' => null, 'i' => $j, 'iblock' => $iblock])
    @endfor
</table>