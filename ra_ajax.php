<?php include_once "ra_global.php";
if($_POST['action']){
	switch($_POST['action']){
		case 'getLoginStatus' : 
		if($_SESSION['aid']==''){?>
			<a href="letsgo.php">登陆</a>
			<a href="comein.php">注册</a>
			<?php }else{?>
			<a href="my.php"><?php echo $vo['voname']?></a>
			<a href="letsgo.php?logout=1">退出</a>
			<?php 
		}
		break;
		case 'getDecklistMore':
		$where=1;
		if($_POST['formatId'] && $_POST['formatId']!='undefine') $where.=' and format='.$_POST['formatId'];
		if($_POST['searchName'] && $_POST['searchName']!='undefine') $where.=' and name like "%'.$_POST['searchName'].'%"';
		if($_POST['otherWhere'] && $_POST['otherWhere']!='undefine'){
		    $ow=explode(',',$_POST['otherWhere']);
			
			$where_set_1=0;
			$where.=' and ( id<0 ';
			if(in_array('快攻',$ow)){ $where.=' or dcate="快攻" ';$where_set_1=1;}
			if(in_array('控制',$ow)){ $where.=' or dcate="控制" ';$where_set_1=1;}
			if(in_array('科技',$ow)){ $where.=' or dcate="科技" ';$where_set_1=1;}
			if(in_array('中速',$ow)){ $where.=' or dcate="中速" ';$where_set_1=1;}
			if(in_array('猛袭',$ow)){ $where.=' or dcate="猛袭" ';$where_set_1=1;}
			if($where_set_1==0) $where.=' or id>0';
			//else echo 'where_set_1='.$where_set_1.'<br>';
			$where.=' ) ';
			
			if(in_array('八强卡组',$ow)) $where.=' and req>0 and req<=8 ';
			if(in_array('思路卡组',$ow)) $where.=' and dmatch = 0 ';
			
			$where_set_2=0;
			$where.=' and ( id<0 ';
			if(in_array('共鸣',$ow)){ $where.=' or dkwords like "%共鸣%" ';$where_set_2=1;}
			if(in_array('风暴',$ow)){ $where.=' or dkwords like "%风暴%" ';$where_set_2=1;}
			if(in_array('死亡阴影',$ow)){ $where.=' or dkwords like "%死亡阴影%" ';$where_set_2=1;}
			if(in_array('军伍',$ow)){ $where.=' or dkwords like "%军伍%" ';$where_set_2=1;}
			if(in_array('杰斯凯',$ow)){ $where.=' or dkwords like "%杰斯凯%" ';$where_set_2=1;}
			if($where_set_2==0) $where.=' or id>0';
			//else echo 'where_set_2='.$where_set_2.'<br>';
			$where.=' ) ';

			
		}
		$where.=' order by id desc limit '.(12*$_POST['deckPage']).',12';
		//echo $where;
		/*break;
		default:*/
		$getMoreDeckThese=$db->ig2_select('decks',$where);
		if($getMoreDeckThese){
			foreach($getMoreDeckThese as $list){
				$firstCard=$db->ig2_want('deck_list','did='.$list['id'].' order by rand() limit 1');
				$thisCard=$db->ig2_want('cards','ename="'.$firstCard['cename'].'"');
				$side=$thisCard['side']?($thisCard['side']==1?'a':'b'):'';
				$thisSet=$db->ig2_want('sets','id='.$thisCard['sets']);
				$format=$db->ig2_want('formats','id='.$list['format']);
				$match='';
				if($list['dmatch']){
					$match=$db->ig2_want('matchs','id='.$list['dmatch']);
					$game=$db->ig2_want('games','id='.$match['game']);
				}else{
					$uPlayer=$db->ig2_want('volunteer','id='.$list['uid']);
				}
				?>
				<li><div class="blogface"><a href="deck_view.php?did=<?php echo $list['id']?>" target="_blank"><img src="file/<?php echo $thisSet['abbr'].'.e/'.$thisCard['serial'].$side.'.jpg'?>" /></a></div>
					<div class="blogtit"><?php echo '[ <strong>'.$format['code'].'</strong> ] <a href="deck_view.php?did='.$list['id'].'">'.$list['name'].'</a>'?></div>
					<div class="blogsubtit"><?php echo $list['ename']?></div>
					<div class="blogintro"><?php echo $match?('<a href="match.php?id='.$match['id'].'" target="_blank">'.$match['city'].' '.$game['abbr'].' '.date('Y',strtotime($match['mdate'])).'</a><br>'.$list['player']):('网站录入<br>'.$uPlayer['voname'])?></div>
                    <?php if($list['format']==7){?>
                    <div class="blogintro">
                        <?php 
                        foreach(explode(',',$list['t2_format']) as $block){
                            $thisSets=$db->ig2_want('sets','id='.$block);
                            ?>
                            <a href="sets_<?php echo $thisSets['abbr']?>.html" target="_blank"><?php echo $thisSets['abbr']?></a> 
                            <?php
                        }
                        ?>
                    </div>
                    <?php }?>
				</li>
				<?php 
			}
		}else{
		    echo 0;
		}
		break;
	}
}
if($_FILES['file']){
    if($_FILES['file']['tmp_name']){
		$suffix=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);//获取文件后缀名
		$face=date('YmdHis').rand(1000,9999).'.'.$suffix;
		move_uploaded_file($_FILES['file']['tmp_name'],'file_u/'.$face);
		echo $face;
	}else{
	    echo 'upload erroe';
	}
}

