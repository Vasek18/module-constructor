<?php

return [
	'h1'         => 'Components',
	'button_add' => 'Add component',
	'components' => 'Components',
	'component'  => 'Component',

	'button_upload_zip'       => 'Parse from zip',
	'upload_zip_window_title' => 'Zip upload',
	'archive_field'           => 'Archive',
	'button_upload'           => 'Upload',

	'new_h1'                         => 'Component creation',
	'field_component_name'           => 'Name',
	'field_component_name_help'      => 'The name of the component that will be displayed in the visual editor, and in all sorts of lists inside the constructor',
	'field_component_code'           => 'Code',
	'field_component_code_help'      => 'This code is used to connect the component in the php code',
	'field_component_desc'           => 'Description',
	'field_component_desc_help'      => 'It is shown during editing the component parameters when you hover over a button with the \'i\'. But in any case, it will not be superfluous',
	'field_component_sort'           => 'Sorting weight',
	'field_component_sort_help'      => 'It is necessary to sort the list of components within a group when editing the page',
	'field_component_namespace'      => 'Namespace',
	'field_component_namespace_help' => 'The folder in which the components are stored',
	'button_create_component'        => 'Create component',

	'menu_title_main_info'     => 'Main info',
	'menu_title_visual_path'   => 'Visual path',
	'menu_title_params'        => 'Params',
	'menu_title_component_php' => 'Component.php',
	'menu_title_other_files'   => 'Other files',
	'menu_title_templates'     => 'Templates',

	'main_info_title' => 'Information',

	'visual_path_h1'          => 'Visual path',
	'level'                   => 'Level',
	'visual_path_field_id'    => 'ID',
	'visual_path_field_name'  => 'Name',
	'visual_path_field_sort'  => 'Sort',
	'visual_path_button_save' => 'Save path',

	'params_h1'                                   => 'Params',
	'params_button_upload'                        => 'Upload prepared files',
	'params_upload_window_title'                  => 'Component params files upload',
	'params_upload_window_field_params_file'      => 'File',
	'params_upload_window_field_params_lang_file' => 'Lang file',
	'params_name_column'                          => 'Param name',
	'params_code_column'                          => 'Param code',
	'params_type_column'                          => 'Param type',
	'params_group_column'                         => 'Param group',
	'params_field_name'                           => 'Name',
	'params_field_code'                           => 'Code',
	'params_field_type'                           => 'Type',
	'params_type_CHECKBOX'                        => 'Checkbox',
	'params_type_FILE'                            => 'File',
	'params_type_LIST'                            => 'List',
	'params_type_STRING'                          => 'String',
	'params_field_group'                          => 'Group',
	'params_group_BASE'                           => 'Main params',
	'params_group_DATA_SOURCE'                    => 'Data sourse',
	'params_group_VISUAL'                         => 'Appearance',
	'params_group_URL_TEMPLATES'                  => 'Links templates',
	'params_group_SEF_MODE'                       => 'Semantic URL',
	'params_group_AJAX_SETTINGS'                  => 'Ajax settings',
	'params_group_CACHE_SETTINGS'                 => 'Cache settings',
	'params_group_ADDITIONAL_SETTINGS'            => 'Additional settings',
	'params_field_dop_params'                     => 'Additional settings',

	'additional_settings_title'       => 'Additional settings',
	'params_dop_refresh'              => 'Refresh other settings?',
	'params_dop_multiple'             => 'Multiple?',
	'params_dop_height'               => 'Height',
	'params_dop_width'                => 'Width',
	'params_dop_value_by_default'     => 'Default value',
	'params_dop_show_dop_values'      => 'Show additional values?',
	'params_dop_specific_values'      => 'Specific values',
	'params_dop_iblocks_types_list'   => 'Infoblock types list',
	'params_dop_iblocks_list'         => 'Infoblocks list',
	'params_dop_or'                   => 'or',
	'params_dop_iblock_elements_list' => 'Infoblock elements list',
	'params_dop_iblock_props_list'    => 'Infoblock props list',
	'params_dop_iblock_type'          => 'Infoblock type',
	'params_dop_iblock'               => 'Infoblock',
	'params_dop_template_id'          => 'Only for template',
	'for_all_templates'               => 'For all templates',
	'params_step_description'         => 'Here you can set those settings that will be displayed to the site administrator during adding / editing a component on the site page.',
	'params_hints'                    => 'To substitute the value of one setting to another, fill in the value of the last: <pre>
        $arCurrentValues["{setting code}"]
    </pre>',

	'arbitrary_files_h1'              => 'Other component files',
	'arbitrary_files_form_title'      => 'Add file',
	'arbitrary_files_field_path'      => 'Path',
	'arbitrary_files_field_file'      => 'File',
	'arbitrary_files_button_add_file' => 'Add',
	'arbitrary_files_list'            => 'Files list',

	'templates_h1'            => 'Templates',
	'templates_list'          => 'Templates',
	'templates_button_create' => 'Create template',
	'templates_button_upload' => 'Upload template',
	'templates_upload_title'  => 'Upload template',
	'templates_create_title'  => 'Create template',
	'templates_field_code'    => 'Code',
	'templates_field_name'    => 'Name',
	'templates_field_files'   => 'Files',

	'template'                                 => 'Template',
	'template_detail_title'                    => 'Main files',
	'template_field_template_php_code'         => 'template.php',
	'template_field_style_css_code'            => 'style.css',
	'template_field_script_js_code'            => 'script.js',
	'template_field_result_modifier_php_code'  => 'result_modifier.php',
	'template_field_component_epilog_php_code' => 'component_epilog.php',

	'template_menu_item_detail'          => 'Main files',
	'template_menu_item_params'          => 'Params',
	'template_menu_item_arbitrary_files' => 'Additional files',
];
