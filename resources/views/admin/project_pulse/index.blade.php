@extends("admin.template")

@section("page")
    <h1>Пульс проекта</h1>

    <form action="{{ action('Admin\AdminProjectPulseController@store') }}"
          method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Заголовок</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   required>
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description"
                      name="description"
                      class="form-control"
                      rows="10"
                      required></textarea> {{--Обязательное, иначе криво выглядит список, да и без описания пост бессмысленный--}}
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox"
                       name="highlight"
                       value="y">
                Выделить
            </label>
        </div>
        <div class="form-group">
            <button id="save"
                    name="save"
                    class="btn btn-success">Сохранить
            </button>
        </div>
    </form>
@stop