@include('grid::example.header')

<div class="container" >

    <div class="row ">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="grid-container" id="cusotmer-grid" data-grid-url="{{ $grid->getBaseUrl() }}">
                <div class="toolbar">
                    <div class="form-group form-inline">
                        <label for="">Email</label>
                        <input class="form-control js-grid-input" type="text" name="email" value="{{ Input::get('email') }}"/>
                        <button class="btn js-grid-submit" type="button" >Submit</button>
                    </div>
                    <div class="form-group form-inline js-grid-filter-checkbox">
                        <label class="radio">
                            <input class="js-grid-input" type="checkbox" name="status[]" value="{{{ Listing::STATUS_ACTIVE }}}"/>
                            Active
                        </label>
                        <label class="radio">
                            <input class="js-grid-input" type="checkbox" name="status[]" value="{{{ Listing::STATUS_INACTIVE }}}"/>
                            Inactive
                        </label>
                        <label class="radio">
                            <input class="js-grid-input" type="checkbox" name="status[]" value="{{{ Listing::STATUS_SOLD }}}"/>
                            Sold
                        </label>
                    </div>
                </div>

                {{ $grid->render('grid::removable_filter') }}

                <div class="grid-list-wrapper">
                    <div class="waiting"><i class="fa fa-spin fa-spinner"></i></div>
                    {{ $grid->renderGrid() }}
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        {{ $grid->render('grid::per_page') }}
                    </div>
                    <div class="col-sm-8">
                        <div class="pull-right clearfix">
                            {{ $grid->render('grid::pagination') }}
                        </div>
                    </div>
                </div>

                {{ $grid->render('grid::pagination_info') }}
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        new Grid($('#cusotmer-grid'));
    });
</script>

