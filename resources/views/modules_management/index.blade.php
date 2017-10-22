@extends('modules_management.internal_template')

@section('h1')
    Основное
@stop

@section("page")
<div class="row">
    <div class="col-md-10">
        <form method="post"
              action="{{ action('Modules\Bitrix\BitrixController@update', $module->id) }}"
              class="readonly">
            <input type="hidden"
                   name="_token"
                   value="{{ csrf_token() }}">
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="name">{{ trans('bitrix.field_name') }}</label>
                <p class="form-control-static">
                 {{ $module->name }}
                </p>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('bitrix.field_description') }}</label>
                <p class="form-control-static">
                    {{ $module->description }}
                </p>
            </div>
            <div class="form-group">
                <label for="description">Ключевые слова</label>
                <p class="form-control-static">
                    <a href="#"
                       class="you-can-change ajax"
                       data-name="keywords"
                       data-formtype="textarea"
                       data-pattern=".+">{{ $module->keywords }}</a>
                </p>
            </div>
            <button type="submit"
                    class="hidden">{{ trans('app.save') }}
            </button>
        </form>
    </div>
</div>
@stop