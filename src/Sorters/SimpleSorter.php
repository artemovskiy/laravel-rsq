<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:47
 */

namespace Xydens\LaravelRSQ\Sorters;

use Illuminate\Database\Eloquent\Builder;
use Xydens\LaravelRSQ\Sorter;

class SimpleSorter extends Sorter{

    const DESCENDING = 'desc';

    const DESC = 'desc';

    const ASCENDING = 'asc';

    const ASC = 'asc';

    /**
     * Sorting type ASC | DESC
     *
     * @var string
     */
    protected $type = 'desc';

    public function modifyQuery(\Illuminate\Database\Eloquent\Builder $query) {
        return $query->orderBy($this->getColumn(), $this->getType());
    }

    function jsonSerialize() {
        return [
            'column' => $this->column,
            'type' => $this->type
        ];
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     * @return SimpleSorter
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

}