<?php

/**
 * Role.php
 * 
 * Copyright (c) 2012 SINA Inc. All rights reserved.
 * 
 * @author	ligangzong <gangzong@staff.sina.com.cn>
 * @date	23:04:16 2012-12-11
 * @version	$Id: Role.php 13 2012-12-19 07:10:10Z gangzong $
 * @desc	This guy is so lazy that he doesn't leave anything.
 */

class RoleModel extends MY_Model
{
	protected $_table = 'sgm_admin_role';
	
	protected $_pk = 'roleid';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}
	
	public function checkRoleName($name)
	{
		$condition = array(
			'where' => array(
				'rolename' => $name,
			),
			'order' => 'id ASC',
			'limit' => 1,
		);
		
		$r = $this->find($condition);
	}

	/**
	 *  检查指定菜单是否有权限
	 * @param array $data menu表中数组
	 * @param int $roleid 需要检查的角色ID
	 */
	public function is_checked($data, $roleid, $siteid, $priv_data)
	{
		$priv_arr = array('m', 'c', 'a', 'data');
		if($data['m'] == '')
			return false;
		foreach($data as $key => $value) {
			if(!in_array($key, $priv_arr))
				unset($data[$key]);
		}
		$data['roleid'] = $roleid;
		$data['siteid'] = $siteid;
		$info = in_array($data, $priv_data);
		if($info) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获取菜单深度
	 * @param $id
	 * @param $array
	 * @param $i
	 */
	public function get_level($id, $array = array(), $i = 0)
	{
		foreach($array as $n => $value) {
			if($value['id'] == $id) {
				if($value['parentid'] == '0')
					return $i;
				$i++;
				return $this->get_level($value['parentid'], $array, $i);
			}
		}
	}

	/**
	 * 获取菜单表信息
	 * @param int $menuid 菜单ID
	 * @param int $menu_info 菜单数据
	 */
	public function get_menuinfo($roleid, $menuid, &$menu_info)
	{
		$menuid = intval($menuid);
		$menu_info[$menuid]['siteid'] = $menu_info[$menuid]['id'];
		$menu_info[$menuid]['roleid'] = $roleid;
		unset($menu_info[$menuid]['id']);
		return $menu_info[$menuid];
	}
	
	/**
	 * 
	 * 根据条件查询数据
	 * @param array
	 * @return Array
	 */
	public function findData($conditions = array())
	{
		$sql = $this->find($conditions);
		$rs = $this->db->query_read($sql);
		$result = $rs->result_array();
		return $result;		
	}

	/**
	 *  更新数据信息
	 *  @param $id 
	 *  @param $data
	 *  @return true/false
	 */
	
	public function updateData($id,$data)
	{
		$sql = $this->update($id,$data,$this->_table);
		$rs = $this->db->query_write($sql);
		return $rs;
	}
	
	/**
	 * 
	 * 查询信息数据
	 * @param unknown_type $id
	 * @param unknown_type $col
	 */
	public function loadData($id, $col = null)
	{
		$sql = $this->load($id,$col);
		$rs = $this->db->query_read($sql);
		$result = $rs->result_array();
		return  $result;
	}
	
	public function deleteData($id, $col = null)
	{
		$sql = $this->delete($id,$col);
		$rs = $this->db->query_write($sql);
		return $rs;
	}
	
	public function insertData($data, $table = null)
	{
		$sql = $this->insert($data, $table = null);
		$rs  = $this->db->query_write($sql);
		return $rs;
		
	}
	
}
?>