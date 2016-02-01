@extends("app")

@section("content")
    <div class="container">
        <h1>Личный кабинет</h1>
        <h2>Список модулей</h2>
        @if ( !$modules->isEmpty())
            @foreach($modules as $module)
                {{$module->MODULE_NAME}}
            @endforeach

        @endif
    </div>
@stop