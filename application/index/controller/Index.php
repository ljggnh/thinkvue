<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return json(['status'=>'thinkvue OK.']);
    }

    // miss 路由：处理没有匹配到的路由规则
    public function miss()
    {
        if (Request::instance()->isOptions()) {
            return ;
        } else {
            echo 'vuethink接口';
        }
    }
}
