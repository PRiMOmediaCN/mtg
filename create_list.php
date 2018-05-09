<?php 
header("Content-type: text/html; charset=utf-8"); 
include_once "ra_global.php";
$deck=$db->ig2_want('decks','id='.$_GET['did']);
if($deck['id']){
	$format=$db->ig2_want('formats','id='.$deck['format']);
	$crts=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=1');
	$plan=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=2');
	$aane=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=3');
	$spel=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=4');
	$land=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=5');
	$sideb=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=0');
	$coall=count($crts)+count($plan)+count($aane)+count($spel)+count($land)+count($othe)+count($sideb);
	$coall+=4;
}else{
	tellgoto('您的访问有误','index.php');
}

$txt='';
if($_GET['lang']=='en'){
	if(count($crts)){
		$txt.="Creature : \r\n";
		foreach($crts as $crt){
			$txt.=$crt['cnum'].' '.$crt['cename']."\r\n";
		}
	}
	if(count($plan)){
		$txt.="\r\nPlaneswalker :\r\n";
		foreach($plan as $pla){
			$txt.=$pla['cnum'].' '.$pla['cename']."\r\n";
		}
	}
	if(count($aane)){
		$txt.="\r\nEnchantment & Artifact :\r\n";
		foreach($aane as $aan){
			$txt.=$aan['cnum'].' '.$aan['cename']."\r\n";
		}
	}
	if(count($spel)){
		$txt.="\r\nSorcery & Instant :\r\n";
		foreach($spel as $spe){
			$txt.=$spe['cnum'].' '.$spe['cename']."\r\n";
		}
	}
	if(count($land)){
		$txt.="\r\nLand :\r\n";
		foreach($land as $lan){
			$txt.=$lan['cnum'].' '.$lan['cename']."\r\n";
		}
	}
	if(count($sideb)){
		$txt.="\r\nSideBoard :\r\n";
		foreach($sideb as $sb){
			$txt.=$sb['cnum'].' '.$sb['cename']."\r\n";
		}
	}
}else{
    if(count($crts)){
		$txt.="[生物]\r\n";
		foreach($crts as $crt){
			$ccrt=$db->ig2_want('cards','ename="'.$crt['cename'].'"');
			$txt.=$crt['cnum'].' '.$ccrt['name']."\r\n";
		}
	}
	if(count($plan)){
		$txt.="\r\n[鹏洛客]\r\n";
		foreach($plan as $pla){
			$cpla=$db->ig2_want('cards','ename="'.$pla['cename'].'"');
			$txt.=$pla['cnum'].' '.$cpla['name']."\r\n";
		}
	}
	if(count($aane)){
		$txt.="\r\n[结界和神器]\r\n";
		foreach($aane as $aan){
			$caan=$db->ig2_want('cards','ename="'.$aan['cename'].'"');
			$txt.=$aan['cnum'].' '.$caan['name']."\r\n";
		}
	}
	if(count($spel)){
		$txt.="\r\n[法术和瞬间]\r\n";
		foreach($spel as $spe){
			$cspe=$db->ig2_want('cards','ename="'.$spe['cename'].'"');
			$txt.=$spe['cnum'].' '.$cspe['name']."\r\n";
		}
	}
	if(count($land)){
		$txt.="\r\n[地]\r\n";
		foreach($land as $lan){
			$clan=$db->ig2_want('cards','ename="'.$lan['cename'].'"');
			$txt.=$lan['cnum'].' '.trim($clan['name'])."\r\n";
		}
	}
	if(count($sideb)){
		$txt.="\r\n[备牌]\r\n";
		foreach($sideb as $sb){
			$csb=$db->ig2_want('cards','ename="'.$sb['cename'].'"');
			$txt.=$sb['cnum'].' '.$csb['name']."\r\n";
		}
	}
}
echo $txt;
$myfile=fopen("tempdeck/[".$format['code']."] ".strtr($deck['ename'],'/','-')."-".date('YmdHis').".txt","w") or die("Unable to open file!");
fwrite($myfile,$txt);
fclose($myfile);
?>