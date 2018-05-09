<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ig2web</title>
    <meta name="viewport" content="width=device-width, target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- jQuery -->
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="images/m.css">
</head>
<body>
<!--导航栏-->
<div class="nav">
	<img id="logo" class="fl" src="images/logo.png">
    <label class="posit2 white_font title_lab tac">百科</label>
    <img id="list_bt" class="flr" src="images/list_bt.png">    
</div>
<div id="main_menu"  data-req="1">
    <a href="index.php"><label class="fl white_font nav_lab module_bt" data-req="1">主页</label></a>
    <a href="sitemap.php"><label class="fl white_font nav_lab module_bt" data-req="2">牌库</label></a>
    <a href="decks.php"><label class="fl white_font nav_lab module_bt" data-req="3">构筑</label></a>
    <a href="dictionary.php"><label class="fl white_font nav_lab module_bt" data-req="4">百科</label></a>
    <a href="public.php"><label class="fl white_font nav_lab module_bt" data-req="5">公益</label></a>
</div> 
<div id="main_menu_box"></div> 
<div id="main_1">
	<img id="baike" class="fl" src="images/baike.jpg">	    
</div>
<div class="footer">
    <a href=""><label id="About_us">关于我们</label></a>
    <label>|</label>
    <a href=""><label>志愿者</label></a>
    <label>CopyRight 2017</label>
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function() {
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth();  
	
//
	$('#list_bt').click(function(){
		if(lt==1){
			$('#main_menu').animate({height:350/p+'px'},500);
			lt=2;
		}else{
			$('#main_menu').animate({height:0/p+'px'},500);
			lt=1;
		}
		$('#main_menu_box').show();
	});	
	
	$('.nav_lab').click(function(){
		$('#main_menu').animate({height:0/p+'px'},500);	
		lt=1;
		$('#main_menu_box').hide();
	});
	
	$('#main_menu_box').click(function(){
		$('#main_menu').animate({height:0/p+'px'},500);	
		lt=1;
		$('#main_menu_box').hide();
	});
	

	


	
});


//初始化	
function getWidth(){
	$('.margin_bm').css({marginBottom:100/p+'px'});
	$('hr').css({marginBottom:23/p+'px',marginTop:23/p+'px'});
	//$('.s').css({left:(x-248)/2+'px',top:(y-95)/3+'px'});
	$('.nav').width(x).height(83/p).css({left:0+'px',top:0+'px'});
	$('#logo').width(135/p).height(83/p).css({marginLeft:15/p+'px'});
	$('#list_bt').width(46/p).height(40/p).css({marginRight:20/p+'px',marginTop:21.5/p+'px'});
	$('#main_menu').width(x).height(1/p).css({left:0+'px',top:83/p+'px'});
	$('#main_menu_box').width(x).height(y).css({left:0+'px',top:0+'px'});
	$('.nav_lab').css({width:x+'px',lineHeight:70/p+'px',fontSize:24/p+'px'});
	$('.title_lab').css({width:400/p+'px',lineHeight:83/p+'px',fontSize:43/p+'px',left:(x-400/p)/2+'px',top:0});
	$('.width_673').width(673/p).css({marginLeft:24/p+'px',marginTop:24/p+'px'});
	//
	$('#main_1').width(x).css({marginLeft:0/p+'px',marginTop:83/p+'px'});
	
	
	//
	$('#baike').width(x).css({marginLeft:0/p+'px',marginTop:0/p+'px'});
	//footer
	$('.footer').width(x).height(94/p).css({marginTop:0/p+'px'});
	$('.footer label').css({lineHeight:94/p+'px',fontSize:24/p+'px'});
	$('#About_us').css({marginLeft:168/p+'px'});
}	

	
</script>

</body>
</html>