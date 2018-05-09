<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>爱基兔万智牌 - IG2</title>
</head>
<body style="background: white">
<?php
include_once "ra_global.php";
include_once "class/image_worker.class.php";
$noland=$_GET['noland']?' and c.subcate <> 121':'';
$deck=$db->ig2_want("decks","id=".$_GET['id']);
$format=$db->ig2_want("formats",'id='.$deck['format']);
$name="[".$format['code']."]".$deck['name'];
$order="asc";
$belongorder="asc";
if($_GET['usenew']){//是否尽量用新牌
    $order="desc";
}
if($_GET['belong3']){//是否尽量用新牌
    $belongorder="desc";
}
$deck=$db->ig2_select_query("select dl.id,dl.cnum,dl.cename,dl.ismain,c.id as cid,c.side,c.serial,s.id as sid,s.abbr from deck_list dl,cards c,sets s where dl.did=".$_GET['id']." and dl.cename=c.ename and c.sets=s.id".$noland." group by dl.id  order by s.belong ".$belongorder.",s.pub ".$order);

$maker=new image_worker();
$maker->id=$_GET['id'];
$maker->deck=$deck;
$maker->name=$name;
//var_dump($deck);
if(key_exists("sbwater",$_GET)&&$_GET['sbwater']==1){//备牌水印儿
    $maker->sbwater=true;
}
if($_GET['uhland']){//蛋版基本地
    $maker->uhland=true;
}
if($_GET['lang']){//尽量英文
    $maker->en=true;
}
if($_GET['doublesize']){//是否生成背面
    $maker->doublesize=true;
}
if($_GET['fillimg']){//补空牌号，在file/fillimg里
    $maker->fillimg=$_GET['fillimg'];
}
if($_GET['usenew']){//是否尽量用新牌
    $maker->oldcard=false;
}
if($_GET['treasure']){//是否尽量用逸品
    $maker->treasure=true;
}
if($_GET['belong3']){//是否尽量用特殊环境
    $maker->belong3=true;
}
$maker->makeIMG($db);
?>
<a href="<?php echo $_SERVER['HTTP_REFERER']?>" style="clear:both;">返回</a>
</body>
</html>

