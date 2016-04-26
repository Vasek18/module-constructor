<div class="row option">
    <div class="col-md-1">
        <label class="sr-only" for="param_{{$i}}_sort">Сортировка</label>
        <input type="text" class="form-control" name="param_sort[]" id="param_{{$i}}_sort"
               placeholder="Сортировка" value="{{$param ? $param->sort : '500'}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="param_{{$i}}_id">Код</label>
        <input type="text" class="form-control" name="param_code[]" id="param_{{$i}}_id"
               placeholder="Код" value="{{$param ? $param->code : ''}}">
    </div>
    <div class="col-md-3">
        <label class="sr-only" for="param_{{$i}}_name">Название</label>
        <input type="text" class="form-control" name="param_name[]"
               id="param_{{$i}}_name"
               placeholder="Название" value="{{$param ? $param->name : ''}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="param_{{$i}}_type">Тип</label>
        <select class="form-control" name="param_type[]" id="param_{{$i}}_type">
            <option value="">Выберите</option>
            @foreach($params_types as $type)
                <option @if ($param && $param->type_id == $type->id) selected
                        @endif value="{{$type->id}}">{{$type->name_ru}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        @if ($param)
            <a href="{{ action('Modules\Bitrix\BitrixComponentsController@delete_param', [$module->id, $component->id, $param->id]) }}"
               class="btn btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                Удалить
            </a>
        @endif
    </div>
</div>