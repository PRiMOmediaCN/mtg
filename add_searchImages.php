<?php
include_once "ra_global.php";
$set=$db->ig2_want('sets','id='.$_GET['id']);
$packs=$_GET['pack'];

$deck=array();
for($i=1;$i<=$packs;$i++){
	$glod=$db->ig2_select('cards','sets='.$set['id'].' and side<2 and (rarity=3 or rarity=4) order by rand() limit 1');
	$sil=array();
	$iro=array();
	foreach($db->ig2_select('cards','sets='.$set['id'].' and side<2 and rarity=2 order by rand() limit 3') as $silver){
		$sil[]=$silver;
	}
	foreach($db->ig2_select('cards','sets='.$set['id'].' and side<2 and rarity=1 order by rand() limit 9') as $iron){
		$iro[]=$iron;
	}
	$thiscard=array_merge($glod,$sil,$iro);
	//print_r($thiscard);
	
	foreach($thiscard as $list){
		$deck[]=array(
		    'id'=>'',
			'cnum'=>1,
			'cename'=>$list['ename'],
			'ismain'=>1,
			'cid'=>$list['id'],
			'side'=>$list['side'],
			'serial'=>$list['serial'],
			'sid'=>$set['id'],
			'abbr'=>$set['abbr']
		);
	}
}

include_once "class/image_worker.class.php";

$maker=new image_worker();
$maker->id='';
$maker->deck=$deck;
$maker->name='';
if(key_exists("sbwater",$_GET)&&$_GET['sbwater']==1){
    $maker->sbwater=true;
}
if($_GET['uhland']){
    $maker->uhland=true;
}
if($_GET['lang']){
    $maker->en=true;
}
if($_GET['doublesize']){
    $maker->doublesize=true;
}
$maker->makeIMG($db);
?>