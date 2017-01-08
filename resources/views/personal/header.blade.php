<div class="personal-cabinet-tabs">
    <ul class="nav nav-tabs">
        <li class="<?php echo classActiveSegment(2, ''); ?>">
            <a href="{{ action('PersonalController@index') }}">{{ trans('personal_cabinet.menu_index') }}</a>
        </li>
        @if (setting('day_price'))
            <li class="<?php echo classActiveSegment(2, 'oplata'); ?>">
                <a href="{{ action('PersonalController@oplata') }}">{{ trans('personal_cabinet.menu_oplata') }}</a>
            </li>
        @endif
        @if (setting('donat'))
            <li class="<?php echo classActiveSegment(2, 'help_project'); ?>">
                <a href="{{ action('PersonalController@help_project') }}">{{ trans('personal_cabinet.menu_help_project') }}</a>
            </li>
        @endif
    </ul>
</div>