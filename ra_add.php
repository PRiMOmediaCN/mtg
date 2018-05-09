<?php 
include_once "ra_global.php";
if($_POST['subcatesys']){
    $value=array(
	    'id'=>'',
		'name'=>$_POST['name'],
		'ename'=>str_replace('"',"&quot;",str_replace("'","&rsquo;",$_POST['ename'])),
		'pid'=>$_POST['pid'],
		'belong'=>$_POST['belong'],
		'note'=>$_POST['note']
	);
	$db->ig2_insert('cates',$value);
	tellgoto('OK','add_cates.php');
}
if($_POST['subgame']){
    $value=array(
	    'id'=>'',
		'name'=>$_POST['name'],
		'enname'=>str_replace('"',"&quot;",str_replace("'","&rsquo;",$_POST['enname'])),
		'abbr'=>$_POST['abbr'],
		'mime'=>$_POST['mime']
	);
	$db->ig2_insert('games',$value);
	tellgoto('OK','add_game.php');
}
if($_POST['submatch']){
	if($_POST['format']==1){
	    $t2file = fopen("t2.txt","r") or die("Unable to open file!");
		$t2_format=fgets($t2file);
		fclose($t2file);
	}
    $value=array(
	    'id'=>'',
		'game'=>$_POST['game'],
		'country'=>$_POST['country'],
		'city'=>$_POST['city'],
		'mdate'=>$_POST['mdate'],
		'mrange'=>$_POST['mrange'],
		'format'=>$_POST['format'],
		't2_format'=>$t2_format?$t2_format:NULL,
		'mime'=>$_POST['mime']
	);
	$db->ig2_insert('matchs',$value);
	tellgoto('OK','add_match.php');
}
if($_POST['subdeck']){
	if($_POST['noMatch']){
	    $type=2;
		$format=$db->ig2_want('formats','id='.$_POST['theFormat']);
	}else{
		$type=1;
		$match=$db->ig2_want('matchs','id='.$_POST['match']);
		$game=$db->ig2_want('games','id='.$match['game']);	
		$format=$db->ig2_want('formats','id='.$match['format']);
	}
	if($format['id']==1){
	    $t2file = fopen("t2.txt","r") or die("Unable to open file!");
		$t2_format=fgets($t2file);
		fclose($t2file);
	}else{
	    $t2_format=NULL;
	}
    $value=array(
	    'id'=>'',
		'type'=>$type,
		'uid'=>$_POST['uid'],
		'dmatch'=>$match['id'],
		'dgame'=>$game['id'],
		'format'=>$format['id'],
		't2_format'=>$t2_format,
		'name'=>$_POST['name'],
		'ename'=>str_replace('"',"&quot;",str_replace("'","&rsquo;",$_POST['ename'])),
		'dcate'=>$_POST['dcate'],
		'dname'=>$_POST['dname'],
		'dkwords'=>$_POST['dkwords'],
		'player'=>str_replace('"',"&quot;",str_replace("'","&rsquo;",$_POST['player'])),
		'req'=>$_POST['req'],
		'colors'=>NULL,
		'proportion'=>NULL,
		'curve'=>NULL
	);
	$did=$db->ig2_insert('decks',$value);
	
	$cardnum=$_POST['cardnum'];
	$ismain=$_POST['is_main'];
	$colors=array();
	$c_all=$c_w=$c_u=$c_b=$c_r=$c_g=$c_c=$c_l=0;
	$f_land=0; //地曲线数量
	$fcurve=array(); //其他牌法术力曲线
	foreach($_POST['card'] as $k=>$v){
		if(trim($v)){
			$card=$db->ig2_want('cards','id='.$v);
			
			//如果是地，则地的颜色数量和地的曲线数增加该牌的张数，
			if($card['cate']==3 || $card['cate']==121){
				$c_l+=$cardnum[$k];
				$c_all+=$cardnum[$k];
				$f_land+=$cardnum[$k];
			
			//如果不是地，则计算其颜色所属情况
			}else{
			
				//如果当前遍历的卡牌颜色未进入到数组中则进入数组
				foreach(explode(',',$card['color']) as $color){
					if(!in_array($color,$colors) && trim($color)) array_push($colors,$color);
					
					//判断各种颜色出现的次数
					switch($color){
						case 'w' : $c_w+=$cardnum[$k];break;
						case 'u' : $c_u+=$cardnum[$k];break;
						case 'b' : $c_b+=$cardnum[$k];break;
						case 'r' : $c_r+=$cardnum[$k];break;
						case 'g' : $c_g+=$cardnum[$k];break;
						case 'c' : $c_c+=$cardnum[$k];break;
						default  : $c_c+=$cardnum[$k];break;
					}
					
					//颜色总数
					$c_all+=$cardnum[$k];
				}
				
				for($i=0;$i<=15;$i++){
				    if($card['costs']==$i) $fcurve['f_'.$i]+=$cardnum[$k];
				}
			}
			$proportion=$c_all.','.$c_w.','.$c_u.','.$c_b.','.$c_r.','.$c_g.','.$c_c.','.$c_l;

			//法术力曲线
			$curve_arr=array('land,'.$f_land);
			foreach($fcurve as $m=>$n){
			    array_push($curve_arr,$m.','.$n);
			}
			$curve=implode('|',$curve_arr);
			
			
			
			//卡牌类别：1生物，2鹏洛客，3神器和结界，4法术和瞬间，5地，6其他
			if(in_array(4,explode(',',$card['cate']))){
			    $ccate=1;
			}else if(in_array(5,explode(',',$card['cate']))){
			    $ccate=2;
			}else if(in_array(3,explode(',',$card['cate'])) || in_array(121,explode(',',$card['cate']))){
			    $ccate=5;
			}else if(in_array(1,explode(',',$card['cate'])) || in_array(2,explode(',',$card['cate']))){
			    $ccate=3;
			}else if(in_array(6,explode(',',$card['cate'])) || in_array(7,explode(',',$card['cate']))){
			    $ccate=4;
			}else{
			    $ccate=6;
			}
			$value_card=array(
				'id'=>'',
				'did'=>$did,
				'cename'=>$card['ename'],
				'ccate'=>$ccate,
				'ccosts'=>$card['costs'],
				'cnum'=>$cardnum[$k],
				'is_main'=>$ismain[$k]
			);
			$db->ig2_insert('deck_list',$value_card);
		}
	}
	$db->ig2_update('decks',array('colors'=>implode(',',$colors),'proportion'=>$proportion,'curve'=>$curve),'id='.$did);
	tellgoto('OK','add_deck.php');
}

