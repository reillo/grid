<?php namespace Reillo\Grid\Traits;
use Reillo\Grid\Helpers\Utils;

/**
 * Class FilterRemovableTrait
 *
 * @package App\CMS\Libraries\Filterable
 */
trait RemovableFiltersTrait {

    /**
     * Removable filter
     *
     * @var array
     */
    protected $removableFilters = [];

    /**
     * @var string
     */
    protected $removableView;

    /**
     * Set removable view
     *
     * @param  $view
     * @return $this
     */
    public function setRemovableView($view) {
        $this->removableView = $view;
        return $this;
    }

    /**
     * Get removable view
     *
     * @return string
     */
    public function getRemovableView()
    {
        // if empty then use default
        if (empty($this->removableView)) {
            $this->removableView = Utils::config('view.removable_filter');
        }

        return $this->removableView;
    }

    /**
     * Get removable view
     *
     * @return string
     */
    public function renderRemovableFilter() {
        return $this->render($this->getRemovableView());
    }

    /**
     * Return all removable filters
     *
     * @return array
     */
    public function getRemovableFilters()
    {
        return $this->removableFilters;
    }

    /**
     * Add removable filters
     *
     * @param string $key   - The input key name (i.e first_name, status[])
     * @param string $label - The label of removable filter
     * @param array $param  - CreateUrl param
     */
    public function addRemovableFilter($key, $label, array $param = [])
    {
        $this->removableFilters[$key] = [
            'label' => $label,
            'param'  => $param,
        ];
    }
}
