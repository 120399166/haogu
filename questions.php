<?php
header("Content-type:text/html;charset=utf-8");
session_start();
include 'conn.php';
date_default_timezone_set("PRC");
$code = rand(1, 7);
if (empty($_SESSION['id_th'])) {
	$_SESSION['id_th'] = 1;
}

$ansInfo = array('max' => 0, 'show' => "none", 'now' => 0, 'time' => 0);
if (empty($_SESSION['id'])) {
	$_SESSION['id'] = $code;
} else {
	$_SESSION['id'] = $_SESSION['id'] + 1;
}

if ($_SESSION['id'] > 7) {
	$_SESSION['id'] = 1;
}
$code = $_SESSION['id'];
//	echo $code;
$select = "select id,title,A,B,C,D from answer where id='$code'";
$sql = mysql_query($select);
@$info = mysql_fetch_array($sql);

// echo $info;

$_SESSION["ans_id"] = $info["id"];
if (empty($_SESSION['number'])) {
	$_SESSION['number'] = 0;
}
function check()
{
	$id = $_POST['id'];
	$key = $_POST['A'];
	$key = trim($key);
	$select = "select id,ans from answer where id='$id'";
	$sql = mysql_query($select);
	$abc = mysql_fetch_array($sql);

	if ($abc['ans'] != $key) {
		$_SESSION['id_th'] = 1;
		//		echo "错误";
		gettimeofday(true);
		$date = floor(gettimeofday(true) - $_SESSION['time']);
		$f_number = floor($date / 60);
		$m_number = $date % 60;

		$active = "update answer set active=0";
		$mysql = mysql_query($active);
		$session = $_SESSION['number'];
		$tel = $_SESSION['telphone'];
		$sec = "select number from user where telphone='$tel'";
		$sql_sec = mysql_query($sec);
		$info1 = mysql_fetch_array($sql_sec);
		$arr = $info1['number'];
		unset($_SESSION['number']);
		$ansInfo['time'] = $f_number . ":" . $m_number;
		$ansInfo['show'] = 'block';
		if ($session > $arr) {
			$update = "update user set number='$session',date='$date' where telphone='$tel'";
			$mysql = mysql_query($update);
			$ansInfo['max'] = $session;
			$ansInfo['now'] = $session;

			//echo "<script>alert('本轮得分：$session\\n本轮用时：$f_number:$m_number\\n历史最高分：$session');</script>";
		} else {
			//echo "<script>alert('本轮得分：$session\\n本轮用时：$f_number:$m_number\\n历史最高分：$arr');</script>";
			$ansInfo['max'] = $arr;
			$ansInfo['now'] = $session;
		}
	} else {

		//		echo "正确";
		$ansInfo['show'] = 'none';
		$_SESSION['number'] = $_SESSION['number'] + 1;
		$_SESSION['id_th'] = $_SESSION['id_th'] + 1;
		//		$active = "update answer set active=1 where id='$id'";
		//		$mysql = mysql_query($active);

	}
	return $ansInfo;
}