if($_POST['submydeck']){
	if($_POST['format']==1){
	    $t2file = fopen("t2.txt","r") or die("Unable to open file!");
		$t2_format=fgets($t2file);
		fclose($t2file);
	}else{
	    $t2_format=NULL;
	}
    $value=array(
	    'id'=>'',
		'uid'=>$_POST['vo'],
		'format'=>$_POST['format'],
		't2_format'=>$t2_format,
		'name'=>$_POST['name'],
		'ename'=>str_replace('"',"&quot;",str_replace("'","&rsquo;",$_POST['ename'])),
		'colors'=>NULL,
		'proportion'=>NULL,
		'curve'=>NULL
	);
	$did=$db->ig2_insert('my_decks',$value);
	
	$cardnum=$_POST['cardnum'];
	$ismain=$_POST['is_main'];
	$colors=array();
	$c_all=$c_w=$c_u=$c_b=$c_r=$c_g=$c_c=$c_l=0;
	$f_land=0; //地曲线数量
	$fcurve=array(); //其他牌法术力曲线
	foreach($_POST['card'] as $k=>$v){
		if(trim($v)){
			$card=$db->ig2_want('cards','id='.$v);
			
			//如果是地，则地的颜色数量和地的曲线数增加该牌的张数，
			if($card['cate']==3 || $card['cate']==121){
				$c_l+=$cardnum[$k];
				$c_all+=$cardnum[$k];
				$f_land+=$cardnum[$k];
			
			//如果不是地，则计算其颜色所属情况
			}else{
			
				//如果当前遍历的卡牌颜色未进入到数组中则进入数组
				foreach(explode(',',$card['color']) as $color){
					if(!in_array($color,$colors) && trim($color)) array_push($colors,$color);
					
					//判断各种颜色出现的次数
					switch($color){
						case 'w' : $c_w+=$cardnum[$k];break;
						case 'u' : $c_u+=$cardnum[$k];break;
						case 'b' : $c_b+=$cardnum[$k];break;
						case 'r' : $c_r+=$cardnum[$k];break;
						case 'g' : $c_g+=$cardnum[$k];break;
						case 'c' : $c_c+=$cardnum[$k];break;
						default  : $c_c+=$cardnum[$k];break;
					}
					
					//颜色总数
					$c_all+=$cardnum[$k];
				}
				
				for($i=0;$i<=15;$i++){
				    if($card['costs']==$i) $fcurve['f_'.$i]+=$cardnum[$k];
				}
			}
			$proportion=$c_all.','.$c_w.','.$c_u.','.$c_b.','.$c_r.','.$c_g.','.$c_c.','.$c_l;

			//法术力曲线
			$curve_arr=array('land,'.$f_land);
			foreach($fcurve as $m=>$n){
			    array_push($curve_arr,$m.','.$n);
			}
			$curve=implode('|',$curve_arr);
			
			
			
			//卡牌类别：1生物，2鹏洛客，3神器和结界，4法术和瞬间，5地，6其他
			if(in_array(4,explode(',',$card['cate']))){
			    $ccate=1;
			}else if(in_array(5,explode(',',$card['cate']))){
			    $ccate=2;
			}else if(in_array(3,explode(',',$card['cate'])) || in_array(121,explode(',',$card['cate']))){
			    $ccate=5;
			}else if(in_array(1,explode(',',$card['cate'])) || in_array(2,explode(',',$card['cate']))){
			    $ccate=3;
			}else if(in_array(6,explode(',',$card['cate'])) || in_array(7,explode(',',$card['cate']))){
			    $ccate=4;
			}else{
			    $ccate=6;
			}
			$value_card=array(
				'id'=>'',
				'did'=>$did,
				'cid'=>$v,
				'ccate'=>$ccate,
				'ccosts'=>$card['costs'],
				'cnum'=>$cardnum[$k],
				'is_main'=>$ismain[$k]
			);
			$db->ig2_insert('my_deck_list',$value_card);
		}
	}
	$db->ig2_update('my_decks',array('colors'=>implode(',',$colors),'proportion'=>$proportion,'curve'=>$curve),'id='.$did);
	tellgoto('OK','my_decks.php');
}



