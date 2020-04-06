<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use AlibabaCloud\Client\AlibabaCloud as AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;


/**
 * 行为绑定
 */
\think\facade\Hook::add('app_init', 'app\\common\\behavior\\InitConfigBehavior');

// +-----------------------------------------------------------
// | 以下函数为直接返回
// +-----------------------------------------------------------

/**
 * 返回对象
 * @param $array 响应数据
 * @example code:大于0为正确返回，反之错误返回。
 * 约定：
 * 1为默认返回，-1为默认错误
 * -1001~-1999 用户权限信息错误
 *   -1001 登录失效
 *   -1002 没有操作权限
 *   -1003 
 * -2001~-2999 系统错误
 *   -2001 发生了严重错误导致无法进行
 * -3001~-3999 数据错误
 *   -3001 数据结构错误
 *   -3002 数据存在冲突
 * -4001~-4999 配置错误
 */
function resultArray($array, $code = 1)
{
    if (isset($array['data'])) {
        $array['error'] = '';
    } elseif (isset($array['error'])) {
        if ($code == 1) $code = -1;
        $array['data'] = '';
    }
    return json([
        'code'  => $code,
        'data'  => $array['data'],
        'error' => $array['error']
    ]);
}

/**
 * 调试方法
 * @param  array   $data  [description]
 */
function p($data, $die = 1)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if ($die) die;
}

/**
 * 用户密码加密方法
 * @param  string $str      加密的字符串
 * @param  [type] $auth_key 加密符
 * @return string           加密后长度为32的字符串
 */
function user_md5($str, $auth_key = '')
{
    return '' === $str ? '' : md5(sha1($str) . $auth_key);
}

/**
 * 获取系统配置
 * @param {string} configName: 配置项名，为空则返回所有配置
 * @return: {string}
 */
function getSystemConfig($configName = '')
{
    $data = cache('thinkvue');
    if (!$data) {
        $configs = model('SystemConfig')->select()->toArray();
        foreach ($configs as $k => $v) {
            $data[$v['name']] = $v;
        }
        cache('thinkvue', $data, 0);
    }
    if ($configName)
        if (isset($data[$configName]['value']))
            return $data[$configName]['value'];
        else
            throw new UnexpectedValueException('不存在该名称的配置');
    else
        return $data;
}

/**
 * 获取客户端类型
 * @return {int}
 */
function getClientType()
{
    static $clientTypes = ['OtherClient', 'miniprogram', 'MicroMessenger', 'QQ', 'AlipayClient', 'swan/', 'ToutiaoMicroApp'];
    // static $clientTypes =['other','微信小程序','微信','QQ小程序','支付宝小程序','百度小程序','头条小程序'];
    $client = $_SERVER['HTTP_USER_AGENT'];
    foreach ($clientTypes as $k => $v) {
        if (strpos($client, $v))
            return $k;
    }
    return 0;
}

/**
 * 获取客户端中文名称
 * @param {int} $clientType
 * @return {string}
 */
function getClientName(int $clientType)
{
    // static $clientTypes =['OtherClient','miniprogram','MicroMessenger','QQ','AlipayClient','swan/','ToutiaoMicroApp'];
    static $clientTypes = ['其他浏览器', '微信小程序', '微信', 'QQ小程序', '支付宝小程序', '百度小程序', '头条小程序'];
    return $clientTypes[$clientType];
}

// +-----------------------------------------------------------
// | 以下函数为标准返回['code'=>code,'msg'=>msg,'data'=>data]
// +-----------------------------------------------------------

/**
 * 获取授权token
 * @param string $code 通过get_authorize_url获取到的code
 * @param string $anonymous_code 限字节跳动小程序通过login获取到的anonymous_code
 * @return ['code'=>1,'token'=>token,'openid'=>openid,'msg'=>errMsg];
 */
