@if (isset($iblock))
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockElementController@create', [$module, $iblock])}}"
               class="btn btn-success">{{ trans('bitrix_iblocks_form.add_element_button') }} {{--todo подпись из настроек иб--}}
            </a>
            <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockSectionController@create', [$module, $iblock])}}"
               class="btn btn-success">{{ trans('bitrix_iblocks_form.add_section_button') }} {{--todo подпись из настроек иб--}}
            </a>
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
                    @if (isset($section))
                        <tr class="deletion_wrapper">
                            <td>
                                <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockController@show', [$module, $iblock])}}#test_data">
                                    <span class="glyphicon glyphicon-home"
                                          aria-hidden="true"></span> {{ trans('bitrix_iblocks_form.section_up') }}</a>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($sections as $i => $section)
                        <tr class="deletion_wrapper">
                            <td>
                                <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockSectionController@show', [$module, $iblock, $section])}}#test_data">
                                    <span class="glyphicon glyphicon-folder-open"
                                          aria-hidden="true"></span> {{$section->name}}</a>
                            </td>
                            <td>{{$section->code}}</td>
                            <td>{{$section->active ? 'Y' : 'N'}}</td>
                            <td>{{$section->sort}}</td>
                            <td>
                                <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockSectionController@edit', [$module, $iblock, $section])}}"
                                   class="btn btn-default"
                                   id="edit_section_{{$section->id}}">
                                    <span class="glyphicon glyphicon-pencil"
                                          aria-hidden="true"></span>
                                </a>
                                <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockSectionController@destroy', [$module, $iblock, $section])}}"
                                   class="btn btn-danger human_ajax_deletion"
                                   data-method="get"
                                   id="delete_section_{{$section->id}}">
                                    <span class="glyphicon glyphicon-trash"
                                          aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @foreach($elements as $i => $element)
                        <tr class="deletion_wrapper">
                            <td>
                                <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockElementController@edit', [$module, $iblock, $element])}}">{{$element->name}}</a>
                            </td>
                            <td>{{$element->code}}</td>
                            <td>{{$element->active ? 'Y' : 'N'}}</td>
                            <td>{{$element->sort}}</td>
                            <td>
                                <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockElementController@edit', [$module, $iblock, $element])}}"
                                   class="btn btn-default"
                                   id="edit_element_{{$element->id}}">
                                    <span class="glyphicon glyphicon-pencil"
                                          aria-hidden="true"></span>
                                </a>
                                <a href="{{action('Modules\Bitrix\Infoblock\BitrixInfoblockElementController@destroy', [$module, $iblock, $element])}}"
                                   class="btn btn-danger human_ajax_deletion"
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