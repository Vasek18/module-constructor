@if (!$property->multiple)
    <input type="text"
           id="{{$property->id}}"
           name="props[{{$property->id}}]"
           class="form-control"
           value="{{ isset($props_vals[$property->id]) ? $props_vals[$property->id] : ((isset($property->dop_params["DEFAULT_VALUE"])&& !isset($element)) ? $property->dop_params["DEFAULT_VALUE"] : '' )}}"
            {{ $property->is_required ? 'required' : '' }}
    >
@else
    {{--todo--}}
@endif