function getTokenOpenid($code,$anonymous_code="")
{
    $clientType=2;
    // $clientType=getClientType();
    if($clientType==1){ //微信小程序
        $appid = getSystemConfig('APPID_WXXCX');
        $appsecret = getSystemConfig('SECRET_WXXCX');
        $token_url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";
        $data = http_send($token_url);
        if ($data['code'] == 200) {
            if($data['data']['errcode']!=0)
                return ['code'=>-4002, 'msg'=>$data['data']['errmsg']];
            return ['code'=>1,'session_key'=>$data['data']['session_key'],'openid'=>$data['data']['openid']];
        }
    }elseif($clientType==2){ //微信公众号
        $appid = getSystemConfig('APPID_WEIXIN');
        $appsecret = getSystemConfig('SECRET_WEIXIN');
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        $data = http_send($token_url);
        if ($data['code'] == 200) {
            if(isset($data['data']['errcode']))
                return ['code'=>-4002, 'msg'=>$data['data']['errmsg']];
            return ['code'=>1,'token'=>$data['data']['access_token'],'openid'=>$data['data']['openid']];
        }
    }elseif($clientType==3){ //QQ
        $appid = getSystemConfig('APPID_QQ');
        $appsecret = getSystemConfig('SECRET_QQ');
        $token_url = "https://api.q.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";
        $data = http_send($token_url);
        if ($data['code'] == 200) {
            if($data['data']['errcode']!=0)
                return ['code'=>-4002, 'msg'=>$data['data']['errmsg']];
            return ['code'=>1,'session_key'=>$data['data']['session_key'],'openid'=>$data['data']['openid']];
        }
    }elseif($clientType==4){ //支付宝 未支持
        $appid = getSystemConfig('APPID_ALIPAY');
        $appsecret = getSystemConfig('SECRET_ALIPAY');
    }elseif($clientType==5){ //百度
        $appid = getSystemConfig('APPID_BAIDU');
        $appsecret = getSystemConfig('SECRET_BAIDU');
        $data=['code'=>$code,'client_id'=>$appsecret,'sk'=>$appsecret];
        $token_url = "https://spapi.baidu.com/oauth/jscode2sessionkey ";
        $data = http_send($token_url,'POST',$data);
        if ($data['code'] == 200) {
            if(isset($data['data']['error']))
                return ['code'=>-4002, 'msg'=>$data['data']['error_description']];
            return ['code'=>1,'session_key'=>$data['data']['session_key'],'openid'=>$data['data']['openid']];
        }
    }elseif($clientType==6){ //头条
        $appid = getSystemConfig('APPID_BYTE');
        $appsecret = getSystemConfig('SECRET_BYTE');
        $data=['code'=>$code,'appid'=>$appsecret,'secret'=>$appsecret,'anonymous_code'=>$anonymous_code];
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        $data = http_send($token_url);
        if ($data['code'] == 200) {
            if($data['data']['errcode']!=0)
                return ['code'=>-4002, 'msg'=>$data['data']['errmsg']];
            return ['code'=>1,
                    'session_key'=>$data['data']['session_key'],
                    'openid'=>$data['data']['openid'],
                    'anonymous_openid'=>$data['data']['anonymous_openid']
                ];
        }
    }
    return ['code'=>-1, 'msg'=>'非法请求，服务器拒绝服务'];
}

/**
 * 请求用户信息
 * @param 通过getTokenOpenid请求返回的access_token和openid
 * @return: {"openid":'',"nickname":'',"sex":"1","province":'',"city":'',"country":'',"headimgurl":url,"privilege":[]}
 */
function getUserinfo($access_token,$openid)
{
    $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
    $data=http_send($url);
    if($data['code']==200)
        return json_decode($data['data'],true);
    return false;
}

/**
 * 发送HTTP请求 
 * @param String url: url地址 
 * @param String method: 请求模式， GET|POST default 'GET'
 * @param String data: 请求数据 default null
 * @param String headers: 模拟请求头 default NULL 
 * @param Boolean debug: 是否调试模式 default false
 * @param String url: url地址 
 * @param String url: url地址 
 * @return [$http_code, $return_data]
 */
