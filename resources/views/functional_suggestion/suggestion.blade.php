<div class="panel panel-primary">
    <div class="panel-heading clearfix">{{ $suggestion->name }}
        @if ($user && $user->isAdmin())
            <div class="pull-right">
                <a href="{{ action('FunctionalSuggestionController@destroy', [$suggestion]) }}"
                   id="delete{{ $suggestion->id }}"
                   class="btn btn-danger">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                </a>
            </div>
        @endif
    </div>
    <div class="panel-body">
        <p>{{ $suggestion->description }}</p>
    </div>
    <div class="panel-footer clearfix">
        @if ($user)
            <a href="{{ action('FunctionalSuggestionController@upvote', [$suggestion]) }}"
               id="upvote{{ $suggestion->id }}"
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