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

        $this->setRendererView(Utils::config('view.renderer.list'));
        $this->setRenderer(new ListRenderer());
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
                'js-grid-pagination' => $this->renderPagination(),
                'js-grid-pagination-info' => $this->renderPaginationInfo(),
            ],
            'status' => 'success'
        ];
    }
}
