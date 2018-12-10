<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:56
 */

namespace Xydens\LaravelRSQ\QueryBuilders;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Xydens\LaravelRSQ\Parsers\JsonQueryParser;
use Xydens\LaravelRSQ\Parsers\RequestQueryParser;
use Xydens\LaravelRSQ\Query;
use Xydens\LaravelRSQ\Interfaces\QueryBuilder;
use Xydens\LaravelRSQ\SessionQueryStorage;

class JsonQueryBuilder implements QueryBuilder {

    /**
     * @var Query
     */
    protected $query;

    function __construct() {
        $this->query = new Query();
    }

    public function fromJson($array) {
        $this->query = JsonQueryParser::parse($this->query, $array);
    }

    public function setModel($model) {
        $this->query->setModel($model);
    }

    public function fromSession(SessionQueryStorage $session_storage){
        $this->query = $session_storage->fillModelQuery($this->query);
    }

    public function setSessionStorage(SessionQueryStorage $session_storage) {
        $this->query->setSessionStorage($session_storage);
    }

    public function getQuery() {
        return $this->query;
    }

}