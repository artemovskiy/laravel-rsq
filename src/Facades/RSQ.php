<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 10.02.2018
 * Time: 3:37
 */

namespace Xydens\LaravelRSQ\Facades;


use Illuminate\Support\Facades\Facade;

class RSQ extends Facade {

    protected static function getFacadeAccessor() {
        return \Xydens\LaravelRSQ\Factory::class;
    }
}