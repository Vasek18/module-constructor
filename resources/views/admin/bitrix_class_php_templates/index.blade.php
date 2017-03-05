@extends("admin.template")

@section("page")
    <h1>Шаблоны class.php</h1>
    <h2>Добавить шаблон</h2>
    <form action="{{ action('Admin\AdminClassPhpTemplatesController@add') }}"
          method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   required>
        </div>
        <div class="form-group">
            <label for="code">Код</label>
            <input type="text"
                   id="code"
                   name="code"
                   class="form-control">
        </div>
        <div class="form-group">
            <label for="template">Шаблон</label>
            <textarea id="template"
                      name="template"
                      class="form-control"
                      rows="10"
                      required></textarea>
        </div>
        <div class="form-group">
            <button id="add"
                    name="add"
                    class="btn btn-success">Сохранить
            </button>
        </div>
    </form>
    @if (count($public_templates))
        <h2>Все общие шаблоны</h2>
        @foreach($public_templates as $public_template)
            <div class="panel panel-default">
                <div class="panel-heading">{{ $public_template->name }}</div>
                <div class="panel-body">
                    {{ $public_template->template }}
                </div>
            </div>
        @endforeach
    @endif
    <a class="btn btn-primary"
       href="{{ action('Admin\AdminClassPhpTemplatesController@private_ones') }}">Частные шаблоны
        <span class="glyphicon glyphicon-arrow-right"
              aria-hidden="true"></span>
    </a>
@stop