if($_FILES['decklist']){
    if($_FILES['decklist']['tmp_name']){
		$suffix=pathinfo($_FILES['decklist']['name'],PATHINFO_EXTENSION);//获取文件后缀名
		$deckfile=date('YmdHis').rand(1000,9999).'.'.$suffix;
		move_uploaded_file($_FILES['decklist']['tmp_name'],'deck/'.$deckfile);
		$f=file('deck/'.$deckfile);
		
		$is_main=1;//是否是主牌
		foreach($f as $k=>$v){
			$n=substr($v,0,2)>10?substr($v,0,2):substr($v,0,1);
			$c=str_replace("'","&rsquo;",substr($v,2,strlen($v)));
			$card=$db->ig2_want('cards','ename="'.trim($c).'" order by id desc');
			if(trim($n) && trim($v)){
				echo '<li><label style="width:80%;">';
				if($card) echo '<a href="card.php?id='.$card['id'].'" target="_blank">'.$card['name'].'</a> - ';
				else echo '<font color="red">未找到该牌</font>：';
				echo $c.' '.($is_main?'':' <strong>[备]</strong>');
				echo '<input name="cardnum[]" value="'.$n.'" type="hidden" />
					  <input name="card[]" value="'.$card['id'].'" type="hidden" />
					  <input name="is_main[]" value="'.$is_main.'" type="hidden" />
					  </label><label style="width:20%;">'.$n.'</label></li>';
			}else{
				$is_main=0;
			}
		}
	}else{
	    echo 'upload error';
	}
	fclose($f);
	@unlink('deck/'.$deckfile);
}

if($_GET['blog_card_name']){
	foreach($db->ig2_select('cards','name like "%'.$_GET['blog_card_name'].'%"') as $cardname){
		$abbr=$db->ig2_want('sets','id='.$cardname['sets']);
	    echo '<li onClick="clickcardname(\'file/'.$abbr['abbr'].'/'.$cardname['serial'].'.jpg\',\''.$cardname['name'].'\')">'.$cardname['name'].'</li>';
	}
}

if($_GET['subset']){
	?>
	<select name="sets" onchange="getsetcounter(this.value)">
	<?php foreach($db->ig2_select('sets','isroot=1 and belong='.$_GET['subset'].' order by pub desc') as $rset){?>
		<option value="<?php echo $rset['id'] ?>"> - <?php echo $rset['name'] ?> (<?php echo substr($rset['pub'],0,4) ?>)</option>
		<?php foreach($db->ig2_select('sets','pid='.$rset['id']) as $sset){?>
		<option value="<?php echo $sset['id'] ?>">&nbsp;&nbsp;<?php echo $sset['name'] ?></option>
		<?php }?>
	<?php }?>
	</select>
	<?php
}

if($_GET['getcate']){
	foreach($db->ig2_select('cates','belong='.$_GET['getcate'].' and pid <> 5') as $cate){?>
    <label style="width:68px;"><input name="cate[]" type="checkbox" value="<?php echo $cate['id'] ?>" onchange="document.getElementById('catelist').value=document.getElementById('catelist').value+','+this.value;getsubcate(document.getElementById('catelist').value);" /> <?php echo $cate['name'] ?></label>
    <?php 
	}
}

