<?php

return [
	'h1'         => 'Компоненты',
	'button_add' => 'Добавить компонент',
	'components' => 'Компоненты',
	'component'  => 'Компонент',

	'button_upload_zip'       => 'Загрузить архивом',
	'upload_zip_window_title' => 'Загрузка архива компонента',
	'archive_field'           => 'Архив',
	'button_upload'           => 'Загрузить',

	'new_h1'                         => 'Создание компонента',
	'field_component_name'           => 'Название',
	'field_component_name_help'      => 'Название компонента, которое будет отображаться в визуальном редакторе, да и во всевозможных списках внутри конструктора',
	'field_component_code'           => 'Код',
	'field_component_code_help'      => 'Этот код используется в подключении компонента в php-коде',
	'field_component_desc'           => 'Описание',
	'field_component_desc_help'      => 'Показывается при редактировании параметров компонента при наведении на кнопочку с \'i\'. Но в любом случае не лишним будет',
	'field_component_sort'           => 'Вес сортировки',
	'field_component_sort_help'      => 'Это нужно для сортировки в списке компонентов внутри группы при редактировании страницы',
	'field_component_namespace'      => 'Пространство имён',
	'field_component_namespace_help' => 'Папка, в которой хранятся компоненты',
	'button_create_component'        => 'Создать компонент',

	'menu_title_main_info'     => 'Основное',
	'menu_title_visual_path'   => 'Путь в визуальном редакторе',
	'menu_title_params'        => 'Параметры подключения',
	'menu_title_component_php' => 'Логика',
	'menu_title_other_files'   => 'Прочие файлы',
	'menu_title_templates'     => 'Шаблоны',

	'main_info_title' => 'Информация',

	'visual_path_h1'          => 'Путь в визуальном редакторе',
	'level'                   => 'Уровень',
	'visual_path_field_id'    => 'Идентификатор',
	'visual_path_field_name'  => 'Название',
	'visual_path_field_sort'  => 'Сортировка',
	'visual_path_button_save' => 'Сохранить путь',

	'params_h1'                                   => 'Параметры подключения',
	'params_button_upload'                        => 'Загрузить готовые файлы',
	'params_upload_window_title'                  => 'Загрузка файлов параметров компонента',
	'params_upload_window_field_params_file'      => 'Файл',
	'params_upload_window_field_params_lang_file' => 'Языковой файл',
	'params_name_column'                          => 'Название свойства',
	'params_code_column'                          => 'Код свойства',
	'params_type_column'                          => 'Тип свойства',
	'params_group_column'                         => 'Группа свойства',
	'params_field_name'                           => 'Название',
	'params_field_code'                           => 'Код',
	'params_field_type'                           => 'Тип',
	'params_type_CHECKBOX'                        => 'Чекбокс',
	'params_type_FILE'                            => 'Файл',
	'params_type_LIST'                            => 'Список',
	'params_type_STRING'                          => 'Строка',
	'params_field_group'                          => 'Группа',
	'params_group_BASE'                           => 'Основные параметры',
	'params_group_DATA_SOURCE'                    => 'Источник данных',
	'params_group_VISUAL'                         => 'Внешний вид',
	'params_group_URL_TEMPLATES'                  => 'Шаблоны ссылок',
	'params_group_SEF_MODE'                       => 'Настройки ЧПУ',
	'params_group_AJAX_SETTINGS'                  => 'Настройки ajax',
	'params_group_CACHE_SETTINGS'                 => 'Настройки кеширования',
	'params_group_ADDITIONAL_SETTINGS'            => 'Дополнительные настройки',
	'params_field_dop_params'                     => 'Доп. параметры',

	'additional_settings_title'       => 'Дополнительные настройки',
	'params_dop_sort'                 => 'Вес сортировки',
	'params_dop_refresh'              => 'Обновляет ли остальные настройки?',
	'params_dop_multiple'             => 'Множественное?',
	'params_dop_height'               => 'Высота',
	'params_dop_width'                => 'Ширина',
	'params_dop_value_by_default'     => 'Значение по умолчанию',
	'params_dop_show_dop_values'      => 'Показывать дополнительные значения?',
	'params_dop_specific_values'      => 'Конкретные значения',
	'params_dop_iblocks_types_list'   => 'Список типов инфоблоков',
	'params_dop_iblocks_list'         => 'Список инфоблоков',
	'params_dop_or'                   => 'или',
	'params_dop_iblock_elements_list' => 'Список элементов инфоблока',
	'params_dop_iblock_props_list'    => 'Список свойств инфоблока',
	'params_dop_iblock_type'          => 'Тип инфоблоков',
	'params_dop_iblock'               => 'Инфоблок',
	'params_dop_template_id'          => 'Только для шаблона',
	'for_all_templates'               => 'Для всех шаблонов',
	'params_step_description'         => 'Здесь задаются те настройки, которые будут выводиться для администратора сайта при добавлении/редактировании компонента на странице сайта.',
	'params_hints'                    => 'Чтобы подставить значение одного свойства в другое, впишите в значение последнего: <pre>
        $arCurrentValues["{Код вашего свойства}"]
    </pre>
    Чтобы подставить значение настройки модуля, впишите:
    <pre>
        COption::GetOptionString($module_id, "{Код свойства}")
    </pre>',

	'logic_wizard_title'                 => 'Мастер заготовок',
	'logic_wizard_text'                  => 'Включить:',
	'logic_wizard_items_list'            => 'Список элементов',
	'logic_wizard_items_list_with_props' => 'Список элементов со свойствами',

	'arbitrary_files_h1'              => 'Прочие файлы компонента',
	'arbitrary_files_form_title'      => 'Добавить файл',
	'arbitrary_files_field_path'      => 'Путь',
	'arbitrary_files_field_file'      => 'Файл',
	'arbitrary_files_button_add_file' => 'Добавить',
	'arbitrary_files_list'            => 'Список файлов',

	'templates_h1'            => 'Шаблоны',
	'templates_list'          => 'Шаблоны',
	'templates_button_create' => 'Создать шаблон',
	'templates_button_upload' => 'Загрузить шаблон',
	'templates_upload_title'  => 'Загрузить шаблон',
	'templates_create_title'  => 'Создать шаблон',
	'templates_field_code'    => 'Код',
	'templates_field_name'    => 'Название',
	'templates_field_files'   => 'Файлы',

	'template'                                 => 'Шаблон',
	'template_detail_title'                    => 'Основные файлы',
	'template_field_template_php_code'         => 'Файл шаблона',
	'template_field_style_css_code'            => 'Стили',
	'template_field_script_js_code'            => 'JS-скрипты',
	'template_field_result_modifier_php_code'  => 'result_modifier.php',
	'template_field_component_epilog_php_code' => 'component_epilog.php',

	'template_menu_item_detail'          => 'Основные файлы',
	'template_menu_item_params'          => 'Параметры подключения',
	'template_menu_item_arbitrary_files' => 'Дополнительные файлы',
];
