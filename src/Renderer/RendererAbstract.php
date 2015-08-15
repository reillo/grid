<?php namespace Reillo\Grid\Renderer;

use Illuminate\Support\Collection;
use Reillo\Grid\Grid;

abstract class RendererAbstract {

    /**
     * @var Grid
     */
    protected $grid;

    /**
     * @var Collection
     */
    protected $items;

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
     * Get the Grid instance
     *
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * Set the items to render
     *
     * @param  Collection $items
     * @return $this
     */
    public function setItems(Collection $items) {
        $this->items = $items;
        return $this;
    }

    /**
     * Get item Collection
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Return the total number of items
     *
     * @return int
     */
    public function hasItems()
    {
        return count($this->items);
    }

}
