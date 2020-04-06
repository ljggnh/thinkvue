<?php
// +----------------------------------------------------------------------
// | Description: 系统配置
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;

class SystemConfig extends Model 
{

	/**
	 * 获取配置列表
	 * @param  array   $param  [description]
	 */
	public function getDataList()
	{
		$list = $this->where('group',0)->select();
		$data = array();
        foreach ($list as $key => $val) {
            $data[$val['name']] = $val['value'];
        }
        return $data;
	}

	/**
	 * 批量修改配置
	 * @param  array   $param  [description]
	 */
	public function createData($param)
	{
		$list = [
		    ['id' => 1, 'value' => $param['SYSTEM_NAME']],
		    ['id' => 2, 'value' => $param['SYSTEM_LOGO']],
		    ['id' => 3, 'value' => $param['LOGIN_SESSION_VALID']],
		    ['id' => 4, 'value' => $param['IDENTIFYING_CODE']],	
		    ['id' => 5, 'value' => $param['LOGO_TYPE']],			
		];
		if ($this->saveAll($list)) {
			$data = $this->getDataList();
			cache('DB_CONFIG_DATA', $data, 3600);
			return $data;
		}
		$this->error = '更新失败';
		return false;
	}

	/**
	 * 获取openid配置列表
	 * @param  array   $param  [description]
	 */
	public function getOpenidDataList()
	{
		$list = $this->where('group',1)->select();
		$data = array();
        foreach ($list as $key => $val) {
            $data[$val['name']] = $val['value'];
        }
        return $data;
	}

	/**
	 * 修改openid
	 * @param  array   $param  [description]
	 */
	public function saveOpenid($param)
	{
		$list = [
			['id' => 6, 'value' => $param['APPID_WEIXIN']],
			['id' => 7, 'value' => $param['SECRET_WEIXIN']],
			['id' => 8, 'value' => $param['APPID_QQ']],
			['id' => 9, 'value' => $param['SECRET_QQ']],
			['id' => 10, 'value' => $param['APPID_ALIPAY']],
			['id' => 11, 'value' => $param['SECRET_ALIPAY']],
			['id' => 12, 'value' => $param['APPID_WXXCX']],
			['id' => 13, 'value' => $param['SECRET_WXXCX']],
			['id' => 14, 'value' => $param['APPID_BAIDU']],
			['id' => 15, 'value' => $param['SECRET_BAIDU']],
			['id' => 16, 'value' => $param['APPID_BYTE']],
			['id' => 17, 'value' => $param['SECRET_BYTE']]			
		];
		if ($this->saveAll($list)) {
			$data = $this->getDataList();
			cache('DB_CONFIG_DATA', $data, 3600);
			return $data;
		}
		$this->error = '更新失败';
		return false;
	}}