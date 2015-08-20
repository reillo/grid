<?php namespace Reillo\Grid\Example;

use Listing;
use Request;
use Reillo\Grid\ListGrid;
use Reillo\Grid\Traits\RemovableFiltersTrait;

class CustomerListGrid extends ListGrid {

    use RemovableFiltersTrait;

    function __construct()
    {
        parent::__construct();

        // use custom renderer view
        // $this->getRenderer()->setView('example.list_grid.custom_list');
    }

    protected function prepareQuery()
    {
        $query = Listing::active()->leftJoin('customers', 'customers.id', '=', 'listings.customer_id');
        $query->with('customer');
        $query->select([
            'customers.*',
            'listings.*',
        ]);

        $this->setQuery($query);
    }

    protected function prepareFilters()
    {
        if (Request::input('email')) {
            $this->getQuery()->where('customers.email','LIKE' ,'%'.Request::input('email').'%');

            $this->addRemovableFilter('email', ('Email: '.Request::input('email')), [
                'email' => null
            ]);
        }
        if (Request::input('status')) {

            $this->getQuery()->whereIn('listings.listing_status', Request::input('status', []));

            $this->addRemovableFilter('status[]', ('Status: '.join(', ', Request::input('status', []))), [
                'status' => null
            ]);
        }
    }

    protected function setQuerySortable()
    {
        // sort by default
        // $this->getQuery()->orderBy('listings.created_at', 'desc');
    }
}
