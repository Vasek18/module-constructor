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
@stop