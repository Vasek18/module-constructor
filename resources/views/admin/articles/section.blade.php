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
    <table class="table table-bordered">
        <tr>
            <th>Название</th>
            <th>Код</th>
            <th>Активность</th>
            <th>Действия</th>
        </tr>
        @foreach($articles as $article)
            <tr>
                <td>{{ $article->name }}</td>
                <td>{{ $article->code }}</td>
                <td>{{ $article->active ? 'Да' : 'Нет' }}</td>
                <td>
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
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@stop