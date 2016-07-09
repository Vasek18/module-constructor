@extends('bitrix.internal_template')@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>@endpush

@section('h1')
    {{ trans('bitrix_arbitrary_files.h1') }}
@stop

@section('page')
    <p>
        <a href="#"
           class="btn btn-success"
           data-toggle="modal"
           data-target="#upload-file">{{ trans('bitrix_arbitrary_files.button_add_file') }}
        </a>
    </p>
    @if (count($files_for_module))
        <h2>{{ trans('bitrix_arbitrary_files.in_module_files') }}</h2>
        <div class="list-group">
            @foreach($files_for_module as $i => $file)
                <div class="list-group-item clearfix file deletion_wrapper">
                    <a href="#"
                       data-toggle="modal"
                       data-target="#edit-file_{{$i}}{{$file->id}}">{{$file->path}}{{$file->filename}}</a>
                    <a href="{{ action('Modules\Bitrix\BitrixArbitraryFilesController@destroy', [$module->id, $file->id]) }}"
                       class="btn btn-danger pull-right human_ajax_deletion"
                       data-method="get"
                       id="delete_af_{{$file->id}}">
                    <span class="glyphicon glyphicon-trash"
                          aria-hidden="true"></span>
                    </a>
                </div>
                @include('bitrix.arbitrary_files.edit_modal', ['file' => $file, 'i' => $i.$file->id])
            @endforeach
        </div>
    @endif
    @if (count($files_for_site))
        <h2>{{ trans('bitrix_arbitrary_files.on_site_files') }}</h2>
        <div class="list-group">
            @foreach($files_for_site as $i => $file)
                <div class="list-group-item clearfix file deletion_wrapper">
                    <a href="#"
                       data-toggle="modal"
                       data-target="#edit-file_{{$i}}{{$file->id}}">{{$file->path}}{{$file->filename}}</a>
                    <a href="{{ action('Modules\Bitrix\BitrixArbitraryFilesController@destroy', [$module->id, $file->id]) }}"
                       class="btn btn-danger pull-right human_ajax_deletion"
                       data-method="get"
                       id="delete_af_{{$file->id}}">
                    <span class="glyphicon glyphicon-trash"
                          aria-hidden="true"></span>
                    </a>
                </div>
                @include('bitrix.arbitrary_files.edit_modal', ['file' => $file, 'i' => $i.$file->id])
            @endforeach
        </div>
    @endif

    @include('bitrix.arbitrary_files.upload_modal')

    <hr>
    <p class="description">{!! trans('bitrix_arbitrary_files.description') !!}</p>
@stop