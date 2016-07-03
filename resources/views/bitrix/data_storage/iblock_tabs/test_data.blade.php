@if (isset($iblock))
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="{{action('Modules\Bitrix\BitrixDataStorageController@create_element', [$module, $iblock])}}"
               class="btn btn-success">{{ trans('bitrix_iblocks_form.add_element_button') }} {{--todo подпись из настроек иб--}}
            </a>
            {{-- <a href="#"
                class="btn btn-default">Добавить раздел --}}{{--todo подпись из настроек иб--}}{{--
             </a>--}}
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tr> {{--todo возможность настраивать--}}
                    <th>{{ trans('bitrix_iblocks_form.test_data_tab_name') }}</th>
                    <th>{{ trans('bitrix_iblocks_form.test_data_tab_code') }}</th>
                    <th>{{ trans('bitrix_iblocks_form.test_data_tab_active') }}</th>
                    <th>{{ trans('bitrix_iblocks_form.test_data_tab_sort') }}</th>
                    <th></th>
                </tr>
                @if ($iblock)
                    @foreach($elements as $i => $element)
                        <tr class="deletion_wrapper">
                            <td>
                                <a href="{{action('Modules\Bitrix\BitrixDataStorageController@show_element', [$module, $iblock, $element])}}">{{$element->name}}</a>
                            </td>
                            <td>{{$element->code}}</td>
                            <td>{{$element->active ? 'Y' : 'N'}}</td>
                            <td>{{$element->sort}}</td>
                            <td>
                                <a href="{{action('Modules\Bitrix\BitrixDataStorageController@delete_element', [$module, $iblock, $element])}}"
                                   class="btn btn-danger pull-right human_ajax_deletion"
                                   data-method="get"
                                   id="delete_element_{{$element->id}}">
                                    <span class="glyphicon glyphicon-trash"
                                          aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
@else
    <p>{{ trans('bitrix_iblocks_form.tab_require_iblock') }}</p>
@endif