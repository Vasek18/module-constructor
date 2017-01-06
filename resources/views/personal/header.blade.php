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
    </ul>
</div>
<h1>{{ Auth::user()->last_name }} {{  Auth::user()->first_name }}
    @if (setting('day_price'))
        <small>({{ trans('personal_index.paid_days') }}: {{  Auth::user()->paid_days }})</small>
    @endif
</h1>
<hr>