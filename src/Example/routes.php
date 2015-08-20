<?php

Route::get('/grid/table', function() {
    $grid = new Reillo\Grid\Example\CustomerTableGrid();
    $grid->removeColumn('confirmation_code');
    $grid->addColumnAfter('first_name', [
        'label' => 'First name',
        'sortable' => false,
        'column' => 'first_name',
        'renderer' => function($row) {
            return $row->first_name;
        },
    ], 'email');

    $grid->prepareGrid();

    if ($grid->isAjax()) {
        return $grid->ajaxResponse();
    }

    return View::make('grid::example.table_grid', compact('grid'));
});

Route::get('/grid/list', function() {
    $grid = new Reillo\Grid\Example\CustomerListGrid();
    // $grid->fragment('tab1');
    $grid->prepareGrid();

    if ($grid->isAjax()) {
        return $grid->ajaxResponse();
    }

    return View::make('grid::example.list_grid', compact('grid'));
});
