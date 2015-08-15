<div class="form-group js-grid-removable-filter">
    @foreach ($grid->getRemovableFilters() as $key => $value)
        <a class="label label-warning js-grid-filter" href="javascript:void(0)" data-target-url="{{ $grid->createUrl(array_get($value, 'param')) }}">
            <span class="fa fa-times"></span>
            {{{ array_get($value, 'label') }}}
        </a> &nbsp;
    @endforeach
</div>
