<a class="btn btn-primary"
   data-toggle="modal"
   data-target="#add_class_php_template"
   href="#">
    {{ trans('bitrix_components.add_logic_template_btn') }}
</a>
<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="add_class_php_template">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix_components.add_logic_template_title') }}</h4>
            </div>
            <div class="modal-body">
                <form action=""
                      method="post">
                    <div class="form-group">
                        <label for="name">{{ trans('bitrix_components.add_logic_template_name_field') }}</label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="template">{{ trans('bitrix_components.add_logic_template_template_field') }}</label>
                        <textarea id="template"
                                  name="template"
                                  class="form-control"
                                  rows="20"
                                  required></textarea>
                    </div>
                    <div class="form-group">
                        <button id="add_template"
                                name="add_template"
                                class="btn btn-success btn-block">{{ trans('app.add') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>