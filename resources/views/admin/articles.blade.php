@extends("admin.template")

@section("page")
    <h1>Статьи</h1>
    <div class="buttons">
        <a href="#"
           class="btn btn-primary">Добавить раздел
        </a>
        <a href="#"
           class="btn btn-success">Добавить элемент
        </a>
    </div>
    <br>
    <div class="list-group">
        @foreach($sections as $section)
            <a href="#"
               class="list-group-item">{{ $section->name }} ({{ $section->code }})</a>
        @endforeach
    </div>
@stop