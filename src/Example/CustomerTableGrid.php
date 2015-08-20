<?php namespace Reillo\Grid\Example;

use Customer;
use Request;
use Reillo\Grid\Table\Column\Common;
use Reillo\Grid\TableGrid;
use Reillo\Grid\Traits\RemovableFiltersTrait;

class CustomerTableGrid extends TableGrid {

    use RemovableFiltersTrait;

    protected function prepareQuery()
    {
        $query = (new Customer)->newQuery();
        $this->setQuery($query);
    }

    protected function prepareFilters()
    {
        if (Request::input('email')) {
            $this->getQuery()->where('email','LIKE' ,'%'.Request::input('email').'%');

            $this->addRemovableFilter('email', ('Email: '.Request::input('email')), [
                'email' => null
            ]);
        }
    }

    protected function prepareColumns()
    {
        $this->addColumn(Common::checkBoxColumn());

        $this->addColumn('email', [
            'label'    => 'Email',
            'column'   => 'email',
            'sortable' => 'label',
            'renderer' => [$this, 'setColumnEmail']
        ]);

        $this->addColumn('salutations', [
            'label'    => 'Salutations',
            'sortable' => true,
            'column'   => 'salutations',
        ]);

        $this->addColumn('confirmation_code', [
            'label'    => 'Confirmation Code',
            'sortable' => true,
            'column'   => 'confirmation_code',
        ]);
    }

    public function setColumnEmail($row)
    {
        return $row->email;
    }
}

/*-

// controller
$grid = (new ProductGrid())->prepareGrid();

if ($grid->isAjax()) {
    return $grid->ajaxResponse();
}

return View::make($this->view, compact('grid'));
*/
