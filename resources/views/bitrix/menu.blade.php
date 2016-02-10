{{--todo мб на action на route заменить?--}}
<div class="list-group">
    <a href="{{ action('Modules\BitrixController@detail', $module->id) }}" class="list-group-item">Основное</a>
    <a href="#" class="list-group-item">Добавление инфоблоков</a>
    <a href="#" class="list-group-item">Добавление своих таблиц</a>
    <a href="{{ action('Modules\BitrixController@components', $module->id) }}" class="list-group-item">Добавление компонентов</a>
    <a href="{{ action('Modules\BitrixController@events_handlers', $module->id) }}" class="list-group-item">Работа с событиями</a>
    <a href="#" class="list-group-item">Добавление сервисов</a>
    <a href="{{ action('Modules\BitrixController@admin_options', $module->id) }}" class="list-group-item">Страница настроек</a>
</div>