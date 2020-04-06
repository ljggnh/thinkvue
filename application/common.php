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


/**
 * 行为绑定
 */
\think\facade\Hook::add('app_init','app\\common\\behavior\\InitConfigBehavior');

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
function resultArray($array,$code =1)
{
    if(isset($array['data'])) {
        $array['error'] = '';
    } elseif (isset($array['error'])) {
        if($code ==0 ) $code = -1;
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
function p($data,$die=1)
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

