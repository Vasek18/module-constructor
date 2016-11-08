@extends("admin.template")

@section("page")
    @if (isset($section))
        <h1>Редактировать категорию статей "{{ $section->name }}"</h1>
    @else
        <h1>Добавить категорию статей</h1>
    @endif
    <form action="{{  isset($section) ? action('Admin\AdminArticleSectionsController@update', [$section]) : action('Admin\AdminArticleSectionsController@store') }}"
          method="post">
        {{ csrf_field() }}
        @if (isset($section))
            {{ method_field('PUT') }}
        @else
            {{ method_field('POST') }}
        @endif
        <div class="checkbox">
            <input type="hidden"
                   name="active"
                   value="0">
            <label>
                <input type="checkbox"
                       value="1"
                       name="active"
                        {{ isset($section) && $section->active ? 'checked' : '' }}>
                Активно
            </label>
        </div>
        <div class="form-group">
            <label for="sort">Сортировка</label>
            <input type="text"
                   id="sort"
                   name="sort"
                   class="form-control"
                   value="{{ isset($section) ? $section->sort: '500' }}">
        </div>
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   value="{{ isset($section) ? $section->name: '' }}"
                   required>
        </div>
        <div class="form-group">
            <label for="code">Код</label>
            <input type="text"
                   id="code"
                   name="code"
                   class="form-control"
                   data-translit_from="{{ isset($section) ?: 'name' }}"
                   value="{{ isset($section) ? $section->code: '' }}"
                   required>
        </div>
        <div class="form-group">
            <label for="preview_text">Анонс</label>
            <textarea id="preview_text"
                      name="preview_text"
                      class="form-control"
                      rows="3">{{ isset($section) ? $section->preview_text: '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="detail_text">Подробно</label>
            <textarea id="detail_text"
                      name="detail_text"
                      class="form-control"
                      rows="10">{{ isset($section) ? $section->detail_text: '' }}</textarea>
        </div>
        <hr>
        <div class="form-group">
            <label for="seo_title">Тайтл</label>
            <input type="text"
                   id="seo_title"
                   name="seo_title"
                   class="form-control"
                   data-copy_from="name"
                   value="{{ isset($section) ? $section->seo_title: '' }}">
        </div>
        <div class="form-group">
            <label for="seo_keywords">Кейвордс</label>
            <textarea id="seo_keywords"
                      name="seo_keywords"
                      class="form-control"
                      rows="3">{{ isset($section) ? $section->seo_keywords: '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="seo_description">Дескрипшион</label>
            <textarea id="seo_description"
                      name="seo_description"
                      class="form-control"
                      rows="3">{{ isset($section) ? $section->seo_description: '' }}</textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-primary"
                    name="save">Сохранить
            </button>
        </div>
    </form>
@stop