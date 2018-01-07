@extends('bitrix.internal_template')

@section('h1')
    Создание шаблона сайта
@stop

@section('page')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{trans('validation.error')}}</strong> {{trans('validation.there_occur_errors')}}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-horizontal"
          role="form"
          method="POST"
          action="{{ action('Modules\Bitrix\BitrixSiteTemplatesController@store', $module->id) }}"
          enctype="multipart/form-data">
        <input type="hidden"
               name="_token"
               value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="name"
                   class="col-md-4 control-label">Название</label>
            <div class="col-md-6">
                <input type="text"
                       class="form-control"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       aria-describedby="name_help"
                       id="name">
                <span class="help-block"
                      id="name_help"></span>
            </div>
        </div>
        {{--<div class="form-group">
            <label for="code"
                   class="col-md-4 control-label">Код</label>
            <div class="col-md-6">
                <input type="text"
                       class="form-control"
                       name="code"
                       value="{{ old('code') }}"
                       required
                       aria-describedby="code_help"
                       id="code"
                       data-translit_from="name"
                       data-transform="">
                <span class="help-block"
                      id="code_help"></span>
            </div>
        </div>--}}
        <div class="form-group">
            <label for="description"
                   class="col-md-4 control-label">Описание</label>
            <div class="col-md-6">
             <textarea id="description"
                       name="description"
                       class="form-control"
                       aria-describedby="description_help"
             >{{ old('description') }}</textarea>
                <span class="help-block"
                      id="description_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="sort"
                   class="col-md-4 control-label">Сортировка</label>
            <div class="col-md-6">
                <input type="text"
                       name="sort"
                       class="form-control"
                       aria-describedby="sort_help"
                       value="{{ old('code')?:'500' }}">
                <span class="help-block"
                      id="sort_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="archive"
                   class="col-md-4 control-label">Архив с шаблоном</label>
            <div class="col-md-6">
                <input class="form-control"
                       type="file"
                       name="archive"
                       id="archive"
                       required
                       accept=".zip"
                >
                <span class="help-block"
                      id="sort_help">Архив должен содержать только папку одного шаблона с файлами внутри. То есть в корне должна быть лишь одна папка и никаких файлов.</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit"
                        class="btn btn-primary"
                        name="create">
                    {{ trans('app.create') }}
                </button>
            </div>
        </div>
    </form>
    <div class="step-description"></div>
@stop