@if (isset($iblock))
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="{{action('Modules\Bitrix\BitrixDataStorageController@element_create', [$module, $iblock])}}"
               class="btn btn-success">Добавить элемент {{--todo подпись из настроек иб--}}
            </a>
            {{-- <a href="#"
                class="btn btn-default">Добавить раздел --}}{{--todo подпись из настроек иб--}}{{--
             </a>--}}
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tr> {{--todo возможность настраивать--}}
                    <th>Название</th>
                    <th>Код</th>
                    <th>Активность</th>
                    <th>Сортировка</th>
                </tr>
                @if ($iblock)
                    @foreach($elements as $i => $element)
                        <tr>
                            <td>
                                <a href="#">{{$element->name}}</a>
                            </td>
                            <td>{{$element->code}}</td>
                            <td>{{$element->active ? 'Y' : 'N'}}</td>
                            <td>{{$element->sort}}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
@else
    <p>Вкладка будет доступна после создания инфоблока</p>
@endif