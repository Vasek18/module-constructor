<div class="clients-issues">
    @foreach($issues as $issue)
        @include('modules_management.clients_issues.item', ['issue' => $issue])
    @endforeach
</div>