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
        <input type="email"
               id="email"
               name="email[{{ $i }}]"
               class="form-control"
               placeholder="Email пользователя"
               value="{{ $access_email }}"
                {{ $access_email ? 'disabled' : '' }}>
    </div>
    <div class="col-md-4 col-md-offset-1">
        @foreach($permissions as $permission)
            <div class="clearfix">
                <div class="checkbox">
                    <div class="pull-left">
                        <label>
                            <input type="checkbox"
                                   name="permission[{{ $i }}][{{ $permission['code'] }}]"
                                   value="{{ $permission['code'] }}"
                                   @if (isset($access_permissions[$permission['code']]))
                                   checked
                                   disabled
                                    @endif
                            >
                            {{ $permission['name'] }}
                        </label>&nbsp;
                    </div>
                    <div class="pull-left">
                        @if (isset($access_permissions[$permission['code']]))
                            <a class=""
                               href="{{ action('Modules\Management\ModulesAccessesController@delete', [$module->id, $access_permissions[$permission['code']]]) }}">
                             <span class="glyphicon glyphicon-trash"
                                   aria-hidden="true"></span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<hr>