<?php include_once "top.php";
if($_GET['logout']){
	$_SESSION['aid']='';
	tellgoto('退出成功','letsgo.php');
}
function checkcode($checkcode){
	if($checkcode == $_SESSION['check_pic']) {
		return true;
	}else{
		tellgoto('验证码错误','index.html');
		break;
	}
}
if($_POST['submit']){
	checkcode($_POST['check']);
	$volunteer=$db->ig2_want('volunteer','voname="'.$_POST['name'].'" and vopass="'.md5($_POST['password']).'"');
	if($volunteer){
		$_SESSION['aid']=$volunteer['id'];
		tellgoto('登录成功','index.html');
	}else{
		tellgoto('账号错误','letsgo.php');
	}
}
?>
<div class="allbar">
    <img src="images/mtg_login.jpg" style="float:left; margin:30px 30px 0 0;"/>
	<form enctype="multipart/form-data" method="post" action="letsgo.php">
	<div style="float:left; width:250px; margin:50px auto;">
		<li><h3 align="center">来</h3></li>
		<li><label>用户：</label><label><input name="name" type="text" style="width:155px" /></label></li>
		<li><label>密码：</label><label><input name="password" type="password" style="width:155px" /></label></li>
		<li><label>验证：</label><label><input type="text" name="check" style="width:70px;"></label><img style="float:none;" src="checkcode.php"></li>
		<li style="border:none;"><label>&nbsp;</label><input name="submit" type="submit" value="登陆" /></li>
	</div>
	</form>
</div>

<?php include_once "down.php";?>