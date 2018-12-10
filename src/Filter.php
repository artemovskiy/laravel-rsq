<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:31
 */

namespace Xydens\LaravelRSQ;

use Xydens\LaravelRSQ\Interfaces\ModifiesQuery;
use Xydens\LaravelRSQ\Utils\ArrayConvertable;

abstract class Filter implements ModifiesQuery {

    use ArrayConvertable;

    /**
     * Column which filer applied to
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