<hr>
<div class="accesses row">
    <div class="col-md-5">
        @if ($access_email)
            <input type="hidden"
                   id="email"
                   name="email[{{ $i }}]"
                   value="{{ $access_email }}"
            >
        @endif
        <input type="text"
               id="email"
               name="email[{{ $i }}]"
               class="form-control"
               placeholder="Email пользователя"
               value="{{ $access_email }}"
                {{ $access_email ? 'disabled' : '' }}>
    </div>
    <div class="col-md-4 col-md-offset-1">
        @foreach($permissions as $permission)
            <label>
                <input type="checkbox"
                       name="permission[{{ $i }}][]"
                       value="{{ $permission['code'] }}"
                       @if (in_array($permission['code'], $access_permissions))
                       checked
                        @endif
                >
                {{ $permission['name'] }}
            </label>
            <br>
        @endforeach
    </div>
    <div class="col-md-2">
        @if ($access_email)
            <a class="btn btn-danger"
               href="#">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                {{ trans('app.delete') }}
            </a>
        @endif
    </div>
</div>
<hr>