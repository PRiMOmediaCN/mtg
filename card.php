<?php 
include_once "ra_global.php";
if($_GET['id']){
    $card=$db->ig2_want('cards','id='.$_GET['id']);
	$set=$db->ig2_want('sets','id='.$card['sets']);
	$cardnext=$db->ig2_want('cards','`sets`='.$card['sets'].' and `serial`='.($card['serial']+1));
	$cardprev=$db->ig2_want('cards','`sets`='.$card['sets'].' and `serial`='.($card['serial']-1));
}else{
    tellgoto('您的访问有误。',$_SERVER['REQUEST_URI']);
}

$card_cn='file/'.$set['abbr']."/".$card['serial'].($card['side']?($card['side']==1?'a':'b'):'').'.jpg';
$card_cn_scan='file/'.$set['abbr'].".s/".$card['serial'].($card['side']?($card['side']==1?'a':'b'):'').'.jpg';
$card_en='file/'.$set['abbr'].".e/".$card['serial'].($card['side']?($card['side']==1?'a':'b'):'').'.jpg';
$card_cn=file_exists($card_cn)?$card_cn:(file_exists($card_cn_scan)?$card_cn_scan:$card_en);


$thisTitle=$card['name'].' - '.$card['ename'].' - 来自'.$set['name'].' - 爱基兔万智牌 - IG2';
$thisKeywords=$card['name'].' '.$card['ename'].' 万智牌 牌库 中文 百科 查牌';
$thisDescription=$card['name'].'卡牌介绍——来自爱基兔万智牌，万智牌中文数据百科网站。提供查牌、查套牌、百科和各种中文万智牌工具。';
?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $thisDescription?>">
<meta name="keywords" content="<?php echo $thisKeywords?>"> 
<title><?php echo $thisTitle?></title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
<script src="inc/jquery.js"></script>
<script type="text/javascript">
function createXMLHTTP() {
	var request;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer") {
		var arrVersions = ["Microsoft.XMLHttp", "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0", "MSXML2.XMLHttp","MSXML2.XMLHttp.5.0"];
		for (var i=0; i < arrVersions.length; i++)  {
			try {
				request = new ActiveXObject(arrVersions[i]); 
				return request;
			}catch(exception){}
		}
	}else{
		request = new XMLHttpRequest(); 
		return request;
	}
}
</script>
</head>
<body>
<?php include_once "topbar.php";?>
<div class="main">
<title><?php echo $card['name'].' - '.$card['ename'] ?> - iG2 - 爱基兔万智牌数据网站</title>
<div class="cardbar">
    <h1><?php echo $card['name'].'&nbsp;.&nbsp;'.$card['ename'] ?><span class="coast"><?php getCost($card['cost']);?></span></h1>
    <div class="cardpic">
        <dt style="width:312px;">
        <strong>牌面</strong>
        <span id="carden" onMouseOver="document.getElementById('thiscardpic').src='<?php echo $card_en?>';this.style.background='#9c0';document.getElementById('cardcn').style.background='#999';">En</span>
        <span style="background:#9c0;" id="cardcn" onMouseOver="document.getElementById('thiscardpic').src='<?php echo $card_cn?>';this.style.background='#9c0';document.getElementById('carden').style.background='#999';">中文</span>        
        </dt>
        <img id="thiscardpic" src="<?php echo $card_cn?>" width="312">
    </div>
    
    <div class="cardbody">
        <dt style="width:454px;">
        <strong>信息</strong>
        <span id="cardbodyen" onMouseOver="document.getElementById('thiscardbodyen').style.display='block';document.getElementById('thiscardbodycn').style.display='none';this.style.background='#9c0';document.getElementById('cardbodycn').style.background='#999';">En</span>
        <span style="background:#9c0;" id="cardbodycn" onMouseOver="document.getElementById('thiscardbodycn').style.display='block';document.getElementById('thiscardbodyen').style.display='none';this.style.background='#9c0';document.getElementById('cardbodyen').style.background='#999';">中文</span>        
        </dt>
        <ul id="thiscardbodycn">
            <li><label>基本属性：</label>
			<?php 
			echo $card['legendary']?"传奇":'';
			if($card['prefix']){
				$prefix=$db->ig2_want('cates','id='.$card['prefix']);
				echo $prefix['name'];
			}
			foreach(explode(',',$card['cate']) as $cate){
				$catename=$db->ig2_want('cates','id='.$cate);
				echo $catename['name'];
			}
			if($card['subcate']){
				$subcate_arr=array();
				foreach(explode(',',$card['subcate']) as $subcate){
					$subcate_name=$db->ig2_want('cates','id='.$subcate);
					$subcate_arr[]=$subcate_name['name'];
				}
				
				echo '～'.implode(' / ',$subcate_arr);
			}
			if(in_array('4',explode(',',$card['cate'])) || $card['prefix']){
				$crtcatename=array();
				foreach(explode(',',$card['crtcate']) as $crt){
					$crtcate=$db->ig2_want('crtcates','id='.$crt);
					$crtcatename[]=$crtcate['name'];
				}
				echo '～'.implode('&nbsp;/&nbsp;',$crtcatename);
			}		
			echo ($card['cate']==5?('('.$card['loyalty'].')'):'').(trim($card['cost'])!=''?('，'.$card['cost'].'('.$card['costs'].')'):'');
			?>
            </li>
            
            <?php if(in_array('4',explode(',',$card['cate']))){?>
            <li><label>生物攻防：</label><?php echo $card['power'].' / '.$card['toughness'] ?></li>
            <?php }?>
            <li><label>内文描述：</label>
                <label class="intext">
				<?php 
				$intext=$card['intext'];
				foreach(explode(',',$card['keywords']) as $keyword){
				    $keycn=$db->ig2_want('keywords','id='.$keyword);
				    $intext=str_replace(trim($keycn['name']),"<a href='#' onmouseover=\"document.getElementById('bar".$keyword."').style.display='block';\" onmouseout=\"document.getElementById('bar".$keyword."').style.display='none';\">".trim($keycn['name'])."<div id='bar".$keyword."' class='keybar'><strong>".$keycn['name']."</strong> - ".$keycn['ename']."<br>".$keycn['note']."<br><font color='#666'>".$keycn['enote']."</font></div></a>",$intext);
				}
				echo $intext;
				?>
                </label>
            </li>
            <li><label>背景描述：</label><label style="width:350px;"><em><?php echo trim($card['flavor'])?$card['flavor']:'-' ?></em></label></li>
            <li><label>赛制限制：</label>
			    <label style="width:360px;">
				<?php 
				$restricted=$db->ig2_want('banneds','ename="'.$card['ename'].'" and kinds=5');
				if($restricted){ 
					?>
                    <a href="formats.php?id=5">特选</a> ( T1 ) <br>
                	<?php 
				}else{
				    echo '-';
				}?>
                </label>
            </li>
            <li><label>赛制禁止：</label>
			    <label style="width:360px;">
				<?php 
				$banned=$db->ig2_select('banneds','ename="'.$card['ename'].'" and kinds <> 5');
				if(count($banned)>0){
				    foreach($banned as $ba){
						switch($ba['kinds']){
							case 1 : $fo=1;break;
							case 2 : $fo=2;break;
							case 3 : $fo=3;break;
							case 4 : $fo=5;break;
							case 6 : $fo=4;break;
						}
					    $bannedname=$db->ig2_want('formats','id='.$fo);
						?>
                    	<a href="formats.php?id=<?php echo $banned;?>"><?php echo $bannedname['name']?></a> ( <?php echo $bannedname['code']?> ) <br>
                		<?php 
				    }
				}else{
				    echo '-';
				}?>
                </label>
            </li>
            <li><label>规则详解：</label></li>
        </ul>
        <ul id="thiscardbodyen" style="display:none;">
            <li><label>Basic Info :</label>
			<?php 
			echo $card['legendary']?"Legendary ":'';
			if($card['prefix']){
				$prefix=$db->ig2_want('cates','id='.$card['prefix']);
				echo $prefix['ename'].'&nbsp;';
			}
			foreach(explode(',',$card['cate']) as $cate){
				$catename=$db->ig2_want('cates','id='.$cate);
				echo $catename['ename'].'&nbsp;';
			}
			if($card['subcate']){
				$subcate=$db->ig2_want('cates','id='.$card['subcate']);
				echo ' - '.$subcate['ename'];
			}
			if(in_array('4',explode(',',$card['cate'])) || $card['prefix']){
				$crtcatename=array();
				foreach(explode(',',$card['crtcate']) as $crt){
					$crtcate=$db->ig2_want('crtcates','id='.$crt);
					$crtcatename[]=$crtcate['ename'];
				}
				echo ' - '.implode('&nbsp;',$crtcatename);
			}
			echo ($card['cate']==5?('('.$card['loyalty'].')'):'').(trim($card['cost'])!=''?('，'.$card['cost'].'('.$card['costs'].')'):'');
			?>
            </li>
            
			<?php if(in_array('4',explode(',',$card['cate']))){?>
            <li><label>Offensive :</label><?php echo $card['power'].' / '.$card['toughness'] ?></li>
            <?php }?>
            
            <li><label>Rules Text :</label><label class="intext"><?php echo $card['eintext'];?></label></li>
            <li><label>Story Text :</label><label style="width:350px;"><em><?php echo trim($card['eflavor'])?$card['eflavor']:'-' ?></em></label></li>
            <li><label>Restricted :</label>
			    <label style="width:360px;">
				<?php 
				if($card['restricted']){
				    foreach(explode(',',$card['restricted']) as $restricted){
					    $restname=$db->ig2_want('formats','id='.$restricted);
				?>
                    <?php echo $restname['ename'].' ( '.$restname['code'].($restname['code']=='EDH'?' , Banned as a Commander':'').' ) ' ?><br>
                <?php 
				    }
				}else{
				    echo '-';
				}?>
                </label>
            </li>
            <li><label>Banned :</label>
			    <label style="width:360px;">
				<?php 
				if($card['banned']){
				    foreach(explode(',',$card['banned']) as $banned){
					    $bannedname=$db->ig2_want('formats','id='.$banned);
				?>
                    <?php echo $bannedname['ename'].' ( '.$bannedname['code'].' ) ' ?><br>
                <?php 
				    }
				}else{
				    echo '-';
				}?>
                </label>
            </li>

            <li><label>Rules Help :</label></li>            
        </ul>
    </div>
    <div class="cardright">
        <ul>
            <dt style="width:285px; padding-top:14px;">
                <span><?php echo !$cardprev?'第一张':"<a href='card_".$cardprev['id'].".html'>上一张</a>"?></span>
                <span style="margin-left:65px;">#<?php echo $card['serial'].($card['side']=='0'?'':($card['side']==1?'a':'b')).'<span class="gray"> / '.$set['total'].'</span>' ?></span>
                <span class="fr"><?php echo !$cardnext?'最后一张':"<a href='card_".$cardnext['id'].".html'>下一张</a>"?></span>
            </dt>
            <?php if($card['side']>0){
			$sidecard=$db->ig2_want('cards','`sets`='.$card['sets'].' and `serial`='.$card['serial'].' and side <> '.$card['side']);
			?>
            <li><?php 
			switch($sidecard['side']==1?$card['side']:$sidecard['side']){
			    case 2 : echo '倒转牌.Flip Cards - ';break;
				case 3 : echo '连体牌.Split Cards - ';break;
				case 4 : echo '双面牌.2 Faced - ';break;
				default: break;
			}
			?>
            <a href="card_<?php echo $sidecard['id'] ?>.html"><?php echo $sidecard['name'] ?></a>
            </li>
            <?php }?>
            <li style="text-align:center; padding:20px 0;" onmouseover="this.style.background='#fff'">
                <a href="sets_<?php echo $set['abbr']?>.html"><img src="images/setlogo/<?php echo $set['abbr']?>.png" width="193" /></a>
            </li>
            <li><label>当前版本：</label><a href="sets_<?php echo $set['abbr']?>.html"><?php echo $set['name']?></a> . <?php echo $set['ename'] ?></li>
            <li><label style="line-height:22px;">其他版本<a href="add_set_cards.php?id=<?php echo $card['id'] ?>">[+]</a></label>
                <label style="width:190px;line-height:22px;">
				<?php 
				$sellists=$db->ig2_select_query('select c.id, s.name, s.ename from cards as c,sets as s where c.ename="'.$card['ename'].'" and c.sets <> '.$set['id'].' and c.sets=s.id order by s.pub desc');
				if(count($sellists)){
					foreach($sellists as $setlist){
						?>
						<a href="card_<?php echo $setlist['id'] ?>.html"><?php echo $setlist['name']?></a> . <?php echo $setlist['ename'] ?><br>
						<?php 
					}
				}else{
				    echo "独占或尚未收录";
				}?>
                </label>
            </li>
            <li><label>画家.Illus：</label>
                <label style="width:190px;line-height:20px;"><a href="sch.php?p=<?php echo $card['painter'] ?>"><?php echo $card['painter'] ?></a></label></li>
            <?php 
			$file='file/'.$set['abbr'].'.w/'.$card['serial'].'.jpg';
			if(file_exists($file)){?>
            <li><label>官方壁纸：</label><a href="<?php echo $file ?>" target="_blank">下载</a> - Download</li>
            <?php }?>
        </ul>
    </div>
    <img src="images/mtg-top.png" />
</div>
<?php include_once "down.php";?>