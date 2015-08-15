<?php

return array(
    'page'                => 1,
    'per_page'            => 10,
    'per_page_selection'  => array(5,10,30,100),
    'renderer' => array(
        'table' => array(
            'table_view'        => 'grid::renderer.table.table',
            'table_header_view' => 'grid::renderer.table.table_header',
        ),
        'list_view' => 'grid::renderer.list'
    )
);
