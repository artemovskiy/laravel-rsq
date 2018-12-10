<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 10.02.2018
 * Time: 0:56
 */

namespace Xydens\LaravelRSQ\Parsers;


use App\ModelDescriptors\Bid\ClientFullNameFilter;
use Xydens\JSON\JSON;
use Xydens\LaravelRSQ\Filters\RelationFilter;
use Xydens\LaravelRSQ\Query;
use Xydens\LaravelRSQ\Filters\SimpleFilter;
use Xydens\LaravelRSQ\Interfaces\QueryParser;
use Xydens\LaravelRSQ\Scoper;
use Xydens\LaravelRSQ\Sorters\SimpleSorter;

class JsonQueryParser implements QueryParser {

    public static function parse(Query $query,$raw_query) {
        $decoded = JSON::decode($raw_query);
        if(!static::isQueryElem($decoded)){
            throw new \RuntimeException('Wrong query!');
        }
        if(isset($decoded->filter)){
            foreach ($decoded->filter as $column=>$filter){
                $query->pushFilter(static::filterElem($filter)->setColumn($column));
            }
        }
        if(isset($decoded->sort)){
            if(static::getElemType($decoded->sort)== 'simple'){
                $query->pushSorter((new SimpleSorter())
                    ->setColumn(static::elem($decoded->sort))
                );
            }
            else{
                foreach ($decoded->sort as $column=>$sorter){
                    $query->pushSorter(static::sorterElem($sorter)->setColumn($column));
                }
            }
        }
        if(isset($decoded->scope) && (is_array($decoded->scope))){
            foreach ($decoded->scope as $scope){
                $query->pushScoper((new Scoper())
                    ->setScope(static::simpleElem($scope))
                );
            }
        }
        $query->setRaw($raw_query);
        return $query;
    }

    public static function elem($elem){
        switch (static::getElemType($elem)){
            case 'simple':
                return $elem;
        }

    }

    protected static function getElemType($elem){
        switch (true){
            case !is_object($elem):
                return 'simple';
            case static::isSimpleFilterElem($elem):
                return 'filter.simple';
            case static::isRelationFilterElem($elem):
                return 'filter.relation';
            case static::isFilterElem($elem):
                return 'filter';
            case static::isQueryElem($elem):
                return 'query';
            case static::isObject($elem):
                return 'object';
        }
        var_dump($elem);
        throw new \RuntimeException('Unexpected elem type!');
    }

    protected static function isQueryElem($elem){
        return is_object($elem);
    }

    protected static function isObject($elem){
        return is_object($elem);
    }

    /**
     * Filters detectors
     */

    protected static function isFilterElem($elem){
        return static::isSimpleFilterElem($elem);
    }

    protected static function isSimpleFilterElem($elem){
        return isset($elem->value);
    }

    protected static function isRelationFilterElem($elem){
        return isset($elem->related);
    }

    protected static function simpleElem($elem){
        return $elem;
    }

    /**
     * Filter Builders
     */

    protected static function filterElem($elem){
        $type = static::getElemType($elem);
        if($type == 'simple'){
            return (new SimpleFilter())
                ->setValue(static::simpleElem($elem));
        }
        if($type == 'filter.simple'){
            return static::simpleFilterElem($elem);
        }
        if($type == 'filter.relation'){
            return static::relationFilterElem($elem);
        }
    }

    protected static function simpleFilterElem($elem){
        $filter = new SimpleFilter();
        $filter->setValue(static::elem($elem->value));
        if(isset($elem->sign)){
            $filter->setSign(static::simpleElem($elem->sign));
        }
        return $filter;
    }

    protected static function relationFilterElem($elem){
        $filter = new RelationFilter();
        if(is_object($elem->related)){
            foreach ($elem->related as $relation_column=>$value) {
                if($relation_column == 'client_full_name'){
                    $relation_filter = (new ClientFullNameFilter())
                        ->setColumn($relation_column)
                        ->setValue(static::elem($value->value));
                    $filter->pushRelationFilter($relation_filter);
                    continue;
                }
                $filter->pushRelationFilter(static::filterElem($value)->setColumn($relation_column));
            }
        }
        else{
            $filter->pushRelationFilter((new SimpleFilter())
                ->setColumn('id')
                ->setValue($elem->related)
            );
        }
        return $filter;
    }

    /* Sorters Builders */

    protected static function sorterElem($elem){
        $type = static::getElemType($elem);
        if($type == 'simple'){
            return (new SimpleSorter())
                ->setType(static::simpleElem($elem));
        }
    }

}