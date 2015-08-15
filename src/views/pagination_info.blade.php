<?php $paginator = $grid->getPaginator() ?>
<div class="js-grid-pagination-info">
    <p>
Showing {{ $paginator->getCurrentPage() }}
    to {{ $paginator->getLastPage() }} of {{ $paginator->getTotal() }} entries
    </p>
</div>
