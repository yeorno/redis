<?php 
session_start();  
if ($_SESSION['id']=='') {
     echo "<script>alert('请先登录');top.location.href='login.php';</script>";
     
}
$redis=new redis();
$redis->connect('127.0.0.1',6379);
$redis->select(0);
$list=$redis->lrange('id',0,-1);
$count=count($list);
for ($i=0; $i <$count ; $i++) { 
	$data[]=$redis->hgetall('admin:'.$list[$i]);
}
if ($_GET) {
	$id=$_GET['id'];
	$name = $redis->hget("admin:".$id,"name");
	$redis->del('admins:'.$name);
	$redis->del('admin:'.$id);
	$redis->lrem('id',$id);
	$count=$redis->get('uid');
	$redis->set('uid',$count-1);
	if ($redis->get('uid')==0) {
		$redis->delete('uid');
	}
	header("location:list.php");
}

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>用户列表</title>
 	<style type="text/css">
 		 table{margin: auto;}
 		 table tr td{text-align: center;  }
 	</style>
 </head>
 <body>
     <table border="1" cellspacing="0" cellpadding="0" width="500">
     	 <tr>
     	 	<th>序号</th>
     	 	<th>名字</th>
     	 	<th>性别</th>
     	 	<th>操作</th>
     	 </tr>
     	 <?php foreach ($data as  $value) {  ?>
     	 <tr>
     	 	<td><?php echo $value['id'];?></td>
     	 	<td><?php echo $value['name'];?></td>
     	 	<td><?php echo $value['sex'];?></td>
     	 	<td>
     	 		<a href="list.php?id=<?php echo $value['id']?>" onclick='return confirm("确定删除？");' >删除</a>
     	 		<a href="edit.php?id=<?php echo $value['id']?>">修改</a>
     	 	</td>
     	 </tr>
     	 <?php } ?>
     </table>
 </body>
 </html>