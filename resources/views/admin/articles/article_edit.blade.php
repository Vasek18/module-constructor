@extends("admin.template")

@section("page")
    @if (isset($article))
        <h1>Редактировать статью "{{ $article->name }}"</h1>
    @else
        <h1>Добавить статью</h1>
    @endif
    <form action="{{  isset($article) ? action('Admin\AdminArticlesController@update', [$article]) : action('Admin\AdminArticlesController@store') }}"
          method="post">
        {{ csrf_field() }}
        @if (isset($article))
            {{ method_field('PUT') }}
        @else
            {{ method_field('POST') }}
        @endif
        <div class="form-group">
            <label for="section_id">Категория</label>
            <select name="section_id"
                    id="section_id"
                    class="form-control"
                    required>
                <option value="">Выберите</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}"
                            {{ isset($article) && $article->section_id == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   value="{{ isset($article) ? $article->name: '' }}"
                   required>
        </div>
        <div class="form-group">
            <label for="code">Код</label>
            <input type="text"
                   id="code"
                   name="code"
                   class="form-control"
                   data-translit_from="{{ isset($article) ?: 'name' }}"
                   value="{{ isset($article) ? $article->code: '' }}"
                   required>
        </div>
        <div class="form-group">
            <label for="preview_text">Анонс</label>
            <textarea id="preview_text"
                      name="preview_text"
                      class="form-control"
                      rows="10">{{ isset($article) ? $article->preview_text: '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="detail_text">Подробно</label>
            <textarea id="detail_text"
                      name="detail_text"
                      class="form-control"
                      rows="10">{{ isset($article) ? $article->detail_text: '' }}</textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-primary"
                    name="save">Сохранить
            </button>
        </div>
    </form>
@stop