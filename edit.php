<?php 
session_start();  
if ($_SESSION['id']=='') {
	echo "<script>alert('请先登录');top.location.href='login.php';</script>";
	
}
$redis=new redis();
$redis->connect('127.0.0.1',6379);
$redis->select(0);
$id=isset($_GET['id'])?$_GET['id']:'';

$data=$redis->hgetall('admin:'.$id);
if ($_POST) {
	$name=$_POST['name'];
	$sex=$_POST['sex'];
	$result=$redis->hmset('admin:'.$id,array('name'=>$name,'sex'=>$sex));
	
	if ($result) {
		
		header('location:list.php');
	}

}



 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>编辑页面</title>
 </head>
 <body>
     <form  method="post">
     	  名字：<input type="text" name="name" value="<?php echo $data['name'];?>"> <br><br>
     	  
     	  <input type="radio" name="sex" <?php if($data['sex']=='male'){echo "checked";}?> value="male">male 
     	  <input type="radio" name="sex" value="female" <?php if($data['sex']=='female'){echo "checked";}?>>female <br><br>
     	  <input type="submit" value="添加">
     </form>
 </body>
 </html>