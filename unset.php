<?php
	header("Content-type:text/html;charset=utf-8");
	session_start();
	include 'conn.php';
	$_SESSION['time']=gettimeofday(true);
	$_SESSION['id_th']=1;
	echo "<script>window.location.href='questions.php'</script>";
?>