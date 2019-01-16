<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 19.11.2017
 * Time: 17:58
 */

namespace Xydens\LaravelRSQ\Filters;

use Illuminate\Database\Eloquent\Builder;
use Xydens\LaravelRSQ\Filter;

class SimpleFilter extends Filter {

    const SING_EQUIVALENT = 'equivalent';

    const SING_LIKE = 'like';

    const SING_IN = 'in';

    protected $sign = self::SING_EQUIVALENT;

    protected $value;

    public function modifyQuery(Builder $query){
        switch ($this->sign){
            case self::SING_EQUIVALENT:
                return $query->where($this->column,$this->value);
                break;
            case self::SING_LIKE:
                return $query->where($this->column,'LIKE','%'.$this->value.'%');
                break;
            case self::SING_IN:
                return $query->whereIn($this->column,$this->value);
                break;
            default:
                return $query->where($this->column,$this->sign,$this->value);
                break;
        }
    }

    /**
     * @return string
     */
    public function getSign() {
        return $this->sign;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string $sign
     * @return SimpleFilter
     */
    public function setSign($sign) {
        $this->sign = $sign;

        return $this;
    }

    /**
     * @param mixed $value
     * @return SimpleFilter
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

}