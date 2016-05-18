<div class="row option {{$option ? 'draggable' : ''}}">
    <input type="hidden" name="module_id[]" value="{{$module->id}}">
    <input type="hidden" class="sort-val" name="option_sort[]" value="{{$i}}">
    <div class="col-md-4">
        <label class="sr-only" for="option_{{$i}}_name">Название</label>
        <input type="text" class="form-control" name="option_name[]"
               id="option_{{$i}}_name"
               placeholder="Название" value="{{$option ? $option->name : ''}}">
    </div>
    <div class="col-md-3">
        <label class="sr-only" for="option_{{$i}}_id">Код</label>
        <input type="text" class="form-control" name="option_code[]" id="option_{{$i}}_id"
               placeholder="Код" value="{{$option ? $option->code : ''}}"
               @unless ($option) data-translit_from="option_{{$i}}_name" @endif>
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="option_{{$i}}_type">Тип</label>
        <select class="form-control" name="option_type[]" id="option_{{$i}}_type">
            @foreach($options_types as $type)
                <option
                        @if ($option && $option->type == $type->FORM_TYPE) selected @endif
                @if ((!$option || !$option->type) && $type->FORM_TYPE == 'text') selected @endif
                        value="{{$type->FORM_TYPE}}">{{$type->NAME_RU}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <a href="#" class="btn btn-default btn-block" data-toggle="modal"
           data-target="#admin_options_dop_settings_window_{{$i}}">Редактировать
        </a>
        @include('bitrix.admin_options.dop_settings_window', ['option' => $option, 'i' => $i])
    </div>
    <div class="col-md-1">
        @if ($option)
            <a href="{{ action('Modules\Bitrix\BitrixOptionsController@destroy', [$module->id, $option->id]) }}"
               class="btn btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
        @endif
    </div>
</div>