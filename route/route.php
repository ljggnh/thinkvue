<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

//MISS路由，严格路由，未声明的地址重定位，可注释掉取消
// Route::miss('admin/base/miss');


return [
    // 定义资源路由
    '__rest__'=>[
        'admin/rules'		   =>'admin/rules',
        'admin/groups'		   =>'admin/groups',
        'admin/users'		   =>'admin/users',
        'admin/menus'		   =>'admin/menus',
        'admin/structures'	   =>'admin/structures',
        'admin/posts'          =>'admin/posts',
    ],

	// 【基础】登录
	'admin/base/login' => ['admin/base/login', ['method' => 'POST']],
	// 【基础】记住登录
	'admin/base/relogin'	=> ['admin/base/relogin', ['method' => 'POST']],
	// 【基础】修改密码
	'admin/base/setInfo' => ['admin/base/setInfo', ['method' => 'POST']],
	// 【基础】退出登录
	'admin/base/logout' => ['admin/base/logout', ['method' => 'POST']],
	// 【基础】获取配置
	'admin/base/getConfigs' => ['admin/base/getConfigs', ['method' => 'POST|GET']],
	// 【基础】获取验证码
	'admin/base/getVerify' => ['admin/base/getVerify', ['method' => 'GET']],
	// 【基础】上传图片
	'admin/upload' => ['admin/upload/index', ['method' => 'POST']],
	'upload' => ['admin/upload/index', ['method' => 'POST']],
	// 保存系统配置
	'admin/systemConfigs' => ['admin/systemConfigs/save', ['method' => 'POST']],
	// 【规则】批量删除
	'admin/rules/deletes' => ['admin/rules/deletes', ['method' => 'POST']],
	// 【规则】批量启用/禁用
	'admin/rules/enables' => ['admin/rules/enables', ['method' => 'POST']],
	// 【用户组】批量删除
	'admin/groups/deletes' => ['admin/groups/deletes', ['method' => 'POST']],
	// 【用户组】批量启用/禁用
	'admin/groups/enables' => ['admin/groups/enables', ['method' => 'POST']],
	// 【用户】批量删除
	'admin/users/deletes' => ['admin/users/deletes', ['method' => 'POST']],
	// 【用户】批量启用/禁用
	'admin/users/enables' => ['admin/users/enables', ['method' => 'POST']],
	// 【菜单】批量删除
	'admin/menus/deletes' => ['admin/menus/deletes', ['method' => 'POST']],
	// 【菜单】批量启用/禁用
	'admin/menus/enables' => ['admin/menus/enables', ['method' => 'POST']],
	// 【组织架构】批量删除
	'admin/structures/deletes' => ['admin/structures/deletes', ['method' => 'POST']],
	// 【组织架构】批量启用/禁用
	'admin/structures/enables' => ['admin/structures/enables', ['method' => 'POST']],
	// 【部门】批量删除
	'admin/posts/deletes' => ['admin/posts/deletes', ['method' => 'POST']],
	// 【部门】批量启用/禁用
    'admin/posts/enables' => ['admin/posts/enables', ['method' => 'POST']],

	// 【部门】批量启用/禁用
	'admin/base/loginbyopenid' => ['Admin/Base/loginByOpenid', ['method' => 'POST|GET']],

	//测试页面
    'test' => ['admin/test/index', ['method' => 'POST|GET']]
    
];