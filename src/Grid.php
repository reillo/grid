<?php namespace Reillo\Grid;

use Reillo\Grid\Exception\GridException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Support\Contracts\ArrayableInterface;
use Reillo\Grid\Helpers\Utils;
use Reillo\Grid\Interfaces\GridRendererInterface;

abstract class Grid implements ArrayableInterface, JsonableInterface {

    protected $perPage = 25;
    protected $perPageSelection = [5,10,25,50,100];

    /**
     * @var EloquentBuilder|GridException $query
     */
    protected $query;

    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @var GridRendererInterface
     */
    protected $renderer;

    /**
     * url fragment
     *
     * @var $fragment string
     */
    protected $fragment;

    /**
     * Additional url query string
     *
     * @var
     */
    protected $queryString = [];

    /**
     * @var string
     */
    protected $rendererView;

    /**
     * @var string
     */
    protected $noResultView;

    /**
     * @var string
     */
    protected $paginationView;

    /**
     * @var string
     */
    protected $paginationInfoView;

    /**
     * @var string
     */
    protected $perPageView;

    /**
     * Create new instance of grid
     *
     */
    function __construct()
    {
        $this->perPage = Utils::config('per_page');
        $this->perPageSelection = Utils::config('per_page_selection');

        $this->setRendererView(Utils::config('view.renderer.list'));
        $this->setPerPageView(Utils::config('view.per_page'));
        $this->setNoResultView(Utils::config('view.no_result'));
        $this->setPaginationView(Utils::config('view.pagination'));
        $this->setPaginationInfoView(Utils::config('view.pagination_info'));
    }

    /**
     * Set renderer view
     *
     * @param  string  $view
     * @return $this
     */
    public function setRendererView($view) {
        $this->rendererView = $view;
        return $this;
    }

    /**
     * Set Per Page View
     *
     * @param  string  $view
     * @return $this
     */
    public function setPerPageView($view) {
        $this->perPageView = $view;
        return $this;
    }

    /**
     * Set no result view
     *
     * @param  string  $view
     * @return $this
     */
    public function setNoResultView($view) {
        $this->noResultView = $view;
        return $this;
    }

    /**
     * Set pagination View
     *
     * @param  string  $view
     * @return $this
     */
    public function setPaginationView($view) {
        $this->paginationView = $view;
        return $this;
    }

    /**
     * Set pagination info view
     *
     * @param  string  $view
     * @return $this
     */
    public function setPaginationInfoView($view) {
        $this->paginationInfoView = $view;
        return $this;
    }

    /**
     * Set Query Builder
     *
     * @param  $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Return query builder
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set renderer handler
     *
     * @param  GridRendererInterface  $renderer
     * @return $this
     */
    public function setRenderer(GridRendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->setGrid($this);

        return $this;
    }

    /**
     * get renderer
     *
     * @return GridRendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Prepare Grid
     *
     * @return $this
     */
    public function prepareGrid()
    {
        $this->prepareQuery();
        $this->prepareFilters();
        $this->preparePagination();

        return $this;
    }

    /**
     * Prepare query
     *
     * @return $this
     */
    abstract protected function prepareQuery();

    /**
     * Prepare query for pagination
     *
     * @return $this
     */
    protected function preparePagination()
    {
        $this->setQuerySortable();

        // set paginator
        $this->paginator = $this->getQuery()->paginate($this->getPerPage());
        $this->paginator->appends(Request::except('ajax'));

        return $this;
    }

    /**
     * Get Paginator instance
     *
     * @return Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * set query sortable
     *
     * @return mixed
     */
    abstract protected function setQuerySortable();

    /**
     * Prepare filters
     *
     * @return $this
     */
    abstract protected function prepareFilters();

    /**
     * Get per page
     *
     * @return int
     */
    public function getPerPage()
    {
        $per_page = Request::input('per_page', $this->perPage);
        if ($per_page >= 1 && filter_var($per_page, FILTER_VALIDATE_INT) !== false) {
            return $per_page;
        }

        return $this->perPage;
    }

    /**
     * Get Per page selection
     *
     * @return $this
     */
    public function getPerPageSelection()
    {
        return $this->perPageSelection;
    }

    /**
     * Get item collections
     *
     * @return array
     */
    public function getItems()
    {
        return $this->getPaginator()->getItems();
    }


    /**
     * Create url for navigation
     *
     * @param  array  $parameters
     * @return string
     */
    public function createUrl(array $parameters = [])
    {
        $baseUrl = $this->getBaseURL();

        $defaultParam = array_merge($this->queryString, Request::except('ajax'));
        $parameters = array_merge($defaultParam, $parameters);

        // build url query string
        $query_string = http_build_query($parameters, null, '&');
        $raw_param =  !empty($query_string) ? "?" . $query_string : null;

        return $baseUrl . $raw_param . $this->buildFragment();
    }

    /**
     * Get / set the URL fragment to be appended to URLs.
     *
     * @param  string $fragment
     * @return $this|string
     */
    public function fragment($fragment = null)
    {
        return $this->getPaginator()->fragment($fragment);
    }

    /**
     * Build the full fragment portion of a URL.
     *
     * @return string
     */
    protected function buildFragment()
    {
        return $this->fragment() ? '#'.$this->fragment() : '';
    }

    /**
     * Get base url
     *
     * @return string
     */
    public function getBaseURL()
    {
        return $this->getPaginator()->getFactory()->getCurrentUrl();
    }

    /**
     * Set paginator target/base url
     *
     * @param  string  $url
     * @param  array  $queryString
     * @return $this
     */
    public function setBaseURL($url, array $queryString = [])
    {
        $this->getPaginator()->getFactory()->setBaseUrl($url);
        $this->appendQueryString($queryString);

        return $this;
    }

    /**
     * Append Query string to paginator
     *
     * @param  array  $queryString
     * @return $this
     */
    public function appendQueryString(array $queryString = [])
    {
        $this->getPaginator()->appends($queryString);
        $this->queryString = array_merge($this->queryString, $queryString);
        return $this;
    }

    /**
     * Render view and pass the grid instance
     *
     * @param  string  $view
     * @return string
     */
    public function render($view)
    {
        return View::make($view)->with(['grid'=>$this])->render();
    }

    /**
     * Do render grid
     *
     * @return string
     */
    public function renderGrid()
    {
        // set the renderer view
        $this->getRenderer()->setView($this->rendererView);
        return $this->getRenderer()->render();
    }

    /**
     * Do render per page
     *
     * @return string
     */
    public function renderPerPage()
    {
        return $this->render($this->perPageView);
    }

    /**
     * Do render pagination
     *
     * @return string
     */
    public function renderPagination()
    {
        return $this->render($this->paginationView);
    }

    /**
     * Do render grid
     *
     * @return string
     */
    public function renderPaginationInfo()
    {
        return $this->render($this->paginationInfoView);
    }

    /**
     * Do render no result
     *
     * @return string
     */
    public function renderNoResult()
    {
        return $this->render($this->noResultView);
    }


    /**
     * Check if ajax request
     *
     * @return bool
     */
    public function isAjax()
    {
        return Request::ajax() && Request::input('ajax');
    }

    /**
     * Should have method to array
     *
     * @return mixed
     */
    abstract public function toArray();

    /**
     * Get the collection of items as JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Create json response
     *
     * @return string
     */
    public function ajaxResponse()
    {
        return Response::json($this->toArray());
    }
}
