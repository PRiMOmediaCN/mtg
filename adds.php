<?php 
include_once "ra_global.php";
include_once "class/simple_html_dom.php";
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');

define(OTHERSIDE,'4');  //设置的当前系列的“另一面”属于什么情况：2倒转，3右边，4背面
define(SETS,'120');      //版本ID
define(SETSABBR,'a25'); //版本缩写
define(FINDSTART,1);    //序号开始
define(FINDEND,100);     //序号结束

$flag='';
for($j=FINDSTART;$j<=FINDEND;$j++){
	
	ob_end_clean();
	$c_serial=$db->ig2_want('cards','sets="'.SETS.'" and serial='.$j.' and side=0');
	if($c_serial){
		echo 'stop:'.'sets="'.SETS.'" and serial='.$j.' and side=0';
		exit();
	}
	
	$url='http://magiccards.info/'.SETSABBR.'/cn/'.$j.'.html';
	
	//$url='http://magiccards.info/ogw/cn/1.html';
	$html=file_get_html($url);
	
	$h1=$html->find('h1',0)->plaintext;

	//如果无法获取该网页内的内容（则该页面为双面牌）
	if($h1=='Your query did not match any cards.'){
		if($flag=='a'){
			$url_b='http://magiccards.info/'.SETSABBR.'/cn/'.$j.'b.html';
		    $html=file_get_html($url_b);
			$side=OTHERSIDE;
			$flag='';
		}else{
			$url_a='http://magiccards.info/'.SETSABBR.'/cn/'.$j.'a.html';
		    $html=file_get_html($url_a);
			$side=1;
			$flag='a';
		}
	}else{
	    $side=0;
	}
	
	$name=$html->find('img',1);
	$name=$name->alt;  //中文牌名



	$url_arr=explode('/',$url); //通过url地址找到英文名称
	$aurl='/'.$url_arr[3].'/en/'.$url_arr[5];
	$ename=$html->find('a[href='.$aurl.']',0)->plaintext;


	//如果获取不到英文名称
	if(!$ename){
		$eurl='http://magiccards.info/'.SETSABBR.'/en/'.$j.($side?($side==1?'a':'b'):'').'.html';
	    $ehtml=file_get_html($eurl);
		$ename=$ehtml->find('img',1);
	    $ename=$ename->alt;  //英文牌名
	}
	
	
	
	$serial=$j;//substr($url_arr[5],0,strpos($url_arr[5],'.'));
	
	//$sidecode=substr($url,strrpos($url,'.')-1,1); //根据url判断是否属于双面牌
	//$side=is_numeric($sidecode)?'0':($sidecode=='a'?'1':OTHERSIDE);
	
	$sets=SETS;
		
	$pinfo_arr=explode(',',$html->find('p',0)->plaintext);
	if(preg_match('/传奇/',$pinfo_arr[0])) $legendary=1;
	if(preg_match('/生物/',$pinfo_arr[0]) || preg_match('/部族/',$pinfo_arr[0])) {
		
		//如果是生物或者部族，就把生物类别拆掉作为类别判断依据
		$crthead=explode('～',$pinfo_arr[0]);
		$catefetch=$crthead[0];
		
		//获取生物类别
		$crt_arr1=explode(' — ',trim($html->find('div[class=oo] span',0)->plaintext));
		
		//如果是部族则直接取字符串，否则取最后一个空格（区分攻防）前的字符串
		$crt_str=preg_match('/部族/',$pinfo_arr[0])?$crt_arr1[1]:substr($crt_arr1[1],0,strrpos($crt_arr1[1],' '));
		
		$crtcate_arr=array();
		foreach(explode(' ',$crt_str) as $crt_arr){
			$crtctid=$db->ig2_want('crtcates','ename="'.$crt_arr.'"');
			if($crtctid) $crtcate_arr[]=$crtctid['id'];
		}
		$crtcate=implode(',',$crtcate_arr);
		
		if(preg_match('/部族/',$pinfo_arr[0])){
			$prefix=114;//部族的类别ID
			$catefetch=$pinfo_arr[0];
		}else{
			//获得生物功防
			$pat1=explode(' ',$crt_arr1[1]);
			$pat2=explode('/',$pat1[count($pat1)-1]);
			$power=$pat2[0];
			$toughness=$pat2[1];
		}
	}else{
		//如果不是生物也没有前缀
		$catefetch=$pinfo_arr[0]; //本行文本都作为类别判断依据
		
		//如果是鹏洛客
		if(preg_match('/鹏洛客/',$pinfo_arr[0])){
			$planeswalker_arr1=explode('～',$pinfo_arr[0]);
			$planeswalker_arr2=explode(' ',$planeswalker_arr1[1]);
			$planeswalker_id=$db->ig2_want('cates','name="'.$planeswalker_arr2['0'].'"');
			$subcate=$planeswalker_id['id'];
			$loyalty=substr($planeswalker_arr2[2],0,1);
		}
	}

    if(preg_match('/雪境/',$pinfo_arr[0])) $prefix=119;

	
	//类别和子类别
	$cate_arr=array();
	$subcate_arr=array();
	foreach($db->ig2_select('cates','belong<3') as $cates){
		if($cates['pid']){
			if(preg_match('/'.$cates['name'].'/',$catefetch)) $subcate_arr[]=$cates['id'];
		}else{
			if(preg_match('/'.$cates['name'].'/',$catefetch)) $cate_arr[]=$cates['id'];
		}
	}
	
	$cate_arr=in_array(121,$cate_arr)?array(121):$cate_arr;
	$cate=implode(',',$cate_arr);
	$subcate=implode(',',$subcate_arr);
	
	
	//取法术力
	$costleft=strpos(trim($pinfo_arr[1]),'(');
	$costright=strpos(trim($pinfo_arr[1]),')');
	$cost=substr(trim($pinfo_arr[1]),0,$costleft-1);
	$costs=substr(trim($pinfo_arr[1]),$costleft+1,$costright-$costleft-1);
	
	//取颜色
	$color_arr=array();
	if(preg_match('/W/',$cost)) $color_arr[]='w';
	if(preg_match('/U/',$cost)) $color_arr[]='u';
	if(preg_match('/B/',$cost)) $color_arr[]='b';
	if(preg_match('/R/',$cost)) $color_arr[]='r';
	if(preg_match('/G/',$cost)) $color_arr[]='g';
	$color=count($color_arr)?implode(',',$color_arr):NULL;
	
	//获得稀有度
	foreach($html->find('b') as $b){
		if(preg_match('/\(Common\)/',$b->plaintext)) $rarity=1;
		else if(preg_match('/\(Uncommon\)/',$b->plaintext)) $rarity=2;
		else if(preg_match('/\(Rare\)/',$b->plaintext)) $rarity=3;
		else if(preg_match('/\(Mythic Rare\)/',$b->plaintext)) $rarity=4;
		else if(preg_match('/\(Special\)/',$b->plaintext)) $rarity=5;
		else if(preg_match('/\(Land\)/',$b->plaintext)) $rarity=0;
	}
	//$rarity=$rarity?$rarity:5;
	
	
	
	//内文描述和背景描述中文
	$intext=$html->find('p',1)->plaintext;
	$eintext=$html->find('p',2)->plaintext;
	$flavor=$html->find('p',3)->plaintext;
	$painter=substr($html->find('p',4)->plaintext,strpos(trim($html->find('p',4)->plaintext),'. ')+1);
	
	
	/*echo '=========<br>';
	echo $name.'<br>';
	echo $ename.'<br>';
	echo $side.'<br>';
	echo $sets.'<br>';
	echo $banned.'<br>';
	echo $restricted.'<br>';
	echo $legendary.'<br>';
	echo $cate.'<br>';
	echo 'subcate='.$subcate.'<br>';
	echo $crtcate.'<br>';
	echo $cost.'<br>';
	echo $costs.'<br>';
	echo $power.'<br>';
	echo $toughness.'<br>';
	echo 'loyalty='.$loyalty.'<br>';
	echo $color.'<br>';
	echo $rarity.'<br>';
	echo $intext.'<br>';
	echo $eintext.'<br>';
	echo $flavor.'<br>';
	echo $serial.'<br>';
	echo $painter.'<br>';
	echo '=========<br>';*/
	
	/*$i=1;
	foreach($html->find('p') as $a) {echo $a->plaintext.','.$i.'<br>';$i++;}
	*/
	
	
	if($url){
		$value=array(
			'id'=>'',
			'name'=>$name,
			'ename'=>str_replace("'","&rsquo;",$ename),
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
			'power'=>$power,
			'toughness'=>$toughness,
			'loyalty'=>$loyalty,
			
			'keywords'=>NULL,
			'intext'=>$intext,
			'eintext'=>str_replace("'","&rsquo;",$eintext),
			'flavor'=>$flavor,
			'eflavor'=>NULL,
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