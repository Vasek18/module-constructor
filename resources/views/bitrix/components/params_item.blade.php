<div class="row option">
    <input type="hidden" name="module_id[]" value="{{$module->id}}">
    <div class="col-md-1">
        <label class="sr-only" for="option_{{$i}}_sort">Сортировка</label>
        <input type="text" class="form-control" name="option_sort[]" id="option_{{$i}}_sort"
               placeholder="Сортировка" value="{{$param ? $param->sort : ''}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="option_{{$i}}_id">Код</label>
        <input type="text" class="form-control" name="option_code[]" id="option_{{$i}}_id"
               placeholder="Код" value="{{$param ? $param->code : ''}}">
    </div>
    <div class="col-md-3">
        <label class="sr-only" for="option_{{$i}}_name">Название</label>
        <input type="text" class="form-control" name="option_name[]"
               id="option_{{$i}}_name"
               placeholder="Название" value="{{$param ? $param->name : ''}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="option_{{$i}}_type">Тип</label>
    </div>
    <div class="col-md-2">
        @if ($param)
            <a href="{{ action('Modules\Bitrix\BitrixOptionsController@destroy', [$module->id, $param->id]) }}"
               class="btn btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                Удалить
            </a>
        @endif
    </div>
</div>