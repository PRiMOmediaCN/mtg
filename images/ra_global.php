<?php
ob_start();
header("content-type:text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(1);
require_once 'class/ig2sql.class.php';
require_once 'class/calendar.class.php';
$db=new ig2sql();
$db->ig2_conn('Localhost','root','4w2y7i4z8g','mtg','utf8');//4w2y7i4z8g
session_start();
if($_SESSION['id']!='') $user=$db->ig2_want('users','id='.$_SESSION['id']);
function tellgoto($tell,$goto){
	echo "<script language=javascript>alert('".$tell."');</script>";
	echo "<script language=javascript>document.location.href='".$goto."';</script>";
}
function getCost($str){
	$str_split = preg_split("/([A-Z]+)/",trim($str),0,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);  
	for($i=0;$i<count($str_split);$i++){
		if(preg_match_all('/\d+/',$str_split[$i],$arr)){
			echo "<img src='images/".$arr[0][0].".png' height='26' />";
		}else{
			$cost_arr=str_split(trim($str_split[$i]));
			for($j=0;$j<count($cost_arr);$j++){
				echo "<img src='images/".$cost_arr[$j].".png' height='26' />";
			}
		}
	}
}
?>
