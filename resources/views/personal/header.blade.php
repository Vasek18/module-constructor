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
            <li class="<?php echo classActiveSegment(2, 'donate'); ?>">
                <a href="{{ action('PersonalController@donate') }}">{{ trans('personal_cabinet.menu_donate') }}</a>
            </li>
        @endif
        <li class="<?php echo classActiveSegment(2, 'info'); ?>">
            <a href="{{ action('PersonalController@info') }}">{{ trans('personal_cabinet.menu_personal_info') }}</a>
        </li>
    </ul>
</div>