if($_POST['subcrtcate']){
    $value=array(
	    'id'=>'',
		'name'=>$_POST['name'],
		'ename'=>$_POST['ename'],
		'type'=>$_POST['type'],
		'note'=>$_POST['note']
	);
	$db->ig2_insert('crtcates',$value);
	tellgoto('OK','add_crtcates.php');
}

if($_POST['subset']){
    $value=array(
	    'id'=>'',
		'name'=>$_POST['name'],
		'ename'=>str_replace('"',"&quot;",str_replace("'","&rsquo;",$_POST['ename'])),
		'abbr'=>$_POST['abbr'],
		'isroot'=>$_POST['isroot'],
		'belong'=>$_POST['belong'],
		'pid'=>$_POST['pid'],
		'total'=>$_POST['total'],
		'pub'=>$_POST['pub'],
		'note'=>$_POST['note']
	);
	$db->ig2_insert('sets',$value);
	tellgoto('OK','add_sets.php');
}

if($_POST['subkw']){
    $value=array(
	    'id'=>'',
		'name'=>$_POST['name'],
		'ename'=>str_replace("'","&rsquo;",$_POST['ename']),
		'type'=>$_POST['type'],
		'note'=>$_POST['note'],
		'enote'=>str_replace("'","&rsquo;",$_POST['enote']),
		'start'=>$_POST['sets']
	);
	$db->ig2_insert('keywords',$value);
	tellgoto('OK','add_keywords.php');
}

if($_POST['subculture']){
    $value=array(
	    'id'=>'',
		'name'=>$_POST['name'],
		'ename'=>str_replace("'","&rsquo;",$_POST['ename']),
		'type'=>$_POST['type'],
		'note'=>$_POST['note'],
		'enote'=>str_replace("'","&rsquo;",$_POST['enote'])
	);
	$db->ig2_insert('cultures',$value);
	tellgoto('OK','add_cultures.php');
}

