<?php
ob_start();
header("content-type:text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(1);
require_once 'class/ig2sql.class.php';
$db=new ig2sql();
$db->ig2_conn('Localhost','root','root','mtg','utf8');//4w2y7i4z8g
session_start();
if($_SESSION) $vo=$db->ig2_want('volunteer','id='.$_SESSION['aid']);
function tellgoto($tell,$goto){
	echo "<script language=javascript>alert('".$tell."');</script>";
	echo "<script language=javascript>document.location.href='".$goto."';</script>";
}
function getCost($str){
	if(preg_match('/\{/',trim($str),$arr)){
		$str_split = preg_split('/\{/',trim($str));
		for($i=0;$i<count($str_split);$i++){
		    if(preg_match_all('/2\/[A-Z]/',$str_split[$i],$arr)){
				switch(substr($str_split[$i],0,3)){
				    case '2/W':
					echo "<img src='images/O.png' height='26' />";
					break;
					case '2/U':
					echo "<img src='images/T.png' height='26' />";
					break;
					case '2/B':
					echo "<img src='images/V.png' height='26' />";
					break;
					case '2/R':
					echo "<img src='images/Y.png' height='26' />";
					break;
					case '2/G':
					echo "<img src='images/Z.png' height='26' />";
					break;
				}
			}else if(preg_match_all('/\d+|X/',$str_split[$i],$arr)){
				echo "<img src='images/".$arr[0][0].".png' height='26' />";
				//print_r($str_split);
			}else{
				switch(substr($str_split[$i],0,3)){
					case 'U/R':
					echo "<img src='images/I.png' height='26' />";
					break;
					case 'W/U':
					echo "<img src='images/A.png' height='26' />";
					break;
					case 'U/B':
					echo "<img src='images/D.png' height='26' />";
					break;
					case 'B/G':
					echo "<img src='images/J.png' height='26' />";
					break;
					case 'R/G':
					echo "<img src='images/K.png' height='26' />";
					break;
					case 'B/R':
					echo "<img src='images/L.png' height='26' />";
					break;
					case 'G/U':
					echo "<img src='images/M.png' height='26' />";
					break;
					case 'G/W':
					echo "<img src='images/N.png' height='26' />";
					break;
					case 'W/B':
					echo "<img src='images/Q.png' height='26' />";
					break;
					case 'R/W':
					echo "<img src='images/S.png' height='26' />";
					break;
					case 'WP}':
					echo "<img src='images/E.png' height='26' />";
					break;
					case 'RP}':
					echo "<img src='images/F.png' height='26' />";
					break;
					case 'UP}':
					echo "<img src='images/P.png' height='26' />";
					break;
					case 'BP}':
					echo "<img src='images/H.png' height='26' />";
					break;
					case 'GP}':
					echo "<img src='images/AA.png' height='26' />";
					break;
				}
			}
		}
	}else{
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
}
?>
