<?php
namespace Xydens\LaravelRSQ\Utils;
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 10.02.2018
 * Time: 0:13
 */
trait ArrayConvertable {

    public function toArray(){
        return get_object_vars($this);
    }

    public function fromArray($object_vars){
        foreach ($object_vars as $key=>$value) {
            $this->{$key} = $value;
        }
    }

}