<?php
/* Smarty version 3.1.33, created on 2018-09-26 04:48:37
  from 'D:\www\showcar\application\admin\views\login\login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5baaf385144367_41643205',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '350c5226ccb1305d7460a85a871a1af5ec4fa6d1' => 
    array (
      0 => 'D:\\www\\showcar\\application\\admin\\views\\login\\login.html',
      1 => 1537862033,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5baaf385144367_41643205 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=emulateIE7" />
<link rel="stylesheet" type="text/css" href="/statics/admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/statics/admin/css/skin_/login.css" />
<?php echo '<script'; ?>
 type="text/javascript" src="/statics/admin/js/jquery.js"><?php echo '</script'; ?>
>

<title>后台管理_用户登录</title>
</head>

<body>
<div id="container">
    <div id="bd">
    	<div id="main">
        <form action="do_login" method="post"> 
        	<div class="login-box">
                <div id="logo"></div>
                <h1></h1>
                <div class="input username" id="username">
                    <label for="userName">用户名</label>
                    <span></span>
                    <input type="text" name='userName' id="userName" />
                </div>
                <div class="input psw" id="psw">
                    <label for="password">密&nbsp;&nbsp;&nbsp;&nbsp;码</label>
                    <span></span>
                    <input type="password" name='password' id="password" />
                </div>
                <div class="input validate" id="validate">
                    <label for="code">验证码</label>
                    <input type="text" name='code' id="code" />
                    <div class="value"><img id='value_code' src='captchaCode' onclick="change_code(this)" /></div>
                </div>
                
                <div id="btn" class="loginButton">
                    <input type="submit" value="登录" class='button' name="dosubmit"/> 
                </div>
            </div>
        </form>
        </div>
        <div id="ft">CopyRight&nbsp;2016&nbsp;&nbsp;系统版权所有&nbsp;&nbsp;</div>
    </div>
   
</div>

</body>
<?php echo '<script'; ?>
 type="text/javascript">
	var height = $(window).height() > 445 ? $(window).height() : 445;
	$("#container").height(height);
	var bdheight = ($(window).height() - $('#bd').height()) / 2 - 20;
	$('#bd').css('padding-top', bdheight);
	$(window).resize(function(e) {
        var height = $(window).height() > 445 ? $(window).height() : 445;
		$("#container").height(height);
		var bdheight = ($(window).height() - $('#bd').height()) / 2 - 20;
		$('#bd').css('padding-top', bdheight);
    });
	$('select').select();
	
	// $('.loginButton').click(function(e) {
 //        document.location.href = "main.html";
 //    });

    function change_code(t){
        //alert(t.src);
       t.src='captchaCode?'+Math.random();
    }

<?php echo '</script'; ?>
>

</html>
<?php }
}
