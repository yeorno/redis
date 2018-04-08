<?php 
session_start();  
if ($_SESSION['id']=='') {
	echo "<script>alert('请先登录');top.location.href='login.php';</script>";
	
}

$redis=new redis();

$redis->connect('127.0.0.1',6379);

$redis->select(0);

if ($_POST) {
	 $name=$_POST['name'];
	 $pwd=md5($_POST['pwd']);
	 $sex=$_POST['sex'];
	 $uid=$redis->incr('uid');
	 $redis->set('admins:'.$name,$uid);
	 $redis->hmset('admin:'.$uid,array('id'=>$uid,'name'=>$name,'pwd'=>$pwd,'sex'=>$sex));

	 $redis->lpush('id',$uid);

}



 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>首页</title>
 </head>
 <body>
     <a href="list.php">列表页</a>
     <form  method="post">
     	  名字：<input type="text" name="name"> <br><br>
     	  密码：<input type="password" name="pwd"> <br><br>
     	  <input type="radio" name="sex" value="male">male 
     	  <input type="radio" name="sex" value="female">female <br><br>
     	  <input type="submit" value="添加">
     </form>
 </body>
 </html>