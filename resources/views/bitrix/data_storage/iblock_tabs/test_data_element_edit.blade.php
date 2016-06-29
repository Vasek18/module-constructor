@extends('bitrix.internal_template')

@section('h1')
    @if (isset($element))
        Редактирование тестового элемента инфоблока
    @else
        Добавление тестового элемента инфоблока
    @endif
@stop

@section('page')
    <p>
        <a class="btn btn-primary"
           href="{{ action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $iblock->id]) }}">
            Вернуться к редактированию инфоблока
        </a>
    </p>
    <ul class="nav nav-tabs"
        role="tablist">
        <li role="presentation"
            class="active">
            <a href="#element"
               aria-controls="element"
               role="tab"
               data-toggle="tab">Элемент
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel"
             class="tab-pane active"
             id="element">
            <form action="">
                <div class="col-md-offset-2 col-md-8">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="ACTIVE"
                                       value="Y"
                                       checked>
                                Активность
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="NAME">Название
                        </label>
                        <input type="text"
                               id="NAME"
                               name="NAME"
                               class="form-control"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="CODE">Символьный код
                        </label>
                        <input type="text"
                               id="CODE"
                               name="CODE"
                               class="form-control"
                                {{--todo может быть обязательным--}}>
                    </div>
                    <div class="form-group">
                        <label for="SORT">Сортировка
                        </label>
                        <input type="text"
                               id="SORT"
                               name="SORT"
                               class="form-control"
                               value="500"
                                {{--todo может быть обязательным--}}>
                    </div>
                    @if (count($properties))
                        <hr>
                        <h2>Значения свойств</h2>
                        <hr>
                        @foreach($properties as $i => $property)
                            <div class="form-group">
                                <label for="{{$property->code}}">{{$property->name}}</label>
                                @if ($property->type == 'S')
                                    <input type="text"
                                           id="{{$property->code}}"
                                           name="{{$property->code}}"
                                           class="form-control"
                                            {{ $property->is_required ? 'required' : '' }}
                                    >
                                @endif
                                @if ($property->type == 'S:map_google')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text"
                                                   id="{{$property->code}}"
                                                   name="{{$property->code}}"
                                                   class="form-control"
                                                   placeholder="Широта"
                                                    {{ $property->is_required ? 'required' : '' }}
                                            >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"
                                                   id="{{$property->code}}"
                                                   name="{{$property->code}}"
                                                   class="form-control"
                                                   placeholder="Долгота"
                                                    {{ $property->is_required ? 'required' : '' }}
                                            >
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
    </div>
@stop