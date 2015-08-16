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
     * Set grid renderer view
     *
     * @return string
     */
    public function getView();

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
     * render grid
     *
     * @return string
     */
    public function render();

}
