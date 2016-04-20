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

        {{--todo шаги здесь как магические числа--}}
        <div class="collapse navbar-collapse" id="component_menu">
            <ol class="nav navbar-nav">
                <li class="{{Route::is('bitrix_component_detail') ? 'active':''}}">
                    <a href="{{route('bitrix_component_detail', [$module->id, $component->id])}}">Основное{!! in_array(1, $component->steps)?' <span class="badge"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_visual_path') ? 'active':''}}">
                    <a href="{{route('bitrix_component_visual_path', [$module->id, $component->id])}}">Путь в визуальном
                        редакторе{!! in_array(2, $component->steps)?' <span class="badge"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_params') ? 'active':''}}">
                    <a href="{{route('bitrix_component_params', [$module->id, $component->id])}}">Параметры
                        подключения{!! in_array(3, $component->steps)?' <span class="badge"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_component_php') ? 'active':''}}">
                    <a href="{{route('bitrix_component_component_php', [$module->id, $component->id])}}">Component.php{!! in_array(4, $component->steps)?' <span class="badge"><span class="glyphicon glyphicon-ok aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_other_files') ? 'active':''}}">
                    <a href="{{route('bitrix_component_other_files', [$module->id, $component->id])}}">Прочие файлы{!! in_array(5, $component->steps)?' <span class="badge"><span class="glyphicon glyphicon-ok aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_templates') ? 'active':''}}">
                    <a href="{{route('bitrix_component_templates', [$module->id, $component->id])}}">Шаблоны{!! in_array(6, $component->steps)?' <span class="badge"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>':''!!}</a>
                </li>
            </ol>
        </div>
    </div>
</nav>