<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 10.02.2018
 * Time: 12:16
 */

namespace Xydens\LaravelRSQ;


use Xydens\LaravelRSQ\Interfaces\ModifiesQuery;

class Scoper implements ModifiesQuery {

    /**
     * @var string
     */
    protected $scope;

    public function modifyQuery(\Illuminate\Database\Eloquent\Builder $query) {
        return call_user_func([$query,$this->scope]);
    }

    /**
     * @return string
     */
    public function getScope() {
        return $this->scope;
    }

    /**
     * @param string $scope
     * @return Scoper
     */
    public function setScope($scope) {
        $this->scope = $scope;

        return $this;
    }
}