function http_send($url, $method = 'GET', $data = null, $headers = array(), $debug = false)
{
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ci, CURLOPT_TIMEOUT, 30);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

    switch ($method) {
        case 'POST':
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($data)) {
                curl_setopt($ci, CURLOPT_POSTFIELDS, $data);
                $this->postdata = $data;
            }
            break;
    }
    curl_setopt($ci, CURLOPT_URL, $url);
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
        var_dump($data);

        echo '=====info=====' . "\r\n";
        print_r(curl_getinfo($ci));

        echo '=====$response=====' . "\r\n";
        print_r($response);
    }
    curl_close($ci);
    return ['code' => $http_code, 'data' => json_decode($response,true)];
}

/**
 * 发送短信（短信宝）
 * @param {string} mobile 手机号 
 * @param {string} content 短信内容
 * @return: 
 */
function sendmsg_smsbao($mobile,$content)
{
    if (empty($content) || empty($mobile)) 
        return ['code' => -2002 , 'msg'=>'参数不正确，短信内容和手机号缺一不可。'];
    $statusStr = [
        "0"  => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    ];
    $username = getSystemConfig('SMSBAO_USERNAME'); //短信平台帐号
    $password = getSystemConfig('SMSBAO_PASSWORD'); //短信平台密码（已用MD5加密)
    // $content = str_replace('{code}',$code,getSystemConfig('VERIFY_SMS_CONTENT')); //要发送的短信内容
    $url = "http://api.smsbao.com/sms?u={$username}&p={$password}&m={$mobile}&c={$content}";
    $httpData = http_send($url);
    if($httpData['code'] != 200)
        return ['code'=>-4003, 'msg'=>'服务器网络错误，请求失败'];
    $code = $httpData['data']==0 ? 1 : -2002;
    return ['code'=>$code,'msg'=>$statusStr[$httpData['data']]];
}

/**
 * 发送阿里云短信
 * @param {Object} data['code'=>6666] 短信模板里的变量
 * @param {string} mobile 手机号
 * @param {string} templateCode 短信模板号
 * @return: 标准返回
 */
function sendmsg_ali($data, $mobile,$templateCode)
{
    $accessKeyId=getSystemConfig('Ali_AccessKeyId');
    $accessSecret=getSystemConfig('Ali_AccessSecret');
    AlibabaCloud::accessKeyClient($accessKeyId, $accessSecret)->regionId('cn-hangzhou')->asDefaultClient();
    try {
        $result = AlibabaCloud::rpc()
            ->product('Dysmsapi')
            ->version('2017-05-25')
            ->action('SendSms')
            ->method('POST')
            ->host('dysmsapi.aliyuncs.com')
            ->options([ 'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $mobile,
                        'SignName' => getSystemConfig('Ali_SignName'),
                        'TemplateCode' => $templateCode,
                        'TemplateParam' => json_encode($data)]])
            ->request();
        $result=$result->toArray();
        if($result['Message']=='OK')
            return ['code'=>1, 'msg'=>'OK'];
        else
            return ['code'=>-1, 'msg'=>$result['Message']];
    } catch (Exception $e) {
        return ['code'=>-1,'msg'=>$e->getErrorMessage()];
    }
}

/**
 * 发送验证码
 * @param {string} $code 验证码
 * @param {string} $mobile 手机号 
 * @return: 标准返回
 */
function sendSmsVerify($code,$mobile)
{
    $smsInterface = getSystemConfig('SMS_Interface_Type');
    if($smsInterface==1) // 阿里云接口
        return sendmsg_ali(['code'=>$code],$mobile,getSystemConfig('Ali_Verify_TemplateCode'));
    elseif($smsInterface==2){
        $content=str_replace("{code}",$code,getSystemConfig('SMSBAO_VERIFY_SMS_CONTENT'));
        return sendmsg_smsbao($mobile,$content);
    }
}