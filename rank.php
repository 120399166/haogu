<?php
header("Content-type:text/html;charset=utf-8");
include 'conn.php';
$arr=array("人事部","研发部","财务部","销售部","后勤部");
$bigArray=array();
for($i=0;$i<count($arr);$i++){
    $num=0;
    $time=0;
    $retArray=array();
    $sel="select username,meeting,number,date from user where meeting='$arr[$i]' order by number desc limit 3";
    $sql=mysql_query($sel);
    while($info=mysql_fetch_array($sql)){
        $array=array('username'=>'','meeting'=>'','number'=>'','date'=>'');
//        echo $info['username'];
//        echo $info['meeting'];
//        echo $info['number']."\n";
//        echo $info['date'];
        $num=$num+$info['number'];
        $time=$time+$info['date'];
//        echo "<br />";
        $array['username']=$info['username'];
        $array['meeting']=$info['meeting'];
        $array['number']=$info['number'];
        $array['date']=$info['date'];
        array_push($retArray,$array);
    }
    $numArray=array('user'=>$retArray,'num'=>$num,'timezone'=>$time);
//	echo $num."<br />";
//	echo $time."<br />";
    array_push($bigArray,$numArray);
}

function func1($oba, $obb){
//print_r($oba)."<br />";
//    print_r($obb['num']);
//echo $obb;
    if($oba['num'] < $obb['num']){
        return 1;
    }
    elseif ($oba['num'] == $obb['num']){
        return ($oba['timezone'] >= $obb['timezone']) ? 1 : -1;
    }

}
usort($bigArray,"func1");
echo json_encode($bigArray);
?>
