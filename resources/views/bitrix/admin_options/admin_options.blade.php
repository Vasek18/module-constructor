@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_admin_options.h1') }}
@stop

@section('page')
    @push('scripts')
    <script src="/js/bitrix_module_admin_options.js"></script>
    @endpush
    
    @include('bitrix.button_n_modal_for_file_copy', ['path' => DIRECTORY_SEPARATOR.'options.php', 'show' => $user->canSeePaidFiles(), 'is_lang' => false])
    @include('bitrix.button_n_modal_for_file_copy', ['path' => DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ru'.DIRECTORY_SEPARATOR.'options.php', 'show' => $user->canSeePaidFiles(), 'is_lang' => true, 'add_id' => '_lang'])

    <br><br>
    <form role="form"
          method="POST"
          action="{{ action('Modules\Bitrix\BitrixOptionsController@store', $module->id) }}">
        <input type="hidden"
               name="_token"
               value="{{ csrf_token() }}">
        <div class="row option-headers">
            <div class="col-md-4">
                <label>{{ trans('bitrix_admin_options.option_name') }}</label>
            </div>
            <div class="col-md-3">
                <label>{{ trans('bitrix_admin_options.option_code') }}</label>
            </div>
            <div class="col-md-2">
                <label>{{ trans('bitrix_admin_options.option_type') }}</label>
            </div>
            <div class="col-md-2">
                <label>{{ trans('bitrix_admin_options.option_additional_settings') }}</label>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="options">
            <div class="draggable-container">
                @foreach($options as $i => $option)
                    {{--{{dd($option)}}--}}
                    @include('bitrix.admin_options.item', ['option' => $option, 'i' => $i, 'module' => $module])
                @endforeach
            </div>
            {{-- Дополнительно показываем ещё несколько пустых строк --}}
            @for ($j = count($options); $j < count($options)+5; $j++)
                @include('bitrix.admin_options.item', ['option' => null, 'i' => $j, 'module' => $module])
            @endfor
            <div class="hidden template-for-js">
                @include('bitrix.admin_options.item', ['option' => null, 'i' => '__change_me_i_am_number__', 'module' => $module])
            </div>
        </div>
        <div class="row overlast-row">
            <div class="col-md-12">
                <p>
                    <a href="#"
                       class="btn btn-default btn-block add-dop-row">{{ trans('bitrix_admin_options.add_row') }}</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block"
                        name="save"
                        type="submit">{{ trans('bitrix_admin_options.save') }}</button>
            </div>
        </div>
    </form>
    <hr>
    <p class="description">{!! trans('bitrix_admin_options.step_description') !!}</p>
    <hr>
    <p>{!! trans('bitrix_admin_options.hints') !!}</p>
@stop