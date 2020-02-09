<?php
namespace App\Providers;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\ServiceProvider;

class DbServiceProvider extends ServiceProvider {

    public function boot()
    {   
        // 扩展item方法
        QueryBuilder::macro('item',function(){
            $item = $this->first();
            return $item ? (array)$item : false;
        });

        // 扩展page方法
        QueryBuilder::macro('page',function($perPage = null, $columns = ['*'], $pageName = 'page', $page = null){
            $result = $this->paginate($perPage,$columns,$pageName,$page);
            $items = $result->items();
            $result->list = [];
            foreach ($items as $val) {
                $result->list[] = (array)$val;
            }
            return $result;
        });

        // 扩展lists方法
        QueryBuilder::macro('lists',function(){
            $result = $this->get()->all();
            $lists = [];
            foreach($result as $item){
                $lists[] = (array)$item;
            }
            return $lists;
        });

        // 扩展cates方法
        QueryBuilder::macro('cates',function($index){
            $result = $this->get()->all();
            $lists = [];
            foreach($result as $item){
                $lists[$item->$index] = (array)$item;
            }
            return $lists;
        });

        // 扩展pages方法
        QueryBuilder::macro('pages',function($appends=[], $pageSize = 10){
            $page = $this->paginate($pageSize);
            $items = $page->items();
            $result = [];
            foreach ($items as $value) {
                $result[] = (array)$value;
            }

            //列表
            $data['lists'] = $result;

            //总数
            $data['total'] = $page->total();

            //页码HTML
            $page = $page->onEachSide(1);
            if($appends){
                $page = $page->appends($appends);
            }
            $data['links'] = $page->links('backend.common.pagination');
            return $data;
        });
    }

}