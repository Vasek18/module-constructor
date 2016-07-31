<a href="#"
   data-toggle="modal"
   data-target="#on_this_page_i_lack_modal">{{ trans('feedback.on_this_page_i_lack') }}</a>
<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="on_this_page_i_lack_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('feedback.on_this_page_i_lack_title') }}</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="email">{{ trans('feedback.on_this_page_i_lack_email') }}</label>
                        <input class="form-control"
                               name="email"
                               id="email">
                    </div>
                    <div class="form-group">
                        <label for="text">{{ trans('feedback.on_this_page_i_lack_text') }}</label>
                        <textarea class="form-control"
                                  name="text"
                                  id="text"
                        rows="10"></textarea>
                    </div>
                    <button type="submit"
                            class="btn btn-primary"
                            name="send">{{ trans('app.send') }}
                    </button>
                </form>
                <br>
                <p>{{ trans('feedback.on_this_page_i_lack_desc') }}</p>
            </div>
        </div>
    </div>
</div>