if($_POST['subcd']){
    $value=array(
	    'id'=>'',
		'name'=>$_POST['name'],
		'ename'=>str_replace("'","&rsquo;",$_POST['ename']),
		'side'=>$_POST['side'],
		'sets'=>$_POST['sets'],
		'legendary'=>$_POST['legendary'],
		'prefix'=>$_POST['prefix'],
		'cate'=>is_array($_POST['cate'])?implode(',',$_POST['cate']):$_POST['cate'],
		'subcate'=>$_POST['subcate'],
		'crtcate'=>$_POST['crtcate'],
		'cost'=>$_POST['cost'],
		'costs'=>$_POST['costs'],
		'color'=>$_POST['color'],
		'rarity'=>$_POST['rarity'],
		'power'=>$_POST['power'],
		'toughness'=>$_POST['toughness'],
		'loyalty'=>$_POST['loyalty'],
		'keywords'=>$_POST['currentk'],
		'intext'=>$_POST['intext'],
		'eintext'=>str_replace("'","&rsquo;",$_POST['eintext']),
		'flavor'=>$_POST['flavor'],
		'eflavor'=>str_replace("'","&rsquo;",$_POST['eflavor']),
		'serial'=>$_POST['serial'],
		'painter'=>str_replace("'","&rsquo;",$_POST['painter']),
		'note'=>$_POST['note'],
		'pdate'=>date('Y-m-d')
	);
	$id=$db->ig2_insert('cards',$value);
	if($id)	tellgoto('OK','card.php?id='.$id);
	else break;
}

if($_POST['subru']){
    $value=array(
	    'id'=>'',
		'serial'=>$_POST['serial'],
		'code'=>$_POST['code'],
		'content'=>$_POST['content'],
		'econtent'=>str_replace("'","&rsquo;",$_POST['econtent']),
		'links'=>$_POST['links'],
		'keywords'=>$_POST['keywords']
	);
	$db->ig2_insert('rules',$value);
	tellgoto('OK','add_rules.php');
}
if($_POST['subblog']){
	if(in_array('1',$_POST['formats'])){
	    $t2file = fopen("t2.txt","r") or die("Unable to open file!");
		$t2_formats=fgets($t2file);
		fclose($t2file);
	}else{
	    $t2_formats=NULL;
	}
	if($_FILES['blogface']['tmp_name']){
		$suffix=pathinfo($_FILES['blogface']['name'],PATHINFO_EXTENSION);//获取文件后缀名
		$face=date('YmdHis').rand(1000,9999).'.'.$suffix;
		move_uploaded_file($_FILES['blogface']['tmp_name'],'blog_face/'.$face);
	}else{
		//print_r($_FILES);
		//exit();
	}
    $value=array(
	    'id'=>'',
		'btit'=>$_POST['btit'],
		'face'=>$face,
		'bbody'=>str_replace("'","&rsquo;",$_POST['bbody']),
		'auid'=>$volunteer['id'],
		'cid'=>$_POST['cid'],
		'formats'=>implode(',',$_POST['formats']),
		't2_formats'=>$t2_formats,
		'pdate'=>date('Y-m-d H:i:s'),
		'status'=>1,
		'reprint'=>trim($_POST['reprint'])
	);
	$db->ig2_insert('blogs',$value);
	tellgoto('OK','add_blog.php');
}



