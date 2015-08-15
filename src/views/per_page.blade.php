<div class="form-group js-grid-per-page">
    <label for="grid-per-page">Per Page:</label>
    <select class="form-control js-grid-input js-grid-filter-input" name="per_page" id="grid-per-page">
        @foreach ($grid->getPerPageSelection() as $value)
        <option value="{{ $value }}" {{ $value == $grid->getPerPage() ? "selected=\"selected\"" : NULL }}>{{ Str::title($value) }}</option>
        @endforeach
    </select>
</div>
