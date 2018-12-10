<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 10.02.2018
 * Time: 0:56
 */

namespace Xydens\LaravelRSQ\Interfaces;


use Xydens\LaravelRSQ\Query;

interface QueryParser {

    /**
     * Parses query
     *
     * @param Query $query_object
     * @param mixed $raw_query
     * @return Query
     */
    public static function parse(Query $query_object, $raw_query);
}