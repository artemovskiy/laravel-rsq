<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 10.02.2018
 * Time: 2:41
 */

namespace Xydens\LaravelRSQ;

use Xydens\LaravelRSQ\QueryBuilders\JsonQueryBuilder;
use Illuminate\Http\Request;

class Factory {

    /**
     * @var SessionQueryStorage
     */
    protected $session_storage;

    function __construct(SessionQueryStorage $session_query_storage) {
        $this->session_storage = $session_query_storage;
    }

    protected function makeQueryBuilder(){
        $builder = new JsonQueryBuilder();
        $builder->setSessionStorage($this->session_storage);
        return $builder;
    }

    public function request(Request $request){
        $builder = $this->makeQueryBuilder();
        if($request->has('query')){
            $builder->fromJson($request->input('query'));
        }
        return $builder->getQuery();
    }

    public function requestOrSession(Request $request,$model){
        $builder = $this->makeQueryBuilder();
        $builder->setModel($model);
        if($request->has('query')){
            $builder->fromJson($request->input('query'));
        }
        if($builder->getQuery()->isEmpty() && $this->session_storage->existsModelQuery($model)){
            $builder->fromSession($this->session_storage);
        }
        return $builder->getQuery();
    }

    public function saveToSession(Query $query,$model = null){
        $this->session_storage->saveModelQuery($query,$model);
    }


}