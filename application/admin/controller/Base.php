<?php
// +----------------------------------------------------------------------
// | Description: 基础类，无需验证权限。
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use com\verify\HonrayVerify;
use app\common\controller\Common;
use think\facade\Request;

class Base extends Common
{
    public function login()
    {   
        // dump("OK");
        // die();
        $userModel = model('User');
        $param = $this->param;
        $username = $param['username'];
        $password = $param['password'];
        $verifyCode = !empty($param['verifyCode'])? $param['verifyCode']: '';
        $isRemember = !empty($param['isRemember'])? $param['isRemember']: '';
        $data = $userModel->login($username, $password, $verifyCode, $isRemember);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }

    public function relogin()
    {   
        $userModel = model('User');
        $param = $this->param;
        $data = decrypt($param['rememberKey']);
        $username = $data['username'];
        $password = $data['password'];

        $data = $userModel->login($username, $password, '', true, true);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }    

    public function logout()
    {
        $param = $this->param;
        cache('Auth_'.$param['authkey'], null);
        return resultArray(['data'=>'退出成功']);
    }

    public function getConfigs()
    {
        $systemConfig = cache('DB_CONFIG_DATA'); 
        if (!$systemConfig) {
            //获取所有系统配置
            $systemConfig = model('admin/SystemConfig')->getDataList();
            cache('DB_CONFIG_DATA', null);
            cache('DB_CONFIG_DATA', $systemConfig, 36000); //缓存配置
        }
        return resultArray(['data' => $systemConfig]);
    }

    public function getVerify()
    {
        $captcha = new HonrayVerify(config('captcha'));
        return $captcha->entry();
    }

    public function setInfo()
    {
        $userModel = model('User');
        $param = $this->param;
        $old_pwd = $param['old_pwd'];
        $new_pwd = $param['new_pwd'];
        $auth_key = $param['auth_key'];
        $data = $userModel->setInfo($auth_key, $old_pwd, $new_pwd);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }

    public function loginByOpenid()
    {
        $code=$this->param['code'];
        $openid_data=getTokenOpenid($code);
        if($openid_data['code']<0)
            return resultArray(['error' => $openid_data['msg']],$openid_data['code']);
        $userModel = model('User');
        $data = $userModel->loginByOpenid($openid_data['openid']);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }


    // miss 路由：处理没有匹配到的路由规则
    public function miss()
    {
        return resultArray(['error' =>'地址错误，请检查地址和请求方式(GET|POST|PUT|DELETE)'],$code=-4001);
    }


}
 