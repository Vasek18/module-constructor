@extends("admin.template")

@section("page")
    <h1>{{ $user->last_name }} {{ $user->first_name }}</h1>
    <p>Зарегистрировался: {{ $user->created_at }}</p>
    <h2>Модули на Битриксе</h2>
    <div class="list-group">
        @foreach($bitrixes as $bitrix)
            <a href="{{ action('Admin\AdminController@modulesDetail', ['bitrix' => $bitrix]) }}"
               class="list-group-item">
                {{ $bitrix->name }} ({{ $bitrix->full_id }})
            </a>
        @endforeach
    </div>
@stop