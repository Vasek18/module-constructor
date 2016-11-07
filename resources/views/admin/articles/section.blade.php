@extends("admin.template")

@section("page")
    <div class="buttons">
        <a href="{{ action('Admin\AdminArticleSectionsController@create') }}"
           class="btn btn-primary">Добавить раздел
        </a>
        <a href="{{ action('Admin\AdminArticlesController@create') }}"
           class="btn btn-success">Добавить элемент
        </a>
    </div>
    <h1>Категория "{{ $section->name }}"</h1>
    <div class="list-group">
        @foreach($articles as $article)
            <div class="list-group-item">
                <a class="btn btn-default btn-sm"
                   href="{{ action('Admin\AdminArticlesController@edit', [$article]) }}">
                    <span class="glyphicon glyphicon-pencil"
                          aria-hidden="true"></span>
                </a>
                <a class="btn btn-danger btn-sm"
                   id="delete{{ $article->id }}"
                   href="{{ action('Admin\AdminArticlesController@destroy', [$article]) }}">
                    <span class="glyphicon glyphicon-trash"
                          aria-hidden="true"></span>
                </a>{{ $article->name }} ({{ $article->code }})
            </div>
        @endforeach
    </div>
@stop