if($_GET['t2clear']){
    $t2file = fopen("t2.txt","r") or die("Unable to open file!");
	$t2_format=fgets($t2file);
	fclose($t2file);
	
	foreach($db->ig2_select('decks','format=1') as $t2){
		if($t2['t2_format']!=$t2_format) $db->ig2_update('decks',array('format'=>7),'id='.$t2['id']);
	}
	tellgoto('OK','add_create.php');
}
/*if($_GET['updateBanned']){
    $banned=array(
		"Aetherworks Marvel|Smuggler's Copter|Felidar Guardian|Attune with Aether|Rogue Refiner|Rampaging Ferocidon|Ramunap Ruins",
		"Ancient Den|Birthing Pod|Blazing Shoal|Bloodbraid Elf|Chrome Mox|Cloudpost|Dark Depths|Deathrite Shaman|Dig Through Time|Dread Return|Eye of Ugin|Gitaxian Probe|Glimpse of Nature|Golgari Grave-Troll|Great Furnace|Green Sun's Zenith|Hypergenesis|Jace, the Mind Sculptor|Mental Misstep|Ponder|Preordain|Punishing Fire|Rite of Flame|Seat of the Synod|Second Sunrise|Seething Song|Sensei's Divining Top|Skullclamp|Splinter Twin|Stoneforge Mystic|Summer Bloom|Treasure Cruise|Tree of Tales|Umezawa's Jitte|Vault of Whispers",
		"Ancestral Recall|Balance|Bazaar of Baghdad|Black Lotus|Channel|Chaos Orb|Demonic Consultation|Demonic Tutor|Dig Through Time|Earthcraft|Falling Star|Fastbond|Flash|Frantic Search|Goblin Recruiter|Gush|Hermit Druid|Imperial Seal|Library of Alexandria|Mana Crypt|Mana Drain|Mana Vault|Memory Jar|Mental Misstep|Mind Twist|Mind’s Desire|Mishra’s Workshop|Mox Emerald|Mox Jet|Mox Pearl|Mox Ruby|Mox Sapphire|Mystical Tutor|Necropotence|Oath of Druids|Sensei's Divining Top|Shahrazad|Skullclamp|Sol Ring|Strip Mine|Survival of the Fittest|Time Vault|Time Walk|Timetwister|Tinker|Tolarian Academy|Treasure Cruise|Vampiric Tutor|Wheel of Fortune|Windfall|Yawgmoth's Bargain|Yawgmoth's Will",
		"Chaos Orb|Falling Star|Shahrazad",
		"Ancestral Recall|Balance|Black Lotus|Brainstorm|Chalice of the Void|Channel|Demonic Consultation|Demonic Tutor|Dig Through Time|Fastbond|Flash|Gitaxian Probe|Gush|Imperial Seal|Library of Alexandria|Lion's Eye Diamond|Lodestone Golem|Lotus Petal|Mana Crypt|Mana Vault|Memory Jar|Merchant Scroll|Mind's Desire|Monastery Mentor|Mox Emerald|Mox Jet|Mox Pearl|Mox Ruby|Mox Sapphire|Mystical Tutor|Necropotence|Ponder|Sol Ring|Strip Mine|Thorn of Amethyst|Time Vault|Time Walk|Timetwister|Tinker|Tolarian Academy|Treasure Cruise|Trinisphere|Vampiric Tutor|Wheel of Fortune|Windfall|Yawgmoth's Will",
		"Ancestral Recall|Balance|Biorhythm|Black Lotus|Braids, Cabal Minion|Chaos Orb|Coalition Victory|Channel|Emrakul, the Aeons Torn|Erayo, Soratami Ascendant|Falling Star|Fastbond|Gifts Ungiven|Griselbrand|Karakas|Leovold, Emissary of Trest|Library of Alexandria|Limited Resources|Mox Emerald|Mox Jet|Ashnod's Coupon|Double Cross|Double Deal|Double Dip|Double Play|Double Take|Enter the Dungeon|Mox Pearl|Mox Ruby|Mox Sapphire|Painter's Servant|Panoptic Mirror|Primeval Titan|Prophet of Kruphix|Recurring Nightmare|Rofellos, Llanowar Emissary|Shahrazad|Sundering Titan|Sway of the Stars|Sylvan Primordial|Time Vault|Time Walk|Tinker|Tolarian Academy|Trade Secrets|Upheaval|Worldfire|Yawgmoth's Bargain|Magical Hacker|Mox Lotus|Once More With Feeling|R&Ds Secret Lair|Richard Garfield|Staying Power|Time Machine");
	for($i=0;$i<=5;$i++){
		foreach(explode('|',$banned[$i]) as $b){
			$db->ig2_insert('banneds',array('id'=>'','ename'=>str_replace("'","&rsquo;",$b),'kinds'=>$i+1));
		}
	}
}*/
if($_GET['delTempDeck']){
	foreach($db->ig2_select('decks','name like "temp%"') as $list){
		$db->ig2_delete('decks','id='.$list['id']);
		foreach($db->ig2_select('deck_list','did='.$list['id']) as $decklist){
		    $db->ig2_delete('deck_list','id='.$decklist['id']);
		}
	}
	tellgoto('OK','add_create.php');
}
if($_GET['create_tb_voucher']){
	switch($_GET['vname']){
		case 1 : $vname='牌套';break;
		case 2 : $vname='牌垫';break;
		case 3 : $vname='马克杯';break;
		case 4 : $vname='250g铜版纸不覆膜';break;
		case 5 : $vname='250g白卡纸不覆膜';break;
		case 6 : $vname='250g铜版纸覆膜';break;
		case 7 : $vname='250g白卡纸覆膜';break;
	}
	$start=1;
    while($start<=9){
		$code='';
		for($vj=1;$vj<=4;$vj++){
			$arr1=array('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','2','3','4','5','6','7','8','9');
			$rand=rand(0,31);
			$code.=$arr1[$rand];
		}
	    $value=array(
		    'id'=>'',
			'code'=>$code,
			'name'=>$vname,
			'price'=>$_GET['vprice'],
			'tname'=>NULL,
			'ttime'=>NULL
		);
		$id=$db->ig2_insert('taobao_voucher',$value);
		$start+=($id?1:0);
		//优惠码：
		//$voucher_code=$code;
		//第一句话：
		//$v_str_1='优惠项目：'.$vname;
		//第二句话：
		//$v_str_2='抵用金额：<font size="52">'.$_GET['vprice'].'</font> 元';
		//二维码地址：
		//$img_qcode='images/tb_qcode/'.$_GET['vname'].'.jpg';
	}
	$im = @imagecreatetruecolor(2480, 3508)
    or die('Cannot Initialize new GD image stream');
    $white=imagecolorallocate($im, 255, 255, 255);
    imagefill($im, 0, 0, $white);
    $tvs=$db->ig2_select("taobao_voucher",'1 order by id desc limit 9');
    $font = 'file/msyh.ttc';
    $qcode_file='images/tb_qcode/'.$_GET['vname'].'.png';
    $qcode_file=imagecreatefrompng($qcode_file);

    $y=-4;
    for($i=0;$i<3;$i++){
        $y+=114;
        $x=12;
        for($j=0;$j<3;$j++) {
            $background=imagecreatefromjpeg("file/tv_background.jpg");
            $red = imagecolorallocate($background, 200, 20, 20);
            $grey = imagecolorallocate($background, 33, 33, 33);
            $x+=91;
//            $filename=$films[$p*9+$i*3+$j][0];
            $tv=$tvs[$p*9+$i*3+$j];
            $code=$tv['code'];
            $name="优惠项目：".$tv['name'];
            $price="抵用金额：".$tv['price']."元";
            $size=getimagesize("file/tv_background.jpg");
            $fontsize=80;
            $box=imagettfbbox ( $fontsize , 0 , $font , $code );
            $fontx=$box[2]-$box[0];
            $fontx=($size[0]-$fontx)/2;
            $fontx-=$box[0];
            $fonty=$box[1]-$box[7];
            $fonty=(120-$fonty)/2;
            $fonty=120-$fonty;
            $fonty-=$box[1];
            $fonty+=168;
            imagettftext($background, $fontsize, 0, $fontx, $fonty, $red, $font, $code);

            $fontsize=24;
            $box=imagettfbbox ( $fontsize , 0 , $font , $name );
            $fontx=$box[2]-$box[0];
            $fontx=($size[0]-$fontx)/2;
            $fontx-=$box[0];
            $fonty=$box[1]-$box[7];
            $fonty=(30-$fonty)/2;
            $fonty=30-$fonty;
            $fonty-=$box[1];
            $fonty+=309;
            imagettftext($background, $fontsize, 0, $fontx, $fonty, $grey, $font, $name);

            $fontsize=30;
            $box=imagettfbbox ( $fontsize , 0 , $font , $price );
            $fontx=$box[2]-$box[0];
            $fontx=($size[0]-$fontx)/2;
            $fontx-=$box[0];
            $fonty=$box[1]-$box[7];
            $fonty=(49-$fonty)/2;
            $fonty=49-$fonty;
            $fonty-=$box[1];
            $fonty+=358;
            imagettftext($background, $fontsize, 0, $fontx, $fonty, $grey, $font, $price);

            imagecopyresized($background, $qcode_file, 211, 433, 0, 0, 280, 280, 300, 300);
//            var_dump($code);
//            var_dump($name);
//            var_dump($price);
//            var_dump($qcode_file);
//            $source= imagecreatefromjpeg($filename);
            imagecopyresized($im, $background, $x, $y, 0, 0, 697, 980, $size[0], $size[1]);
            $x+=697;
        }
        $y+=980;
    }
    header('Content-Type: image/jpeg');
    imagejpeg($im);
//    var_dump($tv);
//	tellgoto('OK','add_create.php');
}

if($_POST['writeoff_tb_voucher']){
	$db->ig2_update('taobao_voucher',array('tname'=>$_POST['tbname'],'ttime'=>date('Y-m-d H:i:s')),'code="'.$_POST['vcoded'].'"');
	tellgoto('OK','add_create.php');
}
?>