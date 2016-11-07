@extends("admin.template")

@section("page")
    <div class="buttons">
        <a href="{{ action('Admin\AdminArticleSectionsController@create') }}"
           class="btn btn-primary">Добавить раздел
        </a>
        <a href="#"
           class="btn btn-success">Добавить элемент
        </a>
    </div>
    <h1>Категория "{{ $section->name }}"</h1>
    <div class="list-group">
        @foreach($articles as $article)
            <a href="#"
               class="list-group-item">{{ $article->name }}</a>
        @endforeach
    </div>
@stop