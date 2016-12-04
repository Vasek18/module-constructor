@extends("admin.template")

@section("page")
    <h1>Настройки</h1>

    <table class="table table-bordered">
        <tr>
            <th>Название</th>
            <th>Код</th>
            <th>Значение</th>
        </tr>
        @foreach($settings as $setting)
            <tr>
                <td>{{ $setting->name }}</td>
                <td>{{ $setting->code }}</td>
                <td>
                    <form class="row"
                          action="{{ action('Admin\AdminSettingsController@set', [$setting]) }}"
                          method="post">
                        {{ csrf_field() }}
                        <div class="col-md-8">
                            <input type="text"
                                   class="form-control"
                                   name="value"
                                   value="{{ $setting->value }}">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary"
                                    name="save_{{ $setting->code }}">Сохранить
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ action('Admin\AdminSettingsController@store') }}"
                  method="post">
                {{ csrf_field() }}
                <h2>Создать настройку</h2>
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control"
                           required>
                </div>
                <div class="form-group">
                    <label for="code">Код</label>
                    <input type="text"
                           id="code"
                           name="code"
                           class="form-control"
                           required>
                </div>
                <div class="form-group">
                    <label for="value">Значение</label>
                    <input type="text"
                           id="value"
                           name="value"
                           class="form-control"
                           required>
                </div>
                <div class="form-group">
                    <button id="create"
                            name="create"
                            class="btn btn-success">Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop