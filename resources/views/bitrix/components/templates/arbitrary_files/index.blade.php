@extends('bitrix.components.templates.internal_template')

@section('h1')
    {{ trans('bitrix_components.arbitrary_files_h1') }} | {{ trans('bitrix_components.component') }} {{ $component->name }} ({{ $component->code }})
@stop

@section('templates_page')
    <h2>{{ trans('bitrix_components.arbitrary_files_form_title') }}</h2>
    <form action="{{ action('Modules\Bitrix\BitrixComponentsArbitraryFilesController@store', [$module->id, $component->id]) }}"
          method="post"
          enctype="multipart/form-data">
        {{ csrf_field() }}
        @if (isset($template))
            <input type="hidden"
                   name="template_id"
                   value="{{ $template->id }}">
        @endif
        <div class="form-group">
            <label for="path">{{ trans('bitrix_components.arbitrary_files_field_path') }}</label>
            <input class="form-control"
                   type="text"
                   name="path"
                   id="path"
                   value="/"
                   required>
        </div>
        <div class="form-group">
            <label for="file">{{ trans('bitrix_components.arbitrary_files_field_file') }}</label>
            <input class="form-control"
                   type="file"
                   name="file"
                   id="file"
                   required>
        </div>
        <div class="form-group">
            <button class="btn btn-primary"
                    name="upload">{{ trans('bitrix_components.arbitrary_files_button_add_file') }}</button>
        </div>
    </form>
    @if (count($files))
        <h3>{{ trans('bitrix_components.arbitrary_files_list') }}</h3>
        <div class="list-group">
            @foreach($files as $i => $file)
                <div class="list-group-item clearfix file">
                    <a href="#">{{$file->path}}{{$file->filename}}</a>
                    <a href="{{ action('Modules\Bitrix\BitrixComponentsArbitraryFilesController@destroy', [$module->id, $component->id, $file->id]) }}"
                       class="btn btn-danger pull-right">
                        <span class="glyphicon glyphicon-trash"
                              aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop
