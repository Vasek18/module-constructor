<div class="list-group">
    <a href="{{ route('bitrix_module_detail', $module->id) }}" class="list-group-item">Основное</a>
    <a href="#" class="list-group-item">Добавление инфоблоков</a>
    <a href="#" class="list-group-item">Добавление своих таблиц</a>
    <a href="{{ route('bitrix_module_components', $module->id) }}" class="list-group-item">Добавление компонентов</a>
    <a href="{{ route('bitrix_module_events_handlers', $module->id) }}" class="list-group-item">Обработчики событий</a>
    <a href="#" class="list-group-item">Добавление сервисов</a>
    <a href="{{ route('bitrix_module_admin_options', $module->id) }}" class="list-group-item">Страница настроек</a>
</div>