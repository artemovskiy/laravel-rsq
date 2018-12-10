<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:23
 */

namespace Xydens\LaravelRSQ\Interfaces;


interface ModifiesQuery {

    /**
     * Applies Remote Query properties eg filters, sorters to
     * eloquent query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function modifyQuery(\Illuminate\Database\Eloquent\Builder $query);
}