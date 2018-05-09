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