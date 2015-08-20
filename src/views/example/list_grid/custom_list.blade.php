<div class="js-grid-renderer ">
    @if ($renderer->hasItems())
        @foreach ($renderer->getItems() as $item)
            <div style="margin-bottom: 24px;">

                <h3><a href="{{ $item->getUrl() }}">
                        {{ $item->present()->getTitle() }}
                    </a></h3>

                ID: {{ $item->id }}
            </div>
        @endforeach
    @else
        <p>No results found.</p>
    @endif
</div>
