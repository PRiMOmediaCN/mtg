<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>爱基兔万智牌 - IG2</title>
</head>
<body style="background: white">
<?php
include_once "ra_global.php";
include_once "class/image_worker_new.class.php";

$deck=$db->ig2_select("deck_list","did=".$_GET['id']);
$name=$db->ig2_want("decks",'id='.$_GET['id']);
$name=$name['name'];
foreach ($deck as $k=>$d) {
    $deck[$k]["set"] = 0;
}

$maker=new image_worker();
$maker->db=$db;
$maker->deck=$deck;
$maker->id=$_GET['id'];
$maker->name=$name;
if($_GET['regland']){//是否蛋2版基本地优先
    $maker->regland=true;
}
if($_GET['nobasicland']){//是否蛋2版基本地优先
    $maker->nobasicland=true;
}
if($_GET['whiteborder']){//是否白边牌优先
    $maker->whiteborder=true;
}
if($_GET['treasure']){//是否尽量用逸品
    $maker->treasure=true;
}
if(key_exists("belong3",$_GET)){//0尽量不用特殊环境，1都行，2尽量用特殊环境
    $maker->belong3=$_GET['belong3'];
}
if($_GET['scan']){//高清优先
    $maker->en=false;
    $maker->scan=true;
}
if($_GET['lang']){//尽量中文
    $maker->en=false;
    $maker->scan=false;
}
if(key_exists("newfirst",$_GET)){//0
    $maker->newfirst=$_GET['newfirst'];
}
if($_GET['doublesize']){//是否生成背面
    $maker->doublesize=true;
}
if($_GET['fillimg']){//补空牌号，在file/fillimg里
    $maker->fillimg=$_GET['fillimg'];
}
if($_GET['randsame']){//是否随机同一版本，默认随机尽量不同版本
    $maker->randsame=true;
}
if(key_exists("sbwater",$_GET)&&$_GET['sbwater']==1){//备牌水印儿
    $maker->sbwater=true;
}
$maker->getCard();
$maker->make_files();
$pathinfo=$maker->makeIMG();
?>
<a href="show_image.php?path=<?php echo urlencode($pathinfo['path']) ?>" target="view_window" style="clear:both;">img标签展示</a><br/><br/>
<a href="<?php echo $pathinfo['path'] ?>" target="view_window" style="clear:both;">文件夹</a><br/>
<?php echo $pathinfo['path'] ?><br/>
<br/>
<?php foreach ($pathinfo['name']['face'] as $k=>$f){ ?>
    <a href="<?php echo $pathinfo['path'] ?>/<?php echo $f ?>" target="view_window" style="clear:both;">正面第<?php echo $k+1 ?>页</a><br/>
    <?php echo $pathinfo['path'] ?>/<?php echo $f ?><br/>
<?php } ?>
<br/>
<?php foreach ($pathinfo['name']['back'] as $k=>$f){ ?>
    <a href="<?php echo $pathinfo['path'] ?>/<?php echo $f ?>" target="view_window" style="clear:both;">背面第<?php echo $k+1 ?>页</a><br/>
    <?php echo $pathinfo['path'] ?>/<?php echo $f ?><br/>
<?php } ?>
<br/>
<a href="<?php echo $_SERVER['HTTP_REFERER']?>" style="clear:both;">返回</a>
</body>
</html>

