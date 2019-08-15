<?php
include 'conn.php';
header("Content-type:text/html;charset=utf-8");
$sum=0;
$time=0;
$bigArray=array();
$arr=array("人事部","研发部","财务部");
for ($i=0;$i<count($arr);$i++){
   $meetingArray=array();
    $sel="select * from user where meeting='$arr[$i]' order by number desc limit 3";
    $sql=mysql_query($sel);
    while ($info=mysql_fetch_array($sql)){
        $arrArray=array('username'=>'','meeting'=>'','number'=>'','date'=>'');
        $sum=$sum+$info['number'];
        $time=$time+$info['date'];
        $arrArray['username']=$info['username'];
        $arrArray['meeting']=$info['meeting'];
        $arrArray['number']=$info['number'];
        $arrArray['date']=$info['date'];
        array_push($meetingArray,$arrArray);
    }
    $thisArray=array('user'=>$meetingArray,'sum'=>$sum,'timezone'=>$time);
    array_push($bigArray,$thisArray);
}
print_r($bigArray);
