@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_event_handlers.h1') }}
@stop

@section('page')
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>
    @endpush
    <datalist id="core_modules_list">
        @foreach($core_modules as $core_module)
            <option>{{$core_module->code}}</option>
        @endforeach
    </datalist>
    <datalist id="core_events_list">
        @foreach($core_events as $core_event)
            <option>{{$core_event->code}}</option>
        @endforeach
    </datalist>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{ trans('validation.error') }}</strong> {{ trans('validation.there_occur_errors') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form role="form" method="POST"
          action="{{ action('Modules\Bitrix\BitrixEventHandlersController@store', $module->id) }}">
        {{ csrf_field() }}
        <div class="row option-headers">
            <div class="col-md-2">
                <label>{{ trans('bitrix_event_handlers.module') }}</label>
            </div>
            <div class="col-md-3">
                <label>{{ trans('bitrix_event_handlers.event') }}</label>
            </div>
            <div class="col-md-2">
                <label>{{ trans('bitrix_event_handlers.class') }}</label>
            </div>
            <div class="col-md-2">
                <label>{{ trans('bitrix_event_handlers.method') }}</label>
            </div>
            <div class="col-md-2">
                <label>{{ trans('bitrix_event_handlers.code') }}</label>
            </div>
        </div>
        @foreach($handlers as $i => $handler)
            @include('bitrix.events_handlers.item', ['handler' => $handler, 'i' => $i, 'module' => $module])
        @endforeach
        {{-- Дополнительно показываем ещё несколько пустых строк --}}
        @for ($j = count($handlers); $j < count($handlers)+5; $j++)
            @include('bitrix.events_handlers.item', ['handler' => null, 'i' => $j, 'module' => $module])
        @endfor
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block" name="save">{{ trans('app.save') }}</button>
            </div>
        </div>
    </form>
@stop