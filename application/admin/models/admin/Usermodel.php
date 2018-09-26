<?php

/**
 * User.php
 * 
 * Copyright (c) 2012 SINA Inc. All rights reserved.
 * 
 * @author	ligangzong <gangzong@staff.sina.com.cn>
 * @date	1:14:18 2012-12-12
 * @version	$Id: User.php 13 2012-12-19 07:10:10Z gangzong $
 * @desc	This guy is so lazy that he doesn't leave anything.
 */

class Usermodel extends MY_Model
{

	protected $_table = 'admin_user';
	protected $_pk = 'userid';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('func');
		$this->load->database('default');
	}
	
	/*
	 * 检查用户名重名
	 */
		
	public function checkName($username)
	{
		$username = trim($username);
		$r_sql = $this->find(array('where' => array('username' => $username)));
		$rs = $this->db->query_read($r_sql);
		$r = $rs->result_array();
		return isset($r[0]['username']) ? true : false;
	}
	
	/**
	 * 对用户的密码进行加密
	 * @param $password
	 * @param $encrypt //传入加密串，在修改密码时做认证
	 * @return array/password
	 */
	public function password($password, $encrypt = '')
	{
		$pwd = array();
		$pwd['encrypt'] = $encrypt ? $encrypt : func::randomStr();
		$pwd['password'] = md5(md5(trim($password)) . $pwd['encrypt']);
		return $encrypt ? $pwd['password'] : $pwd;
	}
	/**
	 * 返回表名儿
	 * @return String
	 */
	public function getTable()
	{
		return $this->_table;
	}
	
	/**
	 * 
	 * 根据条件查询数据
	 * @param array
	 * @return Array
	 */
	public function findData($conditons)
	{
		$sql = $this->find($conditons);
		$rs = $this->db->query_read($sql);
		$result = $rs->result_array();
		return $result;		
	}

	public function findUser(){
		$sql = "select * from ".$this->_table." where username = '".$data['user_name']."' limit 1 ";
		$res = $this->db->query($sql);
		print_r($res);
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