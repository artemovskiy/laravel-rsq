<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:59
 */

namespace Xydens\LaravelRSQ\Interfaces;


use Illuminate\Database\Eloquent\Model;
use Xydens\LaravelRSQ\SessionQueryStorage;

interface QueryBuilder {

    /**
     * Returns built query
     *
     * @return Query
     */
    public function getQuery();

    /**
     * Sets model, which is query applied to
     *
     * @param mixed $model
     * @return void
     */
    public function setModel($model);

    /**
     * @param SessionQueryStorage $session_storage
     * @return void
     */
    public function setSessionStorage(SessionQueryStorage $session_storage);
}