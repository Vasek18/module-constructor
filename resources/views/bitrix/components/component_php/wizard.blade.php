<form class="wizard"
      action="{{ action('Modules\Bitrix\BitrixComponentsController@get_logic_files_templates', ['module'=>$module->id, 'component' => $component->id]) }}">
    <h2>{{ trans('bitrix_components.logic_wizard_title') }}</h2>
    <b>{{ trans('bitrix_components.logic_wizard_text') }}</b>
    @if(count($class_php_templates))
        <h3>{{ trans('bitrix_components.logic_wizard_my_templates_title') }}</h3>
        @foreach($class_php_templates as $class_php_template)
            <div class="row">
                <div class="col-md-3">
                    <div class="radio">
                        <label>
                            <input type="radio"
                                   name="template"
                                   value="{{ $class_php_template->id }}">
                            {{ $class_php_template->name }}
                        </label>
                    </div>
                </div>
                <div class="col-md-1">
                    <a href="#"
                       class="btn btn-danger btn-sm delete">
                    <span class="glyphicon glyphicon-trash"
                          aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        @endforeach
        <h3>{{ trans('bitrix_components.logic_wizard_common_templates_title') }}</h3>
    @endif
    <div class="form-group">
        <div class="radio">
            <label>
                <input type="radio"
                       name="items_list"
                       value="items_list">
                {{ trans('bitrix_components.logic_wizard_items_list') }}
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio"
                       name="items_list"
                       value="items_list_with_props">
                {{ trans('bitrix_components.logic_wizard_items_list_with_props') }}
            </label>
        </div>
    </div>
</form>
@include('bitrix.components.component_php.add_template')