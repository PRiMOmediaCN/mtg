<?php include_once "top.php";?>
<div id="main_1">
	<img id="gongyi" class="fl" src="images/public.jpg">	
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function(){
	$('title').html('公益 - 爱基兔万智牌');
	$('.title_lab').html('公益');
	
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth(); 
	pageAll();
});
//初始化	
function getWidth(){
	$('#gongyi').width(x).css({marginLeft:0/p+'px',marginTop:0/p+'px'});
}
</script>
<?php include_once "down.php";?>