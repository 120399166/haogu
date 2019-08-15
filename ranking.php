<?php
	header("Content-type:text/html;charset=utf-8");
	session_start();
	include 'conn.php';
	$_SESSION['time']=gettimeofday(true);
	$_SESSION['id_th']=1;
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=0.5, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>地服答题比赛排行榜</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<style>
    #tableid tr td {
        vertical-align: middle;
    }

    #bgimg {
        position: absolute;
        top: 35.5%;
        left: 5%;
        width: 90%;
        background: url(img/pbanner.png) no-repeat;
        background-size: 100%;
        height: 9.5%;
    }
</style>

<body>
    <div class="container rank">
        <table class="table table-bordered ranktable" id="tableid">
            <div id="bgimg">


            </div>
            <tbody id="tbody-result">
            </tbody>
        </table>
    </div>
    <script src="js/rank.js"></script>
    <script>
      if(window.history && window.history.pushState) {
		$(window).on('popstate', function() {　　　　　　　　　　　　　　　　 /// 当点击浏览器的 后退和前进按钮 时才会被触发， 
			window.history.pushState('forward', null, '');
			window.history.forward(1);
		});
	}　　　　　　　　　　 //
	window.history.pushState('forward', null, ''); //在IE中必须得有这两行
	window.history.forward(1);
  </script>
</body>

</html>