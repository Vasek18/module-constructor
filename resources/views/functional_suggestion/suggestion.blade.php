<div class="panel panel-primary">
    <div class="panel-heading">{{ $suggestion->name }}</div>
    <div class="panel-body">
        <p>{{ $suggestion->description }}</p>
    </div>
    <div class="panel-footer clearfix">
        @if ($user)
            <a href="{{ action('FunctionalSuggestionController@upvote', [$suggestion]) }}"
               class="upvote btn btn-success {{ $suggestion->ifHeVoted($user) ? 'disabled' : '' }}">
                {{ trans('functional_suggestion.vote_btn') }}
            </a>
        @endif
        <div class="pull-right">
            <p class="button-line-height">
                {{ trans('functional_suggestion.votes_count') }}: {{ $suggestion->votes }}
            </p>
        </div>
    </div>
</div>