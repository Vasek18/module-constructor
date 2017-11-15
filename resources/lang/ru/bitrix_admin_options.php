<?php

return [
    'h1'                         => 'Страница настроек',
    'option_name'                => 'Название свойства',
    'option_code'                => 'Код свойства',
    'option_type'                => 'Тип свойства',
    'option_additional_settings' => 'Доп. поля',
    'tab_name'                   => 'Вкладка',
    'add_row'                    => 'Добавить строчку',
    'save'                       => 'Сохранить',
    'step_description'           => 'Здесь задаются настройки, которые можно будет получить на сайте через
        COption::GetOptionString("{код модуля}", "{код опции}");. Сами значения задаются на странице настроек модуля (Настройки -> Настройки модулей -> Название модуля).
        <br>
        Также вместе с указанными вами настройками создастся вкладка со стандартными настройками прав модуля.',
    'hints'                      => 'Чтобы подставить значение одного свойства в другое, впишите в значение последнего:
    <pre>
        COption::GetOptionString($module_id, "{Код вашего свойства}")
    </pre>',
    'name'                       => 'Название',
    'code'                       => 'Код',
    'type'                       => 'Тип',
    'additional_settings_button' => 'Редактировать',
    'delete'                     => 'Удалить',
    'additional_settings_title'  => 'Дополнительные настройки',
    'height'                     => 'Высота',
    'width'                      => 'Ширина',
    'specific_values'            => 'Конкретные значения',
    'option_option_default'      => 'По умол.',
    'or'                         => 'или',
    'iblocks_list'               => 'Список инфоблоков',
    'iblock_elements_list'       => 'Список элементов инфоблока',
    'iblock_sections_list'       => 'Список разделов инфоблока',
    'iblock_props_list'          => 'Список свойств инфоблока',
    'iblock'                     => 'Инфоблок',
    'value_by_default'           => 'Значение по умолчанию',
    'checkbox_type'              => 'Чекбокс',
    'multiselectbox_type'        => 'Множественный селект',
    'selectbox_type'             => 'Селект',
    'text_type'                  => 'Строка',
    'textarea_type'              => 'Многострочный текст',
    'no_additional_params'       => 'Нет доп. параметров',
    'bitrix_receive_code'        => 'Код для получения значения',
    'tab_name_default'           => 'Основное',
];
