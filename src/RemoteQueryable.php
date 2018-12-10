<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:15
 */

namespace Xydens\LaravelRSQ;

use Xydens\LaravelRSQ\Facades\RSQ;
use Illuminate\Http\Request;

trait RemoteQueryable {

    public static function request(Request $request){
        $query = RSQ::request($request)->setModel(static::class);
        return self::RSQ($query);
    }

    public static function requestOrSession(Request $request){
        $query = RSQ::requestOrSession($request,static::class)->saveToSession();
        return self::RSQ($query);
    }

    public static function RSQ(Query $query){
        return $query->modifyQuery(static::query());
    }

}