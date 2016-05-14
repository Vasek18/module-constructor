@extends('bitrix.internal_template')
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>
@endpush

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
        @foreach($files as $i => $file)
            <div class="list-group-item clearfix file">
                <a href="#" data-toggle="modal"
                   data-target="#edit-file_{{$i}}">{{$file->path}}{{$file->filename}}</a>
                <a href="{{ action('Modules\Bitrix\BitrixArbitraryFilesController@destroy', [$module->id, $file->id]) }}"
                   class="btn btn-danger pull-right">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </div>
            @include('bitrix.arbitrary_files.edit_modal', ['file' => $file, 'i' => $i])
        @endforeach
    </div>

    @include('bitrix.arbitrary_files.upload_modal')
@stop