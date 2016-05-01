@extends('bitrix.internal_template')

@section('h1')
    Прочие файлы компонента | Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

    <h2>Добавить файл</h2>
    <form action="{{ action('Modules\Bitrix\BitrixComponentsController@store_other_files', [$module->id, $component->id]) }}"
          method="post"
          enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="path">Путь</label>
            <input class="form-control" type="text" name="path" id="path" value="/" required>
        </div>
        <div class="form-group">
            <label for="file">Имя</label>
            <input class="form-control" type="file" name="new_file" id="file" required>
        </div>
        <button class="btn btn-primary">Добавить</button>
    </form>

@stop
