<?php namespace Reillo\Grid\Table\Column;

use Reillo\Grid\Exception\LabelRawException;

class LabelRaw {

    /**
     * @var string
     */
    protected $string;

    /**
     * Create label raw instance
     *
     * @param string $string
     * @throws LabelRawException
     */
    function __construct($string)
    {
        if (!is_scalar($string))
        {
            throw new LabelRawException('LabelRaw only accept scalar variable type. '.ucwords(gettype($string)).' given.');
        }

        $this->string = $string;
    }

    /**
     * Return the set string
     *
     * @return string
     */
    function __toString()
    {
        return $this->string;
    }
}
