@extends("admin.template")

@section("page")
    <h1>Редактирование шаблона class.php "{{ $template->name }}"</h1>
    <h2>Добавить шаблон</h2>
    <form action="{{ action('Admin\AdminClassPhpTemplatesController@update', [$template->id]) }}"
          method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   value="{{ $template->name }}"
                   required>
        </div>
        <div class="form-group">
            <label for="code">Код</label>
            <input type="text"
                   id="code"
                   name="code"
                   class="form-control"
                   value="{{ $template->code }}">
        </div>
        <div class="form-group">
            <label for="template">Шаблон</label>
            <textarea id="template"
                      name="template"
                      class="form-control"
                      rows="10"
                      required>
                {!! $template->template !!}
            </textarea>
        </div>
        <div class="form-group">
            <button id="update"
                    name="update"
                    class="btn btn-success">Сохранить
            </button>
        </div>
    </form>
@stop