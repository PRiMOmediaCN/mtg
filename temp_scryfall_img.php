<?php
include_once "ra_global.php";

$dir=scandir('file/dom');
foreach($dir as $d){
    $name_arr=explode('-',$d);
	if(count($name_arr)>1) rename('file/dom/'.$d,'file/dom/'.$name_arr[1].'.jpg');
	else echo $d;
}
?>