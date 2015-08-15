<?php namespace Reillo\Grid\Interfaces;

use Illuminate\Support\Collection;
use Reillo\Grid\Grid;

interface GridRendererInterface {

    /**
     * Set grid renderer view
     *
     * @param $view
     * @return $this
     */
    public function setView($view);

    /**
     * set Grid
     *
     * @param Grid $grid
     * @return mixed
     */
    public function setGrid(Grid $grid);

    /**
     * get grid instance
     *
     * @return Grid
     */
    public function getGrid();

    /**
     * Set item collections
     *
     * @param Collection $items
     * @return $this
     */
    public function setItems(Collection $items);

    /**
     * Get items collection
     *
     * @return mixed
     */
    public function getItems();

    /**
     * return total number of items
     *
     * @return int
     */
    public function hasItems();

    /**
     * render grid
     *
     * @return string
     */
    public function render();

}
