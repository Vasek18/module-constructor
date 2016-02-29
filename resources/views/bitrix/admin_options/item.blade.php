<div class="row option">
    <input type="hidden" name="module_id[]" value="{{$module->id}}">
    <div class="col-md-2">
        <label class="sr-only" for="option_{{$i}}_id">ID</label>
        <input type="text" class="form-control" name="option_code[]" id="option_{{$i}}_id"
               placeholder="ID" value="{{$option ? $option->code : ''}}">
    </div>
    <div class="col-md-3">
        <label class="sr-only" for="option_{{$i}}_name">Название</label>
        <input type="text" class="form-control" name="option_name[]"
               id="option_{{$i}}_name"
               placeholder="Название" value="{{$option ? $option->name : ''}}">
    </div>
    <div class="col-md-3">
        <label class="sr-only" for="option_{{$i}}_type">Тип</label>
        <select class="form-control" name="option_type[]" id="option_{{$i}}_type">
            @foreach($options_types as $type)
                <option @if ($option && $option->type_id == $type->id) selected
                        @endif value="{{$type->id}}">{{$type->NAME_RU}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <a href="#" class="btn btn-default" data-toggle="modal"
           data-target="#admin_options_dop_settings_window_{{$i}}">Редактировать</a>
        @include('bitrix.admin_options.dop_settings_window', ['option' => $option, 'i' => $i])
    </div>
    <div class="col-md-2">
        @if ($option)
            <a href="{{ action('Modules\Bitrix\BitrixOptionsController@destroy', [$module->id, $option->id]) }}"
               class="btn btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                Удалить
            </a>
        @endif
    </div>
</div>