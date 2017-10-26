<hr>
<div class="accesses row">
    <div class="col-md-6">
        <input type="text"
               id="email"
               name="email[]"
               class="form-control"
               placeholder="Email пользователя"
               value="{{ $access_email }}">
    </div>
    <div class="col-md-6">
        @foreach($permissions as $permission)
            <label>
                <input type="checkbox"
                       name="permission[]"
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
</div>
<hr>