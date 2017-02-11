<a href="#"
   data-toggle="modal"
   data-target="#i_found_a_bug_modal">{{ trans('feedback.i_found_a_bug') }}</a>
<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="i_found_a_bug_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('feedback.i_found_a_bug_title') }}</h4>
            </div>
            <div class="modal-body">
                <form method="post"
                      action="{{ action('FeedbackController@sendBugReportForm') }}">
                    {{ csrf_field() }}
                    <input type="hidden"
                           name="page"
                           value="{{ Request::url() }}">
                    <div class="form-group">
                        <label for="text">{{ trans('feedback.i_found_a_bug_text') }}</label>
                        <textarea class="form-control"
                                  name="text"
                                  id="text"
                                  rows="10"
                                  required></textarea>
                    </div>
                    <button type="submit"
                            class="btn btn-primary"
                            name="send_bug_report">{{ trans('app.send') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
