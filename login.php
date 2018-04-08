<?php 
$redis=new redis();
$redis->connect('127.0.0.1',6379);
$redis->select(0);

if ($_POST) {
	$name=$_POST['name'];
	$pwd=md5($_POST['pwd']);
	
	$id=$redis->get('admins:'.$name);
	if (!$id) {
		 die('该用户不存在');  
	}
	$pwds = $redis->hget('admin:'.$id,'pwd');//返回哈希里面password键的值
	if ($pwd==$pwds) {
		session_start();  
        $_SESSION['name']=$name;  
        $_SESSION['id']=$id;  
        echo "<script>alert('suc');location.href='index.php';</script>";
        //header('location:index.php');
	}else{
		echo "<script>alert('账号有误');</script>";
	}
}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>登录页面</title>
 </head>
 <body>
     <form method="post">
     	 名字<input type="text" name="name"> <br><br>
     	 密码<input type="password" name="pwd"> <br><br>
     	
     	 <input type="submit" value="登录"> <br><br>
     </form>
 </body>
 </html>