<div class="personal-cabinet-tabs">
    <ul class="nav nav-tabs">
        <li class="<?php echo classActiveSegment(2, ''); ?>">
            <a href="{{ action('PersonalController@index') }}">{{ trans('personal_cabinet.menu_index') }}</a>
        </li>
        <li class="<?php echo classActiveSegment(2, 'oplata'); ?>">
            <a href="{{ action('PersonalController@oplata') }}">{{ trans('personal_cabinet.menu_oplata') }}</a>
        </li>
    </ul>
</div>
<h1>{{ Auth::user()->last_name }} {{  Auth::user()->first_name }}
    <small>({{ trans('personal_index.paid_days') }}: {{  Auth::user()->paid_days }})</small>
</h1>
<hr>