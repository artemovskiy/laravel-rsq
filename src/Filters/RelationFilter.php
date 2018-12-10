<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:40
 */

namespace Xydens\LaravelRSQ\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Xydens\LaravelRSQ\Filter;

class RelationFilter extends Filter {

    /**
     * Relation model filters applied to related model
     *
     * @var Collection
     */
    protected $relation_filters;

    function __construct() {
        $this->relation_filters = new Collection();
    }

    public function modifyQuery(\Illuminate\Database\Eloquent\Builder $query) {
        return $query->whereHas($this->column,function(Builder $query){
            return $this->modifyRelationQuery($query);
        });
    }

    public function modifyRelationQuery(Builder $query){
        return $this->relation_filters->reduce(function(Builder $carry,Filter $item){
            return $item->modifyQuery($carry);
        },$query);
    }

    /**
     * @return Collection
     */
    public function getRelationFilters() {
        return $this->relation_filters;
    }

    /**
     * @param Collection $relation_filters
     * @return RelationFilter
     */
    public function setRelationFilters(Collection $relation_filters) {
        $this->relation_filters = $relation_filters;

        return $this;
    }

    public function pushRelationFilter(Filter $filter){
        $this->relation_filters->put($filter->getColumn(),$filter);
    }

}