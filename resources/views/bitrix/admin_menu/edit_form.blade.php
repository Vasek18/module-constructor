@extends('bitrix.internal_template')

@section('h1')
    @if (isset($admin_menu_page))
        {{ trans('bitrix_admin_menu.edit_h1') }}
    @else
        {{ trans('bitrix_admin_menu.add_h1') }}
    @endif
@stop

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>
@endpush

@section('page')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{ trans('validation.error') }}</strong> {{ trans('validation.there_occur_errors') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="col-md-8 col-md-offset-2"
          role="form"
          method="POST"
          action="{{ isset($admin_menu_page) ? action('Modules\Bitrix\BitrixAdminMenuController@update', [$module->id, $admin_menu_page->id]) : action('Modules\Bitrix\BitrixAdminMenuController@store', $module->id) }}">
        {{ csrf_field() }}
        {{ isset($admin_menu_page) ? method_field('PUT') : '' }}
        <div class="form-group">
            <label class="control-label"
                   for="name">{{ trans('bitrix_admin_menu.name') }}
            </label>
            <input type="text"
                   class="form-control"
                   name="name"
                   value="{{ isset($admin_menu_page) ? $admin_menu_page->name : "" }}"
                   required
                   aria-describedby="name_help"
                   id="name">
                <span class="help-block"
                      id="name_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="code">{{ trans('bitrix_admin_menu.code') }}
            </label>
            <input type="text"
                   class="form-control"
                   name="code"
                   value="{{ isset($admin_menu_page) ? $admin_menu_page->code : "" }}"
                   required
                   aria-describedby="code_help"
                   data-translit_from="name"
                   id="code">
                <span class="help-block"
                      id="code_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="sort">{{ trans('bitrix_admin_menu.sort') }}
            </label>
            <input type="text"
                   class="form-control"
                   name="sort"
                   value="{{ isset($admin_menu_page) ? $admin_menu_page->sort : "500" }}"
                   aria-describedby="sort_help"
                   id="sort">
                <span class="help-block"
                      id="sort_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="text">{{ trans('bitrix_admin_menu.text') }}
            </label>
            <input type="text"
                   class="form-control"
                   name="text"
                   value="{{ isset($admin_menu_page) ? $admin_menu_page->text : "" }}"
                   aria-describedby="text_help"
                   id="text">
                <span class="help-block"
                      id="text_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="parent_menu">{{ trans('bitrix_admin_menu.parent_menu') }}
            </label>
            <select class="form-control"
                    name="parent_menu"
                    aria-describedby="parent_menu_help"
                    id="parent_menu"
                    required>
                <option value="">{{ trans('app.select') }}</option>
                @foreach($parent_menu_vars as $parent_menu_var)
                    <option value="{{$parent_menu_var}}"
                            {{ isset($admin_menu_page) && $admin_menu_page->parent_menu == $parent_menu_var ? "selected" : "" }}
                    >{{ trans('bitrix_admin_menu.'.$parent_menu_var) }}</option>
                @endforeach
            </select>
                <span class="help-block"
                      id="parent_menu_help"></span>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="text">{{ trans('bitrix_admin_menu.text') }}
            </label>
            <textarea name="php_code"
                      id="php_code"
                      rows="10"
                      class="form-control">{{ isset($admin_menu_page) ? $admin_menu_page->php_code : "" }}</textarea>
        </div>
        <div class="form-group">
            <label class="control-label"
                   for="text">{{ trans('bitrix_admin_menu.text') }}
            </label>
            <textarea name="lang_code"
                      id="lang_code"
                      rows="10"
                      class="form-control">{{ isset($admin_menu_page) ? $admin_menu_page->lang_code : "" }}</textarea>
        </div>
        <div class="form-group">
            <button type="submit"
                    class="btn btn-primary"
                    name="create">
                {{ trans('app.save') }}
            </button>
        </div>
    </form>
    <div class="step-description"></div>
@stop