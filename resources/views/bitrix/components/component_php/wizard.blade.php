<form class="wizard"
      action="{{ action('Modules\Bitrix\BitrixComponentsController@get_templates', ['module'=>$module->id, 'component' => $component->id]) }}">
    <h2>{{ trans('bitrix_components.logic_wizard_title') }}</h2>
    <b>{{ trans('bitrix_components.logic_wizard_text') }}</b>
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