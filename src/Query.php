<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:16
 */

namespace Xydens\LaravelRSQ;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Xydens\LaravelRSQ\Interfaces\ModifiesQuery;
use Xydens\LaravelRSQ\Utils\ArrayConvertable;

class Query implements ModifiesQuery {

    use ArrayConvertable;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var SessionQueryStorage
     */
    protected $session_storage;

    /**
     * Contains query filers
     *
     * @var Collection
     */
    protected $filters;

    /**
     * Contains query sorters
     *
     * @var Collection
     */
    protected $sorters;

    /**
     * Collection of Scoper
     *
     * @var Collection
     */
    protected $scopers;
    /**
     * Raw RSQ
     *
     * @var mixed
     */
    protected $raw;

    function __construct() {
        $this->filters = new Collection();
        $this->sorters = new Collection();
        $this->scopers = new Collection();
    }

    public function modifyQuery(\Illuminate\Database\Eloquent\Builder $query) {
        $query_with_filters = $this->filters->reduce(function(Builder $carry,ModifiesQuery $item){
            return $item->modifyQuery($carry);
        },$query);
        $query_with_sorters = $this->sorters->reduce(function(Builder $carry,ModifiesQuery $item){
            return $item->modifyQuery($carry);
        },$query_with_filters);
        $query_with_scopers = $this->scopers->reduce(function(Builder $carry,ModifiesQuery $item){
            return $item->modifyQuery($carry);
        },$query_with_sorters);
        return $query_with_scopers;
    }

    public function saveToSession(){
        $this->session_storage->saveModelQuery($this);
        return $this;
    }

    public function isEmpty(){
        return $this->filters->count() == 0 && $this->sorters->count() == 0 && $this->scopers->count() == 0;
    }

    /**
     * @return Model
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * @param Model $model
     * @return Query
     */
    public function setModel($model) {
        $this->model = $model;

        return $this;
    }

    public function pushFilter(Filter $filter){
        $this->filters->put($filter->getColumn(),$filter);
    }

    public function pushSorter(Sorter $sorter){
        $this->sorters->put($sorter->getColumn(),$sorter);
    }

    public function pushScoper(Scoper $scoper){
        $this->sorters->push($scoper);
    }

    /**
     * @return mixed
     */
    public function getRaw() {
        return $this->raw;
    }


    /**
     * @param mixed $raw
     * @return Query
     */
    public function setRaw($raw) {
        $this->raw = $raw;

        return $this;
    }

    /**
     * @return SessionQueryStorage
     */
    public function getSessionStorage() {
        return $this->session_storage;
    }

    /**
     * @param SessionQueryStorage $session_storage
     * @return Query
     */
    public function setSessionStorage($session_storage) {
        $this->session_storage = $session_storage;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getScopers() {
        return $this->scopers;
    }

    /**
     * @param Collection $scopers
     * @return Query
     */
    public function setScopers($scopers) {
        $this->scopers = $scopers;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFilters() {
        return $this->filters;
    }

    /**
     * @return Collection
     */
    public function getSorters() {
        return $this->sorters;
    }
}