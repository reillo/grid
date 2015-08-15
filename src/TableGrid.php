<?php namespace Reillo\Grid;

use Illuminate\Support\Facades\Input;
use Reillo\Grid\Helpers\Utils;
use Reillo\Grid\Table\Column;
use Reillo\Grid\Renderer\TableRenderer;

abstract class TableGrid extends Grid {

    /**
     * column collections
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Create TableGrid Instance
     */
    function __construct()
    {
        parent::__construct();

        $renderer = (new TableRenderer());
        $renderer->setView(Utils::config('renderer.table.table_view'));
        $renderer->setHeaderView(Utils::config('renderer.table.table_header_view'));

        $this->setRenderer($renderer);
        $this->prepareColumns();
    }

    /**
     * Prepare default columns
     *
     * @return Void
     */
    abstract protected function prepareColumns();

    /**
     * Get grid renderer
     *
     * @return TableRenderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Prepare grid rendered
     *
     * @return $this
     */
    protected function prepareGridRenderer()
    {
        $this->getRenderer()
            ->setItems($this->getItemCollections())
            ->setColumns($this->columns)
            ->setGrid($this);

        return $this;
    }

    /**
     * Create Column instance
     *
     * @param $column_id string|Column
     * @param $options array
     * @return Column
     */
    private function createColumnInstance($column_id, array $options = [])
    {
        // is an instance of column?
        if ($column_id instanceof Column) {
            return $column_id;
        }

        return (new Column($column_id, $options));
    }

    /**
     * Add Column
     *
     * @param $column_id string|Column
     * @param $options array
     */
    public function addColumn($column_id, $options = []) {
        // if column id is an instance of Column?
        $column = $this->createColumnInstance($column_id, $options);
        $this->columns[$column->getColumnId()] = $column;
    }

    /**
     * Add column before column key id
     *
     * @todo refactor ?
     * @param $column_id
     * @param array $options
     * @param string $before
     * @return Void
     */
    public function addColumnBefore($column_id, $options = [], $before = null)
    {
        $new = [];
        $column = $this->createColumnInstance($column_id, $options);
        foreach ($this->columns as $key=>$value) {
            if ($before == $key) $new[$column->getColumnId()] = $column;
            $new[$key] = $value;
        }
        $this->columns = $new;
    }

    /**
     * Add column after column key id
     *
     * @todo refactor ?
     * @param $column_id
     * @param $options
     * @param $after
     */
    public function addColumnAfter($column_id, $options = [], $after = null)
    {
        $new = [];
        $column = $this->createColumnInstance($column_id, $options);
        foreach ($this->columns as $key=>$value) {
            $new[$key] = $value;
            if ($after == $key) $new[$column->getColumnId()] = $column;
        }
        $this->columns = $new;
    }

    /**
     * Remove Column
     *
     * @param $column_id
     * @return void
     */
    public function removeColumn($column_id)
    {
        $column_id = !is_array($column_id) ? [$column_id] : $column_id;
        foreach ($column_id as $key) {
            unset($this->columns[$key]);
        }
    }

    /**
     * Set query sortable
     *
     * @return Void
     */
    protected function setQuerySortable()
    {
        /**@var $column Column*/
        foreach ($this->columns as $column) {
            if ($dir = $this->getSortableDir($column)) {
                $this->getQuery()->orderBy($column->getColumn(), $dir);
            }
        }
    }

    /**
     * Create sortable url
     *
     * @param Column $column
     * @return null|string
     */
    public function createSortableUrl(Column $column)
    {
        if ($column->isSortable()) {
            return $this->createUrl([
                'sort_by' => $column->getColumnId(),
                'sort_dir' => $this->getSortableDir($column)
            ]);
        }

        return null;
    }

    /**
     * Sortable column method
     *
     * @param Column $column
     * @return null|string
     */
    public function getSortableDir(Column $column)
    {
        if ($column->isSortable() && $column->getColumnId() == Input::get('sort_by')) {
            return  Input::get('sort_dir', 'desc') == 'desc' ? 'asc' : 'desc';
        }

        return null;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'replace' => [
                'js-grid-renderer' => $this->renderGrid(),
                'js-grid-pagination' => $this->render('grid::pagination'),
                'js-grid-pagination-info' => $this->render('grid::pagination_info'),
                'js-grid-removable-filter' => $this->render('grid::removable_filter'),
                // 'js-grid-per-page' => $this->render('grid::per_page'),
            ],
            'status' => 'success'
        ];
    }
}
