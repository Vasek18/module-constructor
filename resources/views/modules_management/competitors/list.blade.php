@foreach($competitors->chunk(3) as $competitors)
    <div class="row">
        @foreach($competitors as $competitor)
            <div class="col-md-4">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>{{ $competitor->name }}</h3>
                        <p>{{ $competitor->comment }}</p>
                        <p>
                            <a href="{{ action('Modules\Management\ModulesCompetitorsController@edit', [$module->id, $competitor->id]) }}"
                               class="btn btn-primary"
                            >Редактировать</a>
                            @if ($competitor->link)
                                <a href="{{ $competitor->link }}"
                                   class="btn btn-info"
                                   target="_blank"
                                >Ссылка</a>
                            @endif
                            <a href="{{ action('Modules\Management\ModulesCompetitorsController@delete', [$module->id, $competitor->id]) }}"
                               class="btn btn-danger"
                            >Удалить</a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach