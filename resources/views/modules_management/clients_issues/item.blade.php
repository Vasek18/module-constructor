<div class="clients-issues__item clients-issue panel panel-default"
     id="issue{{ $issue->id }}">
    <div class="clients-issue__heading panel-heading">
        <div class="row">
            <div class="clients-issue__name col-lg-9 col-md-9">
                <a href="#issue{{ $issue->id }}">#</a>
                <b>{{ $issue->name }}</b>
            </div>
            <form class="clients-issue__counter col-lg-3 col-md-3"
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
                                    value="decrease"
                                    id="decrease_{{ $issue->id }}">-</button>
                        </span>
                    <input type="text"
                           class="form-control text-center"
                           disabled
                           title="Сколько раз обращались с этой проблемой"
                           value="{{ $issue->appeals_count }}"
                           id="appeals_count_{{ $issue->id }}"
                    >
                    <span class="input-group-btn">
                            <button class="btn btn-default"
                                    type="submit"
                                    name="action"
                                    value="increase"
                                    id="increase_{{ $issue->id }}">+</button>
                        </span>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="clients-issue__body panel-body">
        <form class=""
              action="{{ action(
                      'Modules\Management\ModulesClientsIssueController@update',
                       [
                       'module'=>$module->id,
                       'issue'=>$issue->id,
                       ]
                       ) }}"
              method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <p class="form-control-static">
                    <a href="#"
                       class="you-can-change ajax"
                       data-name="description"
                       data-formtype="textarea"
                       data-pattern=".+">{{ $issue->description ?: '.' }}</a>
                </p>
            </div>
            <button type="submit"
                    class="btn btn-primary hidden"
                    name="change_description_{{ $issue->id }}"
            >Изменить описание
            </button>
        </form>
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
                            type="submit"
                            id="not_solved_{{ $issue->id }}">Не решена
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
                            type="submit"
                            id="delete_{{ $issue->id }}">Удалить
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
                            type="submit"
                            id="solved_{{ $issue->id }}">Решена
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>