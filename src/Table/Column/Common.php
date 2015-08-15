<?php namespace Reillo\Grid\Table\Column;

use Reillo\Grid\Table\Column;

class Common {

    /**
     * Create column instance for checkbox
     *
     * @param string $primary_key
     * @return Column
     */
    public static function checkBoxColumn($primary_key = 'id')
    {
        return new Column('checkbox', [
            'label' => new LabelRaw('<input name="select_all" type="checkbox" value=""/>'),
            'raw_attributes' => 'style="width:20px;"',
            'renderer' => function($row) use ($primary_key) {
                return '<input name="row_id" type="checkbox" value="'.$row->{$primary_key}.'"/>';
            },
        ]);
    }
}
