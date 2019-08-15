<?php
header("Content-type:text/html;charset=utf-8");
session_start();
include 'conn.php';
$select=$_POST['select'];
echo $select;
$telphone=$_POST['telphone'];
$username=$_POST['username'];
$select1="select telphone from user where telphone='$telphone'";
$sql=mysql_query($select1);
$info=mysql_fetch_array($sql);
if(empty($info)){
	$insert="insert into user(username,telphone,meeting) values('$username','$telphone','$select')";
	$mysql=mysql_query($insert);
}else{
	$update="update user set username='$username' where telphone='$telphone'";
	mysql_query($update);
}
$_SESSION['time']=gettimeofday(true);
	$_SESSION['telphone']=$telphone;
	echo "<script>window.location.href='ques.html'</script>";
