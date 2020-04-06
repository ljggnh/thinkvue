<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;
use think\Db;
use Env;
use app\admin\model\User;


class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\facade\Response
     */
    public function index()
    {
        // header('Access-Control-Allow-Credentials: true');
        // header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
        // header('Access-Control-Allow-Origin:*');
        return sendSmsVerify('8888','13265551113');

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
