@extends("admin.template")

@section("page")

    <ul class="events">
        @foreach($events as $eventName => $eventGroup)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title clearfix">
                        <div class="pull-left">
                        <a class=""
                           role="button"
                           data-toggle="collapse"
                           href="#{{ $eventGroup['code'] }}"
                           aria-expanded="false"
                        >
                            {{ $eventName }}

                        </a>
                        </div>
                        <div class="pull-right">
                            @foreach($eventGroup['counters'] as $counter)
                                {{ $counter['name'] }}: {{ $counter['value'] }};
                                @endforeach
                        </div>
                    </h4>
                </div>
                <div class="panel-collapse collapse"
                     id="{{ $eventGroup['code'] }}">
                    <ul class="list-group">
                        @foreach($eventGroup['events'] as $event)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">{{ $event->userName }}</div>
                                    <div class="col-md-2">{{ $event->created_at->format('d.m.Y H:i:s') }}</div>
                                    <div class="col-md-8">
                                        <pre>{{ print_r($event->params) }}</pre>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </ul>
@stop