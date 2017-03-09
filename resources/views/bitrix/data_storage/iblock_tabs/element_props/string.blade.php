@if (!$property->multiple)
    <input type="text"
           id="{{$property->id}}"
           name="props[{{$property->id}}]"
           class="form-control"
           value="{{ isset($props_vals[$property->id]) ? $props_vals[$property->id] : ((isset($property->dop_params["DEFAULT_VALUE"])&& !isset($element)) ? $property->dop_params["DEFAULT_VALUE"] : '' )}}"
            {{ $property->is_required ? 'required' : '' }}
    >
@else
    @if (isset($props_vals[$property->id]))
        @foreach($props_vals[$property->id] as $val)
            <input type="text"
                   id="{{$property->id}}"
                   name="props[{{$property->id}}][]"
                   class="form-control"
                   value="{{ $val }}"
            >
            <br>
        @endforeach
        @for($i=0; $i < 5 - count($props_vals[$property->id]); $i++)
            <input type="text"
                   id="{{$property->id}}"
                   name="props[{{$property->id}}][]"
                   class="form-control"
            >
            <br>
        @endfor
    @else
        @for($i=0; $i < 5; $i++)
            <input type="text"
                   id="{{$property->id}}"
                   name="props[{{$property->id}}][]"
                   class="form-control"
            >
            <br>
        @endfor
    @endif
@endif