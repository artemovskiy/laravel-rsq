<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:45
 */

namespace Xydens\LaravelRSQ;


use Xydens\LaravelRSQ\Interfaces\ModifiesQuery;
use Xydens\LaravelRSQ\Utils\ArrayConvertable;

abstract class Sorter implements ModifiesQuery, \JsonSerializable {

    use ArrayConvertable;
    /**
     * Column which models sorted by
     *
     * @var string
     */
    protected $column;

    /**
     * @return string
     */
    public function getColumn() {
        return $this->column;
    }

    /**
     * @param string $column
     * @return self
     */
    public function setColumn($column) {
        $this->column = $column;

        return $this;
    }
}