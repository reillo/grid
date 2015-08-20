<?php namespace Reillo\Grid;

use Illuminate\Support\Facades\Request;
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
        $this->setRendererView(Utils::config('view.renderer.table'));
        $this->setRenderer(new TableRenderer());

        $this->prepareColumns();
    }

    /**
     * Prepare default columns
     *
     * @return Void
     */
    abstract protected function prepareColumns();

    /**
     * Prepare Grid
     *
     * @return $this
     */
    public function prepareGrid()
    {
        parent::prepareGrid();

        $this->getRenderer()->setColumns($this->columns);
        return $this;
    }

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
     * Add Column
     *
     * @param $column_id string|Column
     * @param $options array
     */
    public function addColumn($column_id, $options = []) {
        // if column id is an instance of Column?
        $column = Column::make($column_id, $options);
        $this->columns[$column->getColumnId()] = $column;
    }

    /**
     * Add column before column key id
     *
     * @todo refactor ?
     * @param string|Column $column_id
     * @param array $options
     * @param string $before
     * @return Void
     */
    public function addColumnBefore($column_id, $options = [], $before = null)
    {
        $new = [];
        $column = Column::make($column_id, $options);
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
     * @param string|Column $column_id
     * @param array         $options
     * @param null|string   $after
     */
    public function addColumnAfter($column_id, $options = [], $after = null)
    {
        $new = [];
        $column = Column::make($column_id, $options);
        foreach ($this->columns as $key=>$value) {
            $new[$key] = $value;
            if ($after == $key) $new[$column->getColumnId()] = $column;
        }
        $this->columns = $new;
    }

    /**
     * Remove Column
     *
     * @param string $column_id
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
                // remove default orders by
                $this->getQueryBuilder()->orders = [];
                $this->getQuery()->orderBy($column->getColumn(), $dir);
            }
        }
    }

    /**
     * Get the query builder
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getQueryBuilder()
    {
        if ($this->getQuery() instanceof \Illuminate\Database\Query\Builder) {
            return  $this->getQuery();
        }

        return $this->getQuery()->getQuery();
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
     * @param  Column  $column
     * @return null|string
     */
    public function getSortableDir(Column $column)
    {
        if ($column->isSortable()) {
            $sortBy = Request::input('sort_by');
            if ($column->getColumnId() == $sortBy) {
                return Request::input('sort_dir', 'desc') == 'desc' ? 'asc' : 'desc';
            } else if (!empty($sortBy)) {
                // read default order from query
                $default = $this->getQueryBuilder()->orders;
                if (!empty($default)) {
                    $order = $this->getQueryBuilder()->orders[0];
                    if (array_get($order, 'column') == $column->getColumn()) {
                        return array_get($order, 'direction') == 'desc' ? 'asc' : 'desc';
                    }
                }
            }
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
                'js-grid-pagination' => $this->renderPagination(),
                'js-grid-pagination-info' => $this->renderPaginationInfo(),
            ],
            'status' => 'success'
        ];
    }
}
