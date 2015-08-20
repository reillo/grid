<table class="js-grid-renderer table">
    <thead>{{ $renderer->renderHeader() }}</thead>
    <tfoot>{{ $renderer->renderHeader() }}</tfoot>

    <tbody>
        @if ($renderer->hasItems())
            @foreach ($renderer->getItems() as $item)
            <tr data-id="{{ $item->id }}">
                @foreach ($renderer->getColumns() as $column)
                   <td class="{{{ $column->getClass() }}}" {{ $column->getRawAttributes() }}>
                        {{ $column->render($item) }}
                   </td>
                @endforeach
            </tr>
            @endforeach
        @else
            <tr class="grid-no-items">
                <td colspan="{{ $renderer->getTotalColumns() }}">{{ $renderer->renderNoResult() }}</td>
            </tr>
        @endif
    </tbody>
</table>
