@extends("admin.template")

@section("page")
    <h1>Статьи</h1>
    <div class="buttons">
        <a href="{{ action('Admin\AdminArticleSectionsController@create') }}"
           class="btn btn-primary">Добавить раздел
        </a>
        <a href="{{ action('Admin\AdminArticlesController@create') }}"
           class="btn btn-success">Добавить элемент
        </a>
    </div>
    <br>
    <div class="list-group">
        @foreach($sections as $section)
            <div class="list-group-item">
                <a class="btn btn-default btn-sm"
                   href="{{ action('Admin\AdminArticleSectionsController@edit', [$section]) }}">
                    <span class="glyphicon glyphicon-pencil"
                          aria-hidden="true"></span>
                </a>
                <a href="{{ action('Admin\AdminArticleSectionsController@show', [$section]) }}">
                    {{ $section->name }} ({{ $section->code }})
                </a>
            </div>
        @endforeach
    </div>
@stop