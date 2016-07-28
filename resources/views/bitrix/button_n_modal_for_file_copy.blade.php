@if ($show)
    <a class="btn btn-primary"
       data-toggle="modal"
       data-target="#show_me_file_baby{{isset($add_id) ? $add_id : ''}}"
       href="#">
    <span class="glyphicon glyphicon glyphicon-eye-open"
          aria-hidden="true"></span>
        @if ($is_lang)
            {{ trans('bitrix.see_lang_file') }}
        @else
            {{ trans('bitrix.see_file') }}
        @endif
    </a>
@else
    <a class="btn btn-default"
       data-toggle="modal"
       data-target="#show_me_file_baby{{isset($add_id) ? $add_id : ''}}"
       href="#">
    <span class="glyphicon glyphicon glyphicon-eye-close"
          aria-hidden="true"></span>
        @if ($is_lang)
            {{ trans('bitrix.see_lang_file') }}
        @else
            {{ trans('bitrix.see_file') }}
        @endif
    </a>
@endif
<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="show_me_file_baby{{isset($add_id) ? $add_id : ''}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix.see_file_title') }}</h4>
            </div>
            <div class="modal-body">
                @if ($show)
                    <label for="">{{ $module->module_folder.$path }}</label>
                    <textarea rows="24"
                              class="form-control">{{ is_file($module->getFolder(true).$path) ? file_get_contents($module->getFolder(true).$path) : '' }}</textarea>
                @else
                    {{ trans('bitrix.no_money_no_file') }}
                @endif
            </div>
        </div>
    </div>
</div>