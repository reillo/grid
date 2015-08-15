<tr>
    @foreach ($renderer->getColumns() as $column)
        @if ($column->isSortable())
        <th class="js-grid-filter grid-sortable {{{ $column->getClass() }}} {{{ $grid->getSortableDir($column) }}}" data-target-url="{{ $grid->createSortableUrl($column) }}" {{ $column->getRawAttributes() }}>
        @else
        <th class="{{{ $column->getClass() }}}" {{ $column->getRawAttributes() }} >
        @endif
            {{-- label might be a markup --}}
            {{ $column->getLabel() }}
        </th>
    @endforeach
</tr>
