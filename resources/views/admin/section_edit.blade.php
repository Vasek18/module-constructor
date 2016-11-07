@extends("admin.template")

@section("page")
    <h1>Добавить категорию статей</h1>
    <form action="{{  isset($section) ? action('Admin\AdminArticleSectionsController@update', [$section]) : action('Admin\AdminArticleSectionsController@store') }}"
          method="post">
        {{ csrf_field() }}
        @if (isset($section))
            {{ method_field('PUT') }}
        @else
            {{ method_field('POST') }}
        @endif
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   value="{{ isset($section) ? $section->name: '' }}">
        </div>
        <div class="form-group">
            <label for="code">Код</label>
            <input type="text"
                   id="code"
                   name="code"
                   class="form-control"
                   data-translit_from="{{ isset($section) ?: 'name' }}"
                   value="{{ isset($section) ? $section->code: '' }}">
        </div>
        <div class="form-group">
            <label for="preview_text">Анонс</label>
            <textarea id="preview_text"
                      name="preview_text"
                      class="form-control"
                      rows="10">{{ isset($section) ? $section->preview_text: '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="detail_text">Подробно</label>
            <textarea id="detail_text"
                      name="detail_text"
                      class="form-control"
                      rows="10">{{ isset($section) ? $section->detail_text: '' }}</textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@stop