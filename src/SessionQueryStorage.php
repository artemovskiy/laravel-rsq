<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 10.02.2018
 * Time: 2:42
 */

namespace Xydens\LaravelRSQ;


use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Session\Store;
use Xydens\LaravelRSQ\Interfaces\QueryBuilder;
use Xydens\LaravelRSQ\Parsers\JsonQueryParser;
use Xydens\LaravelRSQ\QueryBuilders\JsonQueryBuilder;

class SessionQueryStorage {

    /**
     * @var Store
     */
    protected $store;

    function __construct(Store $store) {
        $this->store = $store;
    }

    public static function getShortModelName($model_class){
        foreach (Relation::morphMap() as $morph => $real){
            if($real == $model_class) return $morph;
        }
        return $model_class;
    }

    public static function getModelName($model){
        if(is_object($model)) $class = get_class($model);
        else $class = $model;
        return self::getShortModelName($class);
    }

    public static function getSessionKey($model){
        return 'rsq-model.'.self::getModelName($model);
    }

    public function fillModelQuery(Query $query,$model = null){
        if($model == null) $model = $query->getModel();
        $raw = $this->store->get(self::getSessionKey($model));
        return JsonQueryParser::parse($query,$raw);
    }

    public function saveModelQuery(Query $query,$model = null){
        if($model == null) $model = $query->getModel();
        $this->store->put(self::getSessionKey($model),$query->getRaw());
    }

    public function existsModelQuery($model){
        return $this->store->has(self::getSessionKey($model)) && $this->store->get(self::getSessionKey($model)) != null;
    }

}