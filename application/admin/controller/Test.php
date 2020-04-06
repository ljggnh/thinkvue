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
        // // return ['data' => $_SERVER['HTTP_USER_AGENT']];
        // // $code=$this->params['code'];
        // // $openid_data=getTokenOpenid($code);
        // $openid_data=['code'=>1, 'openid'=>'abcd', 'msg'=>'请求错误'];
        // if($openid_data['code']<0)
        //     return resultArray(['error' => $openid_data['msg']]);
        // $userModel = new User;
        // $data = $userModel->loginByOpenid($openid_data['openid']);
        // if (!$data) {
        //     return resultArray(['error' => $userModel->getErrcode().$userModel->getError()],$userModel->getErrcode());
        // } 
        // return resultArray(['data' => $data]);
        // $code=input('code');
        // // if(!$code)
        // //     $this->redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_re');
        // $this->redirect('Admin/Base/loginByOpenid',['code' => $code]);
        $data='{"a":234,"b":"abc"}';
        dump($data);
        dump(json_decode($data,true));
    }

    public function index2()
    {
        // $data=['a'=>'b', 'c'=>'d', 'e'=>'f'];
        // dump($data['a']);
        dump(model('user')->hasWhere('openids',['openid'=>'abcd'])->select()->toArray());
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
