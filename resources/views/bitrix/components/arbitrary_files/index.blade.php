@extends('bitrix.internal_template')

@section('h1')
    Прочие файлы компонента | Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

    <h2>Добавить файл</h2>
    <form action="{{ action('Modules\Bitrix\BitrixComponentsArbitraryFilesController@store', [$module->id, $component->id]) }}"
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
        <div class="form-group">
            <button class="btn btn-primary">Добавить</button>
        </div>
    </form>
    @if (count($files))
        <h3>Список файлов</h3>
        <div class="list-group">
            @foreach($files as $i => $file)
                <div class="list-group-item clearfix file">
                    <a href="#">{{$file->path}}{{$file->filename}}</a>
                    <a href="{{ action('Modules\Bitrix\BitrixComponentsArbitraryFilesController@destroy', [$module->id, $component->id, $file->id]) }}"
                       class="btn btn-danger pull-right">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop
