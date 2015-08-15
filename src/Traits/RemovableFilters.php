<?php namespace Reillo\Grid\Traits;

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
