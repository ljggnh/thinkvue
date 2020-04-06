<?php
// +----------------------------------------------------------------------
// | Description: 第三方登录绑定openid
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\model\Common;

class Openid extends Common 
{
    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
	protected $name = 'admin_openid';


}