@extends('bitrix.internal_template')

@section('h1')
    Страница настроек
@stop

@section('page')
    @push('scripts')
    <script src="/js/bitrix_module_admin_options.js"></script>
    @endpush
    <form role="form" method="POST" action="{{ action('Modules\Bitrix\BitrixOptionsController@store', $module->id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row option-headers">
            <div class="col-md-2">
                <label>Код свойства</label>
            </div>
            <div class="col-md-3">
                <label>Название свойства</label>
            </div>
            <div class="col-md-2">
                <label>Тип свойства</label>
            </div>
            <div class="col-md-2">
                <label>Доп. поля</label>
            </div>
            <div class="col-md-2">
                <label>Удалить</label>
            </div>
        </div>
        <div class="draggable-container">
            {{--todo вынести row--}}
            {{--@each('bitrix.admin_options.item', $options, 'option')--}}
            @foreach($options as $i => $option)
                {{--{{dd($option)}}--}}
                @include('bitrix.admin_options.item', ['option' => $option, 'i' => $i, 'module' => $module])
            @endforeach
        </div>
        {{-- Дополнительно показываем ещё несколько пустых строк --}}
        @for ($j = count($options); $j < count($options)+5; $j++)
            @include('bitrix.admin_options.item', ['option' => null, 'i' => $j, 'module' => $module])
        @endfor
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block">Сохранить</button>
            </div>
        </div>
    </form>
    <hr>
    <p class="description">Здесь задаются настройки, которые можно будет получить на сайте через
        COption::GetOptionString("{код модуля}", "{код опции}");. Сами значения задаются на странице настроек модуля
        (Настройки -> Настройки модулей -> Название модуля).
        <br>
        Также вместе с указанными вами настройками создастся вкладка со стандартными настройками прав модуля.
    </p>
@stop