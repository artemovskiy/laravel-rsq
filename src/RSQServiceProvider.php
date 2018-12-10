<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.02.2018
 * Time: 23:13
 */

namespace Xydens\LaravelRSQ;


use Illuminate\Support\ServiceProvider;

class RSQServiceProvider extends ServiceProvider {

    /**
     * Register RSQ services
     *
     * @return void
     */
    public function register(){
        $this->app->bind(SessionQueryStorage::class,function($app){
            return new SessionQueryStorage($app->make('session')->driver());
        });
        $this->app->singleton(Factory::class,function($app){
            return new Factory($app->make(SessionQueryStorage::class));
        });
    }
}