<?php

return array(
    'per_page'            => 10,
    'per_page_selection'  => array(5, 10, 30, 100),

    'view' => array(
        'renderer' => array(
            'list' => 'grid::renderer.list',
            'table' => 'grid::renderer.table',
            'table_header' => 'grid::renderer.table_header',
        ),

        'no_result' => 'grid::no_result',
        'pagination' => 'grid::pagination',
        'pagination_info' => 'grid::pagination_info',
        'per_page' => 'grid::per_page',
        'removable_filter' => 'grid::removable_filter',
    )
);
