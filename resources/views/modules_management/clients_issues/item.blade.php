<div class="clients-issues__item clients-issue panel panel-default">
    <div class="clients-issue__heading panel-heading">
        <div class="row">
            <div class="clients-issue__name col-md-10"><b>{{ $issue->name }}</b></div>
            <form class="clients-issue__counter col-md-2"
                  action="{{ action(
                      'Modules\Management\ModulesClientsIssueController@changeCounter',
                       [
                       'module'=>$module->id,
                       'issue'=>$issue->id,
                       ]
                       ) }}"
                  method="post">
                {{ csrf_field() }}
                <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default"
                                    type="submit"
                                    name="action"
                                    value="decrease">-</button>
                        </span>
                    <input type="text"
                           class="form-control text-center"
                           disabled
                           title="Сколько раз обращались с этой проблемой"
                           placeholder="{{ $issue->appeals_count }}">
                    <span class="input-group-btn">
                            <button class="btn btn-default"
                                    type="submit"
                                    name="action"
                                    value="increase">+</button>
                        </span>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="clients-issue__body panel-body">
        {{ $issue->description }}
    </div>
    <hr>
    <div class="clients-issue__footer panel-footer">
        <div class="clearfix">
            @if ($issue->is_solved)
                <form class="pull-left"
                      action="{{ action(
                      'Modules\Management\ModulesClientsIssueController@notSolved',
                       [
                       'module'=>$module->id,
                       'issue'=>$issue->id,
                       ]
                       ) }}"
                      method="post">
                    {{ csrf_field() }}
                    <button class="btn btn-warning"
                            type="submit">Не решена
                    </button>
                </form>
                <form class="pull-right"
                      action="{{ action(
                      'Modules\Management\ModulesClientsIssueController@destroy',
                       [
                       'module'=>$module->id,
                       'issue'=>$issue->id,
                       ]
                       ) }}"
                      method="post">
                    {{ csrf_field() }}
                    <button class="btn btn-danger"
                            type="submit">Удалить
                    </button>
                </form>
            @else
                <form class=""
                      action="{{ action(
                      'Modules\Management\ModulesClientsIssueController@solved',
                       [
                       'module'=>$module->id,
                       'issue'=>$issue->id,
                       ]
                       ) }}"
                      method="post">
                    {{ csrf_field() }}
                    <button class="btn btn-success"
                            type="submit">Решена
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>