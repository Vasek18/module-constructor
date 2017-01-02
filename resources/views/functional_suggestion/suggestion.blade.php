<div class="panel panel-primary">
    <div class="panel-heading">{{ $suggestion->name }}</div>
    <div class="panel-body">
        <p>{{ $suggestion->description }}</p>
    </div>
    <div class="panel-footer">
        @if ($user)
            <a href="{{ action('FunctionalSuggestionController@upvote', [$suggestion]) }}"
               class="upvote btn btn-success {{ $suggestion->ifHeVoted($user) ? 'disabled' : '' }}">
                Да, это нужно
            </a>
        @endif
        <div class="pull-right">
            <p class="button-line-height">
                Голосов: {{ $suggestion->votes }}
            </p>
        </div>
    </div>
</div>