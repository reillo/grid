<?php namespace Reillo\Grid\Renderer;

use Illuminate\Support\Facades\View;
use Reillo\Grid\Helpers\Utils;
use Reillo\Grid\Interfaces\GridRendererInterface;

class ListRenderer extends RendererAbstract implements GridRendererInterface {

    /**
     * Create list renderer instance
     */
    function __construct()
    {
        $this->setView(Utils::config('renderer.list_view'));
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
     * do render
     *
     * @return string
     */
    public function render()
    {
        return View::make($this->view)->with($this->getViewData())->render();
    }
}
