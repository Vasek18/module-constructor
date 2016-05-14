@extends('bitrix.internal_template')

@section('h1')
    Произвольные файлы
@stop

@section('page')
    <p>
        <a href="#" class="btn btn-success" data-toggle="modal"
           data-target="#upload-file">Добавить файл
        </a>
    </p>
    <div class="list-group">
        @foreach($files as $file)
            <div class="list-group-item clearfix file">
                <a href="#">{{$file->path}}{{$file->filename}}</a>
                <a href="{{ action('Modules\Bitrix\BitrixArbitraryFilesController@destroy', [$module->id, $file->id]) }}"
                   class="btn btn-danger pull-right">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </div>
        @endforeach
    </div>

    @include('bitrix.arbitrary_files.upload_modal')
@stop