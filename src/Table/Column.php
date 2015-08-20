<?php namespace Reillo\Grid\Table;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Reillo\Grid\Table\Column\LabelRaw;

class Column {

    const OPTION_LABEL       = 'label';
    const OPTION_RENDERER    = 'renderer';
    const OPTION_SORTABLE    = 'sortable';
    const OPTION_CLASS       = 'class';
    const OPTION_RAW_ATTRIBUTES  = 'raw_attributes';
    const OPTION_COLUMN      = 'column';

    /**
     * @var string
     */
    protected $columnId;

    /**
     * Column options
     *
     * @var array
     */
    protected $options = [

        /**
         * header label
         *
         * @var string|LabelRaw
         */
        self::OPTION_LABEL => '',

        /**
         * column renderer. should the same value with the first parameter
         * of cal_user_func function
         *
         * @var Mixed
         */
        self::OPTION_RENDERER => '',

        /**
         * should this column sortable
         *
         * @var bool
         */
        self::OPTION_SORTABLE => false,

        /**
         * Table column class (Applies to th and td)
         *
         * @var string
         */
        self::OPTION_CLASS => '',

        /**
         * Table column additional raw attributes (Applies to th and td)
         *
         * @var string
         */
        self::OPTION_RAW_ATTRIBUTES => '',

        /**
         * The column name use for sorting (only when sortable is true)
         * (i.e customers.first_name, products.customer_id or last_name)
         *
         * @var string
         */
        self::OPTION_COLUMN => '',
    ];

    /**
     * Create Column instance
     *
     * @param string $columnId
     * @param array $options
     */
    function __construct($columnId, array $options = [])
    {
        $this->setColumnId($columnId);
        $this->setOptions($options);
    }

    /**
     * Quick create column instance
     *
     * @param string|Column $columnId
     * @param array $options
     * @return string|Column
     */
    public static function make($columnId, array $options = []) {
        // is an instance of column?
        if ($columnId instanceof self) {
            return $columnId;
        }

        return new self($columnId, $options);
    }

    /**
     * Render column value
     *
     * @param $row - item row
     * @return null|string
     */
    public function render($row) {
        $renderer = $this->getOption(self::OPTION_RENDERER);

        if (empty($renderer)) {
            return e($row->{$this->columnId});
        }

        // if closure ? then run closure
        if ($renderer instanceof \Closure) {
            return $renderer($row, $this);
        }

        // is a user function?
        // [$objectinstance, $methodname]
        // [$classname, $methodname]
        // 'ClassName::staticMethod'
        return call_user_func($renderer, $row, $this);
    }

    /**
     * Set column id
     *
     * @param string $columnId
     * @return $this
     */
    public function setColumnId($columnId)
    {
        $this->columnId = $columnId;
        return $this;
    }

    /**
     * Get column id
     *
     * @return string
     */
    public function getColumnId()
    {
        return $this->columnId;
    }

    /**
     * Set options data
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options = []) {
        $this->options = $options;
        return $this;
    }

    /**
     * Set option value
     *
     * @param string $name - name
     * @param string $value - value
     * @return mixed
     */
    public function setOption($name, $value)
    {
        return $this->options[$name] = $value;
    }

    /**
     * Get option value
     *
     * @param string $option_name
     * @return mixed
     */
    public function getOption($option_name)
    {
        if (isset($this->options[$option_name])) {
            return $this->options[$option_name];
        }

        return null;
    }

    /**
     * Get option label
     *
     * @return string
     */
    public function getLabel()
    {
        // if instance of LabelRaw?
        $string = $this->getOption(self::OPTION_LABEL);
        if ($string instanceof LabelRaw) {
            return $string;
        }

        return e($string);
    }

    /**
     * Get option sortable
     *
     * @return bool
     */
    public function isSortable()
    {
        return $this->getOption(self::OPTION_SORTABLE);
    }

    /**
     * Get option attributes
     *
     * @return string
     */
    public function getRawAttributes()
    {
        return $this->getOption(self::OPTION_RAW_ATTRIBUTES);
    }

    /**
     * Return column class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->getOption(self::OPTION_CLASS);
    }

    /**
     * Get option column
     *
     * @todo change name?
     * @return string
     */
    public function getColumn()
    {
        return $this->getOption(self::OPTION_COLUMN);
    }
}
