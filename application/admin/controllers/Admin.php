<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	/*
	*
	*
	*
	*
	 */
	public function __construct()
	{
		session_start();
		parent::__construct();
		$this->load->model('admin/Usermodel');
		$this->load->model('admin/Rolemodel');
		
	}
	//首页头部
	public function index()
	{
		
		$this->smarty->display('index/main.html');
	}

	public function right_page()
	{
		
		$this->smarty->display('index.html');
	}

	//左侧导航栏
	public function nav()
	{
		
		$this->smarty->display('index/nav.html');
	}

	//登录页面
	public function login(){
		$uri = $this->uri->uri_string;// this uri = admin/login

		$this->smarty->display('login/login.html');
	}

	//登录动作
	public function do_login(){
		$dosubmit = $this->input->post('dosubmit');
		if(isset($dosubmit)){
	      //获取session中的验证码并转为小写 
	      $sessionCode=strtolower($_SESSION['code']); 
	      //获取输入的验证码 
	      $code=strtolower($this->input->post('code')); 
	      //判断是否相等 
	      if($sessionCode==$code){ 



	      	$username = $this->input->post('userName');
			$username = htmlspecialchars($username);
			
			//$username = $SEC->xss_clean($username);
			$password = $this->input->post('password');
			if (empty($username) || empty($password)) {
				echo "<script type='text/javascript'>alert('用户名和密码不能为空!');history.back();</script>";
			} else {
				$mUser = $this->Usermodel;
				$data = array('username'=>$username);
				$user_sql = $mUser->findUser($data);
				echo $user_sql;exit;
				$user_rs = $this->db->query_read($user_sql);
				$user = $user_rs->result_array();
				//$user = $mUser->load($username, 'username');
				//echo $mUser->lastSql();exit;
				if (isset($user[0]) && ($user = current($user)) && ($user['username'] == $username)) {
					$password = $mUser->password($password, $user['encrypt']);
					if ($password == $user['password']) {
					    $session = array();
					    
					    $mRole = $this->roleModel;
					    
					    $roleIds = explode(",", $user['roleid']);
					    if(count($roleIds) > 1){
					        foreach ($roleIds as $v){
					            $role_sql = $mRole->load($v);
					            $role_rs = $this->db->query_read($role_sql);
					            $roleData = $role_rs->result_array();
					            $role = $roleData[0];
					            $session['rolename'][] = $role['rolename'];
					        }
					    } else{
					        $role_sql = $mRole->load($user['roleid']);
    						$role_rs = $this->db->query_read($role_sql);
    						$roleData = $role_rs->result_array();
    						$role = $roleData[0];
					        $session['rolename'] = $role['rolename'];
					    }
					    
					    if(is_array($session['rolename'])){
					        $session['rolename'] = implode("|", $session['rolename']);
					    }
						
						$data = array();
						$data['lastloginip'] = $this->input->ip_address();
						$data['lastlogintime'] = SYS_TIME;
						$tab = $mUser->getTable();
						$up_sql = $mUser->update($user['userid'], $data,$tab);
						$this->db->query_write($up_sql);
						
						$session['userid'] = $user['userid'];
						$session['roleid'] = $user['roleid'];
						$session['username'] = $user['username'];
						$this->session->set_userdata("loginuser", $session);
						unset($mUser, $mRole, $user, $role, $session);
						header('Location:/admin/index/index');
						return false;
					} else {
						$view['errmsg'] = '密码错误';
					}
				} else {
					$view['errmsg'] = '用户不存在';
				}
			}

















	       
	      }else{ 
	        echo "<script type='text/javascript'>alert('验证码错误!');history.back();</script>"; 
	      } 

	    } 
	}

	public function captchaCode(){
		$code= new Captcha(6,2,30,100);
		$_SESSION['code']= $code->getCode();
		$code->outImage();
		//print_r($_SESSION);
	}
}
