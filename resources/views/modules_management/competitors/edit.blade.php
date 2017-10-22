@extends('modules_management.internal_template')

@section('h1')
    Записать конкурента
@stop

@section("page")
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="{{ action('Modules\Management\ModulesCompetitorsController@update', [$module->id, $competitor->id]) }}"
                  method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control"
                           value="{{ $competitor->name }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="link">Ссылка</label>
                    <input type="url"
                           id="link"
                           name="link"
                           class="form-control"
                           value="{{ $competitor->link }}"
                    >
                </div>
                <div class="form-group">
                    <label for="price">Цена</label>
                    <input type="text"
                           id="price"
                           name="price"
                           class="form-control"
                           value="{{ $competitor->price }}"
                    >
                </div>
                <div class="form-group">
                    <label for="sort">Сортировка</label>
                    <input type="text"
                           id="sort"
                           name="sort"
                           class="form-control"
                           value="{{ $competitor->sort }}"
                    >
                </div>
                <div class="form-group">
                    <label for="comment">Ваш комментарий</label>
                    <textarea id="comment"
                              name="comment"
                              class="form-control"
                              rows="10">{{ $competitor->comment }}</textarea>
                </div>
                <div class="form-group">
                    <button id="save"
                            name="save"
                            class="btn btn-success">Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop