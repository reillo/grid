<?php namespace Reillo\Grid\Renderer;

use Illuminate\Support\Facades\View;
use Reillo\Grid\Interfaces\GridRendererInterface;

class TableRenderer extends RendererAbstract implements GridRendererInterface {

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var $view string
     */
    protected $headerView;

    /**
     * @var $headerCached string
     */
    protected $headerCached;

    /**
     * Set collection of columns
     *
     * @param $columns
     * @return $this
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Get column collection
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Get total number of columns
     *
     * @return int
     */
    public function getTotalColumns()
    {
        return count($this->columns);
    }

    /**
     * set header view path
     *
     * @param $headerView
     * @return $this
     */
    public function setHeaderView($headerView)
    {
        $this->headerView = $headerView;
        return $this;
    }

    /**
     * Get the view data
     *
     * @return array
     */
    protected function getViewData()
    {
        return [
            'renderer' => $this,
            'grid' => $this->getGrid(),
        ];
    }

    /**
     * do render header
     *
     * @return string
     */
    public function renderHeader() {
        if (!empty($this->headerCached)) {
            return $this->headerCached;
        }

        return $this->headerCached = View::make($this->headerView)->with($this->getViewData())->render();
    }

    /**
     * do render
     *
     * @return string
     */
    public function render()
    {
        return View::make($this->view)->with($this->getViewData())->render();
    }
}
