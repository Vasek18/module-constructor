<div class="row option">
    <div class="col-md-1">
        <label class="sr-only" for="param_{{$i}}_sort">Сортировка</label>
        <input type="text" class="form-control" name="param_sort[]" id="param_{{$i}}_sort"
               placeholder="Сортировка" value="{{$param ? $param->sort : ''}}">
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
    </div>
    <div class="col-md-2">
    </div>
</div>