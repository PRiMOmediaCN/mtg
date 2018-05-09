<?php 
include_once "ra_global.php";
include_once "class/simple_html_dom.php";
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');

define(OTHERSIDE,'4');  //设置的当前系列的“另一面”属于什么情况：2倒转，3右边，4背面
define(SETS,'123');      //版本ID
define(SETSABBR,'dom'); //版本缩写
define(FINDSTART,183);    //序号开始
define(FINDEND,280);     //序号结束

$flag='';
for($j=FINDSTART;$j<=FINDEND;$j++){
	
	ob_end_clean();
	$c_serial=$db->ig2_want('cards','sets="'.SETS.'" and serial='.$j.' and side=0');
	if($c_serial){
		echo 'stop:'.'sets='.SETS.' and serial='.$j.' and side=0 , card='.$c_serial['ename'].' , id='.$c_serial['id'].' , SETS='.SETS;
		exit();
	}
	
	$url='temp_yingdi.htm';
	$eurl='https://scryfall.com/card/'.SETSABBR.'/'.$j;
	$html=file_get_html($url);
	$ehtml=file_get_html($eurl);
	$side=0;
		
	//echo gettype($html);
	//exit();
	
	$name=$html->find('ul',0)->find('li[class=card fadeIn animated]',$j-1)->find('div[class=cname]',0)->plaintext;
	$temp_ename=str_replace("’","&rsquo;",$html->find('ul',0)->find('li[class=card fadeIn animated]',$j-1)->find('div[class=ename]',0)->plaintext);

	$ename=$ehtml->find('meta[property=og:title]',0)->content;
	
	if($temp_ename!=$ename){
		echo '$temp_ename='.$temp_ename.'<br>$ename='.$ename;
		//exit();
	}
	
	$serial=$j;
	$sets=SETS;
	
	//紧限牌
	$banned=NULL;
	$restricted=NULL;
	
	$pinfo_arr=$ehtml->find('p[class=card-text-type-line]',0)->plaintext;
	if(preg_match('/Legendary/',$pinfo_arr)) $legendary=1;
	if(preg_match('/Creature/',$pinfo_arr) || preg_match('/Tribal/',$pinfo_arr)) {
		
		//如果是生物或者部族，就把生物类别拆掉作为类别判断依据
		
		$crthead=explode(' — ',$pinfo_arr);
		
		$crtcate_arr=array();
		foreach(explode(' ',trim($crthead[1])) as $crt_arr){
			$crtctid=$db->ig2_want('crtcates','ename="'.$crt_arr.'"');
			if($crtctid) $crtcate_arr[]=$crtctid['id'];
			else{ 
				echo 'error, no crtCate:'.$crt_arr;
				exit();
			}
		}
		$crtcate=implode(',',$crtcate_arr);
		
		if(preg_match('/Tribal/',$pinfo_arr[0])){
			$prefix=114;//部族的类别ID
			$catefetch=$pinfo_arr[0];
		}else{
			//获得生物功防
			$pAndT=$ehtml->find('div[class=card-text-stats]',0)->plaintext;
			$pAndT_arr=explode('/',$pAndT);
			$power=$pAndT_arr[0];
			$toughness=$pAndT_arr[1];
		}
	}else{
		//如果不是生物也没有前缀，本行文本都作为类别判断依据
		
		//如果是鹏洛客
		if(preg_match('/Planeswalker/',$pinfo_arr)){
			$planeswalker_arr1=explode(' — ',$pinfo_arr);
			$planeswalker_id=$db->ig2_want('cates','ename="'.$planeswalker_arr1[1].'"');
			$subcate=$planeswalker_id['id'];
			$loyaltyTemp=$ehtml->find('div[class=card-text-stats]',0)->plaintext;
			$loyalty_arr=explode(':',$loyaltyTemp);
			$loyalty=trim($loyalty_arr[1]);
		}
	}

    if(preg_match('/Snow/',$pinfo_arr[0])) $prefix=119;

	
	//类别和子类别
	$cate_arr=array();
	$subcate_arr=array();
	foreach($db->ig2_select('cates','belong<3') as $cates){
		if($cates['pid']){
			if(preg_match('/'.$cates['ename'].'/',$pinfo_arr)) $subcate_arr[]=$cates['id'];
		}else{
			if(preg_match('/'.$cates['ename'].'/',$pinfo_arr)) $cate_arr[]=$cates['id'];
		}
	}
	
	$cate_arr=in_array(121,$cate_arr)?array(121):$cate_arr;
	$cate=implode(',',$cate_arr);
	$subcate=implode(',',$subcate_arr);
	
	
	//取法术力
	$cost_str=$ehtml->find('span[class=card-text-mana-cost]',0)->plaintext;
	$cost=preg_replace("/[\{\}]/","",$cost_str);
	
	//取法术力数量
	$cost_num=preg_replace("/[^\d]/","",$cost);
	$cost_right_str=preg_replace("/[\d]/","",trim($cost));
	$costs=$cost_num+strlen($cost_right_str);
	
	//取颜色
	$color_arr=array();
	if(preg_match('/W/',$cost)) $color_arr[]='w';
	if(preg_match('/U/',$cost)) $color_arr[]='u';
	if(preg_match('/B/',$cost)) $color_arr[]='b';
	if(preg_match('/R/',$cost)) $color_arr[]='r';
	if(preg_match('/G/',$cost)) $color_arr[]='g';
	$color=count($color_arr)?implode(',',$color_arr):NULL;

	//获得稀有度
	$rarity_str=$ehtml->find('span[class=prints-current-set-details]',0)->plaintext;
	if(preg_match('/Uncommon/',$rarity_str)) $rarity=2;
	else if(preg_match('/Common/',$rarity_str)) $rarity=1;
	else if(preg_match('/Mythic Rare/',$rarity_str)) $rarity=4;
	else if(preg_match('/Rare/',$rarity_str)) $rarity=3;
	else if(preg_match('/Special/',$rarity_str)) $rarity=5;
	else if(preg_match('/Land/',$rarity_str)) $rarity=0;
	//$rarity=$rarity?$rarity:5;
	
	
	
	//内文描述和背景描述中文
	$intext=$html->find('ul',0)->find('li[class=card fadeIn animated]',$j-1)->find('div[class=rule]',0)->plaintext;
	$flavor=NULL;
	$eintext=str_replace('</p>','',str_replace('<p>','',str_replace('</p><p>','<br>',$ehtml->find('div[class=card-text-oracle]',0)->plaintext)));
	$eintext=str_replace("'",'&rsquo;',$eintext);
	$eflavor=$ehtml->find('div[class=card-text-flavor]',0)->plaintext;
	$eflavor=str_replace("'",'&rsquo;',$eflavor);
	$painter=$ehtml->find('p[class=card-text-artist]',0)->find('a',0)->plaintext;
	
	
	/*echo '=========<br>';
	echo 'name='.$name.'<br>';
	echo 'ename='.$ename.'<br>';
	echo 'side='.$side.'<br>';
	echo 'sets='.$sets.'<br>';
	echo $banned.'<br>';
	echo $restricted.'<br>';
	echo 'legendary='.$legendary.'<br>';
	echo 'cate='.$cate.'<br>';
	echo 'subcate='.$subcate.'<br>';
	echo 'crtcate='.$crtcate.'<br>';
	echo 'cost='.$cost.'<br>';
	echo 'costs='.$costs.'<br>';
	echo 'power='.$power.'<br>';
	echo 'toughness='.$toughness.'<br>';
	echo 'loyalty='.$loyalty.'<br>';
	echo 'color='.$color.'<br>';
	echo 'rarity='.$rarity.'<br>';
	echo 'intext='.$intext.'<br>';
	echo 'eintext='.$eintext.'<br>';
	echo 'flavor='.$flavor.'<br>';
	echo 'eflavor='.$eflavor.'<br>';
	echo 'serial='.$serial.'<br>';
	echo 'painter='.$painter.'<br>';
	echo '=========<br>';
	
	exit();*/
	/*$i=1;
	foreach($html->find('p') as $a) {echo $a->plaintext.','.$i.'<br>';$i++;}
	*/
	
	
	if($url){
		$value=array(
			'id'=>'',
			'name'=>$name,
			'ename'=>str_replace("'","&rsquo;",str_replace("&#39","&rsquo",$ename)),
			'side'=>$side,
			'sets'=>$sets,
			'legendary'=>$legendary,
			'prefix'=>$prefix,
			'cate'=>$cate,
			'subcate'=>$subcate,
			'crtcate'=>$crtcate,
			'cost'=>$cost,
			'costs'=>$costs,
			'color'=>$color,
			'rarity'=>$rarity,
			'power'=>trim($power),
			'toughness'=>trim($toughness),
			'loyalty'=>$loyalty,
			
			'keywords'=>NULL,			
			'intext'=>$intext,
			'eintext'=>str_replace("'","&rsquo;",$eintext),
			'flavor'=>$flavor,
			'eflavor'=>str_replace("'","&rsquo;",$eflavor),
			'serial'=>$serial,
			'painter'=>str_replace("'","&rsquo;",$painter),
			'note'=>NULL,
			'pdate'=>date('Y-m-d')
		);
		$id=$db->ig2_insert('cards',$value);
		if($id) {
			echo $j.' done<br>';
		    ob_implicit_flush(1);
		}else{
			echo $j.' error<br>';
			exit();
		}
	}
	$html->clear();
	$subcate=NULL;
	$legendary=NULL;
	$loyalty=NULL;
	$crtcate=NULL;
	$power=NULL;
	$toughness=NULL;
	$prefix=NULL;
	$rarity=NULL;
	
	if($flag=='a') $j--;
}
echo 'end<br>';

?>