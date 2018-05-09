<div class="footer">
    <a href=""><label id="About_us">关于我们</label></a>
    <label>|</label>
    <a href=""><label>志愿者</label></a>
    <label>CopyRight 2017</label>
</div>
<script>

//头部功能
$('#list_bt').click(function(){
	if(lt==1){
		$('#main_menu').animate({height:350/p+'px'},200);
		lt=2;
	}else{
		$('#main_menu').animate({height:0/p+'px'},200);
		lt=1;
	}
	$('#main_menu_box').show();
});	

$('.nav_lab').click(function(){
	$('#main_menu').animate({height:0/p+'px'},200);	
	lt=1;
	$('#main_menu_box').hide();
});

$('#main_menu_box').click(function(){
	$('#main_menu').animate({height:0/p+'px'},200);	
	lt=1;
	$('#main_menu_box').hide();
});

function pageAll(){
	$('.margin_bm').css({marginBottom:100/p+'px'});
    $('.nav').width(x).height(83/p).css({left:0+'px',top:0+'px'});
	$('#logo').width(135/p).height(83/p).css({marginLeft:15/p+'px'});
	$('#list_bt').width(46/p).height(40/p).css({marginRight:20/p+'px',marginTop:21.5/p+'px'});
	$('#main_menu').width(x).height(0/p).css({left:0+'px',top:83/p+'px'});
	$('#main_menu_box').width(x).height(y).css({left:0+'px',top:0+'px'});
	$('.nav_lab').css({width:x+'px',lineHeight:70/p+'px',fontSize:24/p+'px'});
	$('.title_lab').css({width:400/p+'px',lineHeight:83/p+'px',fontSize:43/p+'px',left:(x-400/p)/2+'px',top:0});
	$('.width_673').width(673/p).css({marginLeft:24/p+'px',marginTop:24/p+'px'});
	$('#main_1').width(x).css({marginLeft:0/p+'px',marginTop:83/p+'px'});
	
	$('.footer').width(x).height(94/p).css({marginTop:23/p+'px'});
	$('.footer label').css({lineHeight:94/p+'px',fontSize:24/p+'px'});
	$('#About_us').css({marginLeft:168/p+'px'});
}
</script>
</body>
</html>