if (!empty($_POST['A'])) {
	$ansInfo = check();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=0.5, user-scalable=yes">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>开始答题</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container begin">
		<div class="quesshow">
			<!-- 答题的头部部分 -->
			<header>
				<div class="col-xs-6 ">地服技能比武复赛答题</div>
				<div style="display: inline-block;float: left;margin-left: 20%;">倒计时：</div>
				<div class="col-xs-3" id="timer" style="float: right;width: 10%;">0</div>
				<div class="col-xs-12 " style="background-color: black;margin-top: 3%;"></div>
			</header>
			<form action="" id="sender" method="post" name="form1">
				<!-- 此为题目区域 -->
				<div class="questions">
					<div class="col-xs-1" style="margin-left: 2%;"><strong><?php echo $_SESSION['id_th']; ?>.</strong></div>
					<?php echo $info["title"] ?>
				</div>
				<footer style="margin-top: -10%;">
					<label style="padding-left: 5%;padding-top: 2.5%;padding-bottom: 2.5%; margin-left: 10%;margin-top: 20%;cursor:pointer;" onclick="" class="answers">
						<div>
							<input type="radio" name="rad" id="btnA" value="<?php echo $info['A'] ?>" style="width: 20px; height: 20px;" />
							<?php echo $info['A'] ?>
						</div>
					</label>
					<label style="padding-left: 5%;padding-top: 2.5%;padding-bottom: 2.5%; margin-left: 10%;cursor:pointer;" class="answers" onclick="">
						<div>
							<input type="radio" name="rad" id="btnB" value="<?php echo $info['B'] ?>" style="width: 20px; height: 20px;" />
							<?php echo $info['B'] ?>
						</div>
					</label>
					<label style="padding-left: 5%;padding-top: 2.5%;padding-bottom: 2.5%; margin-left: 10%;cursor:pointer;" class="answers" onclick="">
						<div>
							<input type="radio" name="rad" id="btnC" value="<?php echo $info['C'] ?>" style="width: 20px; height: 20px;" />
							<?php echo $info['C'] ?>
						</div>
					</label>
					<label style="padding-left: 5%;padding-top: 2.5%;padding-bottom: 2.5%; margin-left: 10%;cursor:pointer; " class="answers" onclick="">
						<div>
							<input type="radio" name="rad" id="btnD" value="<?php echo $info['D'] ?>" style="width: 20px; height: 20px;" />
							<?php echo $info['D'] ?>
						</div>
					</label>
					<input type="hidden" id="ans" name="A" value='' />
					<input type="hidden" name="id" value="<?php echo $info['id'] ?>" />
					<input type="" id="sub" name="" value="确定" onclick="return check();" style="width: 20%;margin-left: 40%;margin-top: 5%;" />
				</footer>
			</form>
		</div>
	</div>
	<!-- <?php echo $zb->a; ?>-->
	<div id="div" style="display:<?php echo $ansInfo['show']; ?>;width: 70%;height: 650px;background: #FFF;border-radius: 10%;border: 1px #ccc solid;margin: 50% auto;-moz-box-shadow:2px -1px 5em #333333;-webkit-box-shadow:2px -1px 5em #333333;box-shadow:2px -1px 5em #333333;position: absolute;top: -3%;left: 15%;">
		<div style="font-size: 5em;color: #ccc;text-align: center;">本轮得分 </div>
		<div style="font-size: 12em;color: red;text-align: center;"><?php echo $ansInfo['now']; ?></div>
		<div style="text-align: center;font-weight: bold;font-size: 1.5em;margin-top: 4%;">本轮总耗时：<span style="color: red;"><?php echo $ansInfo['time']; ?></span></div>
		<div style="text-align: center;font-size: 1.8em;font-weight: bold;margin-top: 4%;">历史最高分：<span style="color: red;"><?php echo $ansInfo['max']; ?></span></div>
		<form action="unset.php" method="post">
			<div style="display: inline-block;margin-left: 10%; margin-top: 10%;">
				<input type="submit" name="submit" id="" value="继续" border="0" style="display: inline-block;width: 172px;height: 7%;background: #fafafa;color: blue;font-size: 2em;text-align: center;border-radius: 20px;font-weight: bold;border: 0;" />
			</div>
			<div style="display: inline-block;margin-left: 15%;width: 172px;height: 7%;background: #fafafa;font-size: 2em;text-align: center;border-radius: 20px;font-weight: bold;"><a href="http://donghang.haoguit.com/ranking.php" style="color: blue;" id="timestop">退出</a></div>

		</form>

	</div>
</body>

</html>
<script type="text/javascript">
	$(document).ready(function() {
		if (window.name == "") {
			console.log("首次被加载");
			window.name = "isReload"; // 在首次进入页面时我们可以给window.name设置一个固定值 
		} else if (window.name == "isReload") {
			console.log("页面被刷新");
		};
		$("#sub").attr('type', "button");
		$(".answers").click(function() {
			$("#sub").attr("type", "submit");
			var isPageHide = false;
			window.addEventListener('pageshow', function() {
				if (isPageHide) {
					window.location.reload();
				}
			});
			window.addEventListener('pagehide', function() {
				isPageHide = true;
			});
		});
	});
	document.getElementById('btnA').onclick = function() {
		document.getElementById('ans').value = "A";
	}
	document.getElementById('btnB').onclick = function() {
		document.getElementById('ans').value = "B";
	}
	document.getElementById('btnC').onclick = function() {
		document.getElementById('ans').value = "C";
	}
	document.getElementById('btnD').onclick = function() {
		document.getElementById('ans').value = "D";
	}
</script>


<script>
	jQuery(document).ready(function() {
		if (window.history && window.history.pushState) {
			$(window).on('popstate', function() { /// 当点击浏览器的 后退和前进按钮 时才会被触发， 
				window.history.pushState('forward', null, '');
				window.history.forward(1);
			});
		} //
		window.history.pushState('forward', null, ''); //在IE中必须得有这两行
		window.history.forward(1);
	});
	document.onkeydown = function(e) {
		var ev = window.event || e;
		var code = ev.keyCode || ev.which;
		if (code == 116) {
			ev.keyCode ? ev.keyCode = 0 : ev.which = 0;
			cancelBubble = true;
			return false;
		}
	} //禁止f5刷新
	document.oncontextmenu = function() {
		return false
	}; //禁止右键刷新
	//防止iOS系统页面缓存不刷新机制
	var isPageHide = false;
	window.addEventListener('pageshow', function() {
		if (isPageHide) {
			window.location.reload();
		}
	});
	window.addEventListener('pagehide', function() {
		isPageHide = true;
	});
	var timer = document.getElementById("timer");
	var sender = document.getElementById("sender");
	var len = 30;
	timer.innerHTML = len;
	var time_date = setInterval(function() {
		len--;
		timer.innerHTML = len;
		if (len == 0) {
			document.getElementById('ans').value = "W";
			sender.submit();
		}
	}, 1000)

	if ("<?php echo $ansInfo['show']; ?>" == "block") {
		clearInterval(time_date);
	};

	function check() {
		return document.getElementById('ans').value != "";
	}
</script>