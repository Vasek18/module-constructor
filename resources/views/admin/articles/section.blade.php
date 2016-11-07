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
            <a href="{{ action('Admin\AdminArticlesController@edit', [$article]) }}"
               class="list-group-item">{{ $article->name }} ({{ $article->code }})</a>
        @endforeach
    </div>
@stop