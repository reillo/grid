<?php namespace Reillo\Grid\Example;

use Input;
use Listing;
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
        $this->setQuery($query);

        $this->setQuerySelect([
            'customers.*',
            'listings.*',
        ]);
    }

    protected function prepareFilters()
    {
        if (Input::get('email')) {
            $this->getQuery()->where('customers.email','LIKE' ,'%'.Input::get('email').'%');

            $this->addRemovableFilter('email', ('Email: '.Input::get('email')), [
                'email' => null
            ]);
        }
        if (Input::get('status')) {

            $this->getQuery()->whereIn('listings.listing_status', Input::get('status', []));

            $this->addRemovableFilter('status[]', ('Status: '.join(', ', Input::get('status', []))), [
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
