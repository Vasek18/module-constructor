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
    <table class="table table-bordered">
        <tr>
            <th>Название</th>
            <th>Код</th>
            <th>Сортировка</th>
            <th>Активность</th>
            <th>Действия</th>
        </tr>
        @foreach($sections as $section)
            <tr>
                <td>
                    <a href="{{ action('Admin\AdminArticleSectionsController@show', [$section]) }}">{{ $section->name }} </a>
                </td>
                <td>{{ $section->code }}</td>
                <td>{{ $section->sort }}</td>
                <td>{{ $section->active ? 'Да' : 'Нет' }}</td>
                <td>
                    <a class="btn btn-default btn-sm"
                       href="{{ action('Admin\AdminArticleSectionsController@edit', [$section]) }}">
                    <span class="glyphicon glyphicon-pencil"
                          aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-danger btn-sm deletion-with-confirm"
                       id="delete{{ $section->id }}"
                       href="{{ action('Admin\AdminArticleSectionsController@destroy', [$section]) }}">
                    <span class="glyphicon glyphicon-trash"
                          aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@stop