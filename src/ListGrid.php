<?php namespace Reillo\Grid;

use Reillo\Grid\Helpers\Utils;
use Reillo\Grid\Renderer\ListRenderer;

abstract class ListGrid extends Grid {

    /**
     * Create ListGrid Instance
     */
    function __construct()
    {
        parent::__construct();

        $this->prepareGridRenderer();
    }

    /**
     * Prepare grid rendered
     *
     * @return Void
     */
    protected function prepareGridRenderer()
    {
        $renderer = new ListRenderer();
        $renderer->setView(Utils::config('renderer.list_view'));

        $this->setRenderer($renderer);
    }

    /**
     * data to array
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
                // 'js-grid-removable-filter' => $this->render('grid::removable_filter'),
            ],
            'status' => 'success'
        ];
    }
}
