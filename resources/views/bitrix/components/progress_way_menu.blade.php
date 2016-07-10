<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button"
                    class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#component_menu"
                    aria-expanded="false">
                <span class="sr-only">{{ trans('app.menu') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        {{--todo шаги здесь как магические числа--}}
        <div class="collapse navbar-collapse progressive-way-menu"
             id="component_menu">
            <ol class="nav navbar-nav">
                <li class="{{Route::is('bitrix_component_detail') ? 'active':''}}">
                    <a href="{{route('bitrix_component_detail', [$module->id, $component->id])}}">{{ trans('bitrix_components.menu_title_main_info') }}{!! in_array(1, $component->steps)?' <span class="badge success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_visual_path') ? 'active':''}}">
                    <a href="{{route('bitrix_component_visual_path', [$module->id, $component->id])}}">{{ trans('bitrix_components.menu_title_visual_path') }}{!! in_array(2, $component->steps)?' <span class="badge success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_params') ? 'active':''}}">
                    <a href="{{route('bitrix_component_params', [$module->id, $component->id])}}">{{ trans('bitrix_components.menu_title_params') }}{!! in_array(3, $component->steps)?' <span class="badge success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_component_php') ? 'active':''}}">
                    <a href="{{route('bitrix_component_component_php', [$module->id, $component->id])}}">{{ trans('bitrix_components.menu_title_component_php') }}{!! in_array(4, $component->steps)?' <span class="badge success"><span class="glyphicon glyphicon-ok aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_other_files') ? 'active':''}}">
                    <a href="{{route('bitrix_component_other_files', [$module->id, $component->id])}}">{{ trans('bitrix_components.menu_title_other_files') }}{!! in_array(5, $component->steps)?' <span class="badge success"><span class="glyphicon glyphicon-ok aria-hidden="true"></span></span>':''!!}</a>
                </li>
                <li class="{{Route::is('bitrix_component_templates') ? 'active':''}}">
                    <a href="{{route('bitrix_component_templates', [$module->id, $component->id])}}">{{ trans('bitrix_components.menu_title_templates') }}{!! in_array(6, $component->steps)?' <span class="badge success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>':''!!}</a>
                </li>
            </ol>
        </div>
    </div>
</nav>