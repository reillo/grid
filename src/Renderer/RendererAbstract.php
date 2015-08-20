<?php namespace Reillo\Grid\Renderer;

use Illuminate\Support\Collection;
use Reillo\Grid\Grid;

abstract class RendererAbstract {

    /**
     * @var string
     */
    protected $view;

    /**
     * @var Grid
     */
    protected $grid;

    /**
     * Set Grid instance
     *
     * @param Grid $grid
     * @return $this
     */
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;
        return $this;
    }

    /**
     * has items
     *
     * @return int
     */
    public function hasItems()
    {
        return count($this->getGrid()->getItems());
    }

    /**
     * Get items
     *
     * @return int
     */
    public function getItems()
    {
        return $this->getGrid()->getItems();
    }

    /**
     * Get the Grid instance
     *
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * Set view path
     *
     * @param string $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Get view path
     *
     * @return string
     */
    public function getView()
    {
        return $this;
    }
}
