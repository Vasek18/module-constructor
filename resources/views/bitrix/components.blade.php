@extends('app')

@section('content')

    {{-- todo Проверка на наличие пришедших данных --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('bitrix.menu')
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    @if ($module->id)
                        <div class="panel-heading">Компоненты | Модуль "{{$module->MODULE_NAME}}"
                            ({{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}})
                        </div>
                        <div class="panel-body">
                            <a href="{{ route('bitrix_new_component', $module->id) }}" class="btn btn-primary">Добавить
                                компонент</a>
                            <br>
                            <br>
                            <div class="list-group">
                                @foreach($components as $component)
                                    <a class="list-group-item" href="#">Компонент "{{$module->MODULE_NAME}}"</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="panel-body">
                            Ошибка!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop