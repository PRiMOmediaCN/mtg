<?php
include_once "ra_global.php";
$thisTitle=$thisTitle?$thisTitle:'爱基兔万智牌 - IG2';
$thisKeywords=$thisKeywords?$thisKeywords:'万智牌 牌库 中文 百科 查牌';
$thisDescription=$thisDescription?$thisDescription:'万智牌中文数据百科网站。提供查牌、查套牌、百科和各种中文万智牌工具。';
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
<div class="tit" id="top">
    <div class="main">
        <a href="index.html"><img src="images/logo.png" class="fl" /></a>
        <ul class="maintop">
        <a href="index.html">首页</a>
        <a href="sitemap.html">牌库</a>
        <a href="decks.php">构筑</a>
        <a href="formats.php">比赛</a>
        <a href="dictionary.php">百科</a>
        <a href="public.html">公益</a>
        <span>
        <form action="sch.php" method="get">
        <input name="n" type="text" value="<?php echo $_GET['n'] ?>" class="ipt" placeholder="输入牌名" /><input name="" type="submit" value="搜索" class="bt" />
        <input name="" type="button" value="高级搜索" class="bt" onclick="location.href='schfull.php'" />
        </form>
        </span>
        <div class="fr" id="userbar"></div>
        </ul>
    </div>
</div>
<script>
$(function(){
    $.post('ra_ajax.php',{
		action:'getLoginStatus'
	},function(res){
		$("#userbar").html(res);
	});
});
</script>
<div class="bodyfixed">
    <div class="goTop" onclick="$('body').animate({scrollTop:0}, 400);">回顶</div>
    <div class="goTop" onclick="location.href='suberror.php'">反馈</div>
</div>
<div class="main">