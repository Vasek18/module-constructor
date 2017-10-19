<ul class="clients-issues list-group">
    @foreach($issues as $issue)
        <li class="clients-issues__item clients-issue list-group-item">
            <div class="clients-issue__heading row">
                <div class="clients-issue__name col-md-10">{{ $issue->name }}</div>
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
        </li>
    @endforeach
</ul>