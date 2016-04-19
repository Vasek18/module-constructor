<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#component_menu" aria-expanded="false">
                <span class="sr-only">Меню</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="component_menu">
            <ol class="nav navbar-nav">
                <li><a href="{{action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id])}}">Основное</a></li>
                <li><a href="{{action('Modules\Bitrix\BitrixComponentsController@show_visual_path', [$module->id, $component->id])}}">Путь в визуальном редакторе</a></li>
                <li><a href="{{action('Modules\Bitrix\BitrixComponentsController@show_params', [$module->id, $component->id])}}">Параметры подключения</a></li>
                <li><a href="{{action('Modules\Bitrix\BitrixComponentsController@show_component_php', [$module->id, $component->id])}}">Component.php</a></li>
                <li><a href="{{action('Modules\Bitrix\BitrixComponentsController@show_other_files', [$module->id, $component->id])}}">Прочие файлы</a></li>
                <li><a href="{{action('Modules\Bitrix\BitrixComponentsController@show_templates', [$module->id, $component->id])}}">Шаблоны</a></li>
            </ol>
        </div>
    </div>
</nav>