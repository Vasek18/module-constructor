<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bitrix_menu" aria-expanded="false">
                <span class="sr-only">Меню</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bitrix_menu">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('bitrix_module_detail', $module->id) }}">Основное</a></li>
                <li><a href="{{ route('bitrix_module_components', $module->id) }}">Компоненты</a></li>
                <li><a href="{{ route('bitrix_module_events_handlers', $module->id) }}">Обработчики событий</a></li>
                <li><a href="{{ route('bitrix_module_admin_options', $module->id) }}">Страница настроек</a></li>
                <li><a href="{{ route('bitrix_module_data_storage', $module->id) }}">Хранение данных</a></li>
            </ul>
        </div>
    </div>
</nav>

{{--
<div class="list-group">
    <a href="{{ route('bitrix_module_detail', $module->id) }}" class="list-group-item">Основное</a>
    <a href="{{ route('bitrix_module_components', $module->id) }}" class="list-group-item">Добавление компонентов</a>
    <a href="{{ route('bitrix_module_events_handlers', $module->id) }}" class="list-group-item">Обработчики событий</a>
    <a href="{{ route('bitrix_module_admin_options', $module->id) }}" class="list-group-item">Страница настроек</a>
</div>--}}
