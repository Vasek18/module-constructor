@extends('bitrix.internal_template')

@section('h1')
    Шаблоны сайта
@stop

@section('page')
    <a href="{{action('Modules\Bitrix\BitrixSiteTemplatesController@create', [$module->id])}}"
       class="btn btn-primary">Добавить шаблон</a>
    <hr>
    @if (count($templates))
        <h2>Шаблоны</h2>
        <div class="list-group">
            @foreach($templates as $template)
                <div class="list-group-item clearfix component deletion_wrapper">
                    <a href="{{action('Modules\Bitrix\BitrixSiteTemplatesController@show', [$module->id, $template->id])}}">
                        Шаблон "{{$template->name}}" ({{$template->code}})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixSiteTemplatesController@destroy', [$module->id, $template->id]) }}"
                       class="btn btn-danger pull-right deletion-with-confirm"
                       id="delete_template_{{$template->id}}">
                        <span class="glyphicon glyphicon-trash"
                              aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop