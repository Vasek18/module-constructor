<ul class="clients-issues list-group">
    @foreach($issues as $issue)
        <li class="clients-issues__item list-group-item">
            <span class="badge"
                  title="Сколько раз обращались с этой проблемой">{{ $issue->appeals_count }}</span>
            {{ $issue->name }}
        </li>
    @endforeach
</ul>