if($_GET['getsubcate']){
    $arr=array_count_values(explode(',',$_GET['getsubcate']));
	$list=array();
    foreach($arr as $k=>$v){ //k是ID，v是次数
	    if(($v%2)==1 && $k) $list[]=$k; 
	}
    ?>
    <li><label>子类：</label>
    <label style="width:100px;">
	<select name="subcate">
        <option value="">无</option>
		<?php foreach($db->ig2_select('cates',"find_in_set(pid,'".implode(',',$list)."')") as $subcate){?>
		<option value="<?php echo $subcate['id'] ?>"><?php echo $subcate['name'] ?></option>
		<?php }?>
	</select>
    </label>
    </li>
    
    <?php if(in_array('4',$list)){?>
    <li><label>生物类别：</label>
    <span id="addcreaturebar"><input name="crtcate" type="hidden" value="" /></span>
    <input name="" id="cnstr" type="text" value="" class="ipt" onblur="addcreature(this.value)" style="width:120px;" />
    </li>
    <li><label>生物攻防：</label><input name="power" type="text" value="" class="ipt short" /> / <input name="toughness" type="text" value="" class="ipt short" /></li>
	<?php 
	}
	if(in_array('5',$list)){?>
    <li><label>忠诚：</label><input name="loyalty" type="text" value="" class="ipt short" /></li>
	<?php 
	} 
}

if($_GET['setcounter']){
    $setcounter=$db->ig2_want('sets','id='.$_GET['setcounter']);
	echo $setcounter['total'];
}

if($_GET['addcreature']){
    $crtcates=array();
	foreach(explode('／',trim($_GET['addcreature'])) as $crtcate){
	    $crtname=$db->ig2_want('crtcates',"name='".$crtcate."'");
		if($crtname){
		    echo "<strong class='crtcate'>".$crtcate."</strong>&nbsp;";
			$crtcates[]=$crtname['id'];
		}
	}
	?>
    <input name="crtcate" type="hidden" value="<?php echo implode(',',$crtcates) ?>" />
    <?php
}

if($_GET['addkeys']){
    if($_GET['currentk']){
		foreach(explode(',',$_GET['currentk']) as $kid){
			$keys=$db->ig2_want('keywords','id='.$kid);
			if($kid!=0){
		?>
		<strong class="crtcate"><?php echo $keys['name'] ?></strong>
		<?php 
		    }
		}
		$keynow=$db->ig2_want('keywords','id='.$_GET['addkeys']);
		?>
        <strong class="crtcate"><?php echo $keynow['name'] ?></strong>
        <input name="currentk" id="currentk" type="hidden" value="<?php echo $_GET['currentk'],',',$_GET['addkeys'] ?>" />
        <?php
	}else{
	    $keynow=$db->ig2_want('keywords','id='.$_GET['addkeys']);
	    ?>
        <strong class="crtcate"><?php echo $keynow['name'] ?></strong>
        <input name="currentk" id="currentk" type="hidden" value="<?php echo $_GET['addkeys'] ?>" />
        <?php 
	}
	?>
    
    <?php
}

if($_POST['bannedFormatId']){
	switch($_POST['bannedFormatId']){
	    case 1 : $kinds=1;break;
		case 2 : $kinds=2;break;
		case 3 : $kinds=3;break;
		case 4 : $kinds=6;break;
		case 5 : $kinds=4;break;
	}
	$cardss=$db->ig2_select('banneds','kinds='.$kinds);
    if($cardss){
		echo '<li>共<strong> '.count($cardss).' </strong>张～</li>';
		foreach($cardss as $banList){
			$thiscard=$db->ig2_want('cards','ename="'.$banList['ename'].'"');
			if($thiscard){
				?>
				<li><a href="card.php?id=<?php echo $thiscard['id'] ?>" target="_blank"><?php echo $thiscard['name'] ?></a> - <?php echo $thiscard['ename'] ?></li>
				<?php
			}else{
				?>
				<li>未收录 - <?php echo $banList['ename'] ?></li>
				<?php
			}
		}
	}
}
if($_POST['restrictedFormatId']){
	$cardss=$db->ig2_select('banneds','kinds=5');
    if($cardss){
		echo '<li>共<strong> '.count($cardss).' </strong>张～</li>';
		foreach($cardss as $banList){
			$thiscard=$db->ig2_want('cards','ename="'.$banList['ename'].'"');
			?>
			<li><a href="card.php?id=<?php echo $thiscard['id'] ?>" target="_blank"><?php echo $thiscard['name'] ?></a> - <?php echo $thiscard['ename'] ?></li>
			<?php
		}
	}
}
if($_GET['getVoucherContent']){
    $vcontent=$db->ig2_want('taobao_voucher','code="'.$_GET['getVoucherContent'].'"');
	echo $vcontent['name'].'优惠'.$vcontent['price'].'元';
}
?>