@extends("admin.template")

@section("page")
    <h1>Шаблоны class.php</h1>
    @if (count($public_templates))
        <h2>Все общие шаблоны</h2>
        @foreach($public_templates as $public_template)
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ $public_template->name }}</h3>
                    </div>
                    <div class="pull-right">
                        <a href="{{ action('Admin\AdminClassPhpTemplatesController@edit', [$public_template->id]) }}"
                           id="edit{{ $public_template->id }}"
                           class="btn btn-primary btn-sm">
                          <span class="glyphicon glyphicon-pencil"
                                aria-hidden="true"></span>
                        </a>
                        <a href="{{ action('Admin\AdminClassPhpTemplatesController@delete', [$public_template->id]) }}"
                           id="delete{{ $public_template->id }}"
                           class="btn btn-danger btn-sm deletion-with-confirm">
                          <span class="glyphicon glyphicon-trash"
                                aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    {{ html_entity_decode($public_template->template) }}
                </div>
            </div>
        @endforeach
    @endif

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
    <a class="btn btn-primary"
       href="{{ action('Admin\AdminClassPhpTemplatesController@private_ones') }}">Частные шаблоны
        <span class="glyphicon glyphicon-arrow-right"
              aria-hidden="true"></span>
    </a>
@stop