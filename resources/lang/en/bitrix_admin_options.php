<?php

return [
	'h1'                         => 'Admin settings page',
	'option_name'                => 'Setting name',
	'option_code'                => 'Setting code',
	'option_type'                => 'Setting type',
	'option_additional_settings' => 'Add. fields',
	'add_row'                    => 'Add row',
	'save'                       => 'Save',
	'step_description'           => 'Here you can set those settings, which will be available online using
        COption::GetOptionString("{module code}", "{option code}");. The actual values are set on the module settings page (Settings -> Modules settings -> Module name).
        <br>
        Also, with the settings you specify, the tab with the standard module rights settings will be created.',
	'hints'                      => 'To substitute the value of one setting to another, fill in the value of the last:
    <pre>
        COption::GetOptionString($module_id, "{setting code}")
    </pre>',
	'name'                       => 'Name',
	'code'                       => 'Code',
	'type'                       => 'Type',
	'additional_settings_button' => 'Edit',
	'delete'                     => 'delete',
	'additional_settings_title'  => 'Additional fields',
	'height'                     => 'Height',
	'width'                      => 'Width',
	'specific_values'            => 'Specific values',
	'option_option_default'      => 'Default',
	'or'                         => 'Or',
	'iblocks_list'               => 'Iblocks list',
	'iblock_elements_list'       => 'Iblock elements list',
	'iblock_props_list'          => 'Iblock props list',
	'iblock'                     => 'Iblock',
	'value_by_default'           => 'Default value',
	'checkbox_type'              => 'Checkbox',
	'multiselectbox_type'        => 'Multiselect',
	'selectbox_type'             => 'Select',
	'text_type'                  => 'String',
	'textarea_type'              => 'Textarea',
	'no_additional_params'       => 'No additional fields',
	'bitrix_receive_code'        => 'Code to get the value',
];