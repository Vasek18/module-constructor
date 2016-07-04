@extends('bitrix.internal_template')

@section('h1')
    Создание страницы административного меню
@stop

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>@endpush

@section('page')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Ошибка!</strong> При заполнение формы возникли ошибки<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="col-md-8 col-md-offset-2"
          role="form"
          method="POST"
          action="{{ action('Modules\Bitrix\BitrixAdminMenuController@store', $module->id) }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="control-label"
                   for="name">Название в системе
            </label>
            <input type="text"
                   class="form-control"
                   name="name"
                   value=""
                   required
                   aria-describedby="name_help"
                   id="name">
                <span class="help-block"
                      id="name_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="code">Символьный код
            </label>
            <input type="text"
                   class="form-control"
                   name="code"
                   value=""
                   required
                   aria-describedby="code_help"
                   data-translit_from="name"
                   id="code">
                <span class="help-block"
                      id="code_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="sort">Сортировка
            </label>
            <input type="text"
                   class="form-control"
                   name="sort"
                   value=""
                   aria-describedby="sort_help"
                   id="sort">
                <span class="help-block"
                      id="sort_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="text">Текст пункта меню
            </label>
            <input type="text"
                   class="form-control"
                   name="text"
                   value=""
                   aria-describedby="text_help"
                   id="text">
                <span class="help-block"
                      id="text_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="parent_menu">Родительский раздел
            </label>
            <select class="form-control"
                    name="parent_menu"
                    aria-describedby="parent_menu_help"
                    id="parent_menu"
                    required>
                <option value="">Выберите</option>
                @foreach($parent_menu_vars as $parent_menu_var)
                    <option value="{{$parent_menu_var}}">{{$parent_menu_var}}</option>
                @endforeach
            </select>
                <span class="help-block"
                      id="parent_menu_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="text">Код страницы
            </label>
            <div id="editor"
                 style="height: 500px"></div>
            @push('scripts')
            <script>
                var editor = ace.edit("editor");
                editor.getSession().setMode("ace/mode/php");
                {{--editor.setValue("{!!$handler?$handler->php_code:''!!}");--}}
                editor.getSession().on('change', function(e){
                    var text = editor.getSession().getValue();
                    console.log(text)
                    $("#php_code").val(text);
                });
            </script>
            @endpush
            <input type="hidden"
                   name="php_code"
                   id="php_code"
                   value="">
        </div>
        <div class="form-group">
            <button type="submit"
                    class="btn btn-primary"
                    name="create">
                Создать
            </button>
        </div>
    </form>
    <div class="step-description"></div>
@stop