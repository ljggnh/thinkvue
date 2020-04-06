<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;
use think\Db;
use Env;


class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\facade\Response
     */
    public function index()
    {
        // $data=input();
        // // $abc=model('user')->hasWhere('openids',['openid' =>'abcd','typeof'=>1])->select();
        // dump($data['a']?:"none");

        // dump(model('user')->get(1)->openids());
        $data=['mida'=>'abcd','midb'=>'abcd123'];
        cache('midofa',$data,0);
        dump(cache('midofa'));
        dump(cache('midofa=>mida'));
        dump($data['mida']);

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\facade\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\facade\Request  $request
     * @return \think\facade\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\facade\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\facade\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\facade\Request  $request
     * @param  int  $id
     * @return \think\facade\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\facade\Response
     */
    public function delete($id)
    {
        //
    }
}
