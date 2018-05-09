<?php 
include_once "ra_global.php";
if($_GET['abbr']) $sets=$db->ig2_want('sets','abbr="'.$_GET['abbr'].'"');
$thisTitle=$sets['name'].' - '.$sets['ename'].' - 牌库 - 爱基兔万智牌 - IG2';
$thisKeywords=$sets['name'].' '.$sets['ename'].' 牌库 万智牌 中文 百科 查牌';
$thisDescription=$sets['name'].' 系列，出版于'.$sets['pub'].'，缩写：'.$sets['abbr'].'，共'.$sets['total'].'张牌。——来自爱基兔万智牌 - 万智牌中文数据百科网站';
?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $thisDescription?>">
<meta name="keywords" content="<?php echo $thisKeywords?>"> 
<title><?php echo $thisTitle?></title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
<script src="inc/jquery.js"></script>
</head>
<body>
<?php include_once "topbar.php";?>
<div class="main">
<div class="setlist">
    <h1><?php echo $sets['name'].'.'.$sets['ename'] ?></h1>
    <ul>
    <li style="background:#f4f4f4"><strong>
        <label style="width:50px;">#</label>
        <label style="width:180px;">中文名称</label>
        <label style="width:230px;">英文名称</label>
        <label style="width:180px;">类别</label>
        <label style="width:80px;">攻防</label>
        <label>费用</label>
        <label style="width:40px;">稀有</label>
    </strong></li>
	<?php foreach($db->ig2_select('cards','`sets`='.$sets['id'].' order by `serial`,`side`') as $list){?>
    <li><label style="width:50px;">#<?php echo $list['serial'].($list['side']=='0'?'':($list['side']==1?'a':'b')) ?></label>
        <label style="width:180px;"><a href="card_<?php echo $list['id'] ?>.html"><?php echo $list['name'] ?></a></label>
        <label style="width:230px;"><?php echo $list['ename'] ?></label>
		<label style="width:180px;"><?php 
		echo $list['legendary']?"<strong>传奇</strong>":'';
		if($list['prefix']){
		    $prefix=$db->ig2_want('cates','id='.$list['prefix']);
			echo $prefix['name'];
		}
		foreach(explode(',',$list['cate']) as $cate){
		    $catename=$db->ig2_want('cates','id='.$cate);
		    echo $catename['name'];
		}
		if($list['subcate']){
			
			$subcate_arr=array();
			foreach(explode(',',$list['subcate']) as $subcate){
				$subcate_name=$db->ig2_want('cates','id='.$subcate);
				$subcate_arr[]=$subcate_name['name'];
			}
		    
		    echo '～'.implode(' / ',$subcate_arr);
		}
		if(trim($list['crtcate'])){//in_array('4',explode(',',$list['cate'])) || $list['prefix']
			$crtcatename=array();
			foreach(explode(',',trim($list['crtcate'])) as $crt){
				$crtcate=$db->ig2_want('crtcates','id='.$crt);
				$crtcatename[]=$crtcate['name'];
			}
			echo '～'.implode('&nbsp;/&nbsp;',$crtcatename);
		}		
		echo $list['cate']==5?('('.$list['loyalty'].')'):''; 
		?></label>
        <label style="width:80px;"><?php echo in_array('4',explode(',',$list['cate']))?($list['power'].'/'.$list['toughness']):'&nbsp;';?></label>
        <label><?php echo trim($list['cost'])!=''?($list['cost'].'(<strong>'.$list['costs'].'</strong>)'):'-'?></label>
        <label style="width:40px;"><?php if($list['rarity']){?><img src="images/rarity/<?php echo $sets['abbr'] ?>_<?php echo $list['rarity'] ?>.png" height="20" /><?php }else{ echo '-';}?></label>
    </li>
    <?php }?>
    </ul>
    <img src="images/mtg-top.png" />
</div>
<?php include_once "down.php";?>