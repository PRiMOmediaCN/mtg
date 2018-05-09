<?php 
include_once "ra_global.php";
if($_GET['id']){
	$where='';
    $sets=$db->ig2_want('sets','id='.$_GET['id']);
	$where.='sets='.$_GET['id'];
	if($_GET['rarity']) $where.=' and rarity='.$_GET['rarity'];
	$where.=' order by serial';
	$cards=$db->ig2_select('cards',$where);
	$count=count($cards);
}else{
    tellgoto('您的访问有误','index.php');
}
include_once "top.php";
?>
<div id="img_enlarge" class="dpl">
	<div id="img_enlarge_bar" class="posit2">
    	<label id="img_enlarge_bar_1" class="fl tac lab_opaticy_1 white_font">左右滑动查看前后牌张，点击牌面查看详细资料</label>
        <img class="posit2 close_bt" src="images/close_bt.jpg">
        <div id="img_enlarge_img_bar"></div>
    </div>
</div> 
<div id="main_1">
    <div class="fl width_673">
    	<a href="sitemap.php"><img id="close_clist" class="fl close_bt2" src="images/close_bt2.png"></a>
        <div class="flr HOU_img tac">
            <img src="../images/rarity/<?php echo $sets['abbr']?>_1.png" />
            <?php echo strtoupper($sets['abbr'])?>
        </div>
        <div class="width_520 fl">
            <label class="black_font fl clist_Environment_name"><?php echo $sets['name']?></label>
        </div>
        <div class="width_520 fl">
            <label class="gray_font fl clist_Environment_allwritten"><?php echo $sets['ename']?></label>
        </div> 
    </div>
    <div class="fl">
        <a href="?id=<?php echo $_GET['id']?>"><img class="fl category_img_pl" src="images/category_color_0<?php echo $_GET['rarity']?'':'_h'?>.jpg"></a>
        <a href="?id=<?php echo $_GET['id']?>&rarity=4"><img class="fl category_img_pl" src="images/category_color_1<?php echo $_GET['rarity']==4?'_h':''?>.jpg"></a>
        <a href="?id=<?php echo $_GET['id']?>&rarity=3"><img class="fl category_img_pl" src="images/category_color_2<?php echo $_GET['rarity']==3?'_h':''?>.jpg"></a>
        <a href="?id=<?php echo $_GET['id']?>&rarity=2"><img class="fl category_img_pl" src="images/category_color_3<?php echo $_GET['rarity']==2?'_h':''?>.jpg"></a>
        <a href="?id=<?php echo $_GET['id']?>&rarity=1"><img class="fl category_img_pl" src="images/category_color_4<?php echo $_GET['rarity']==1?'_h':''?>.jpg"></a>
        <a href="?id=<?php echo $_GET['id']?>&rarity=5"><img class="fl category_img_pl" src="images/category_color_5<?php echo $_GET['rarity']==5?'_h':''?>.jpg"></a> 
    </div>
    <div id="clist_mode" class="width_673 fl">
        <div id="clist_bar_1" class="width_100 fl clist_bar" data-req="1">
		<?php 
        $k=1;
        foreach($cards as $list){
            $this_set=$db->ig2_want('sets','id='.$list['sets']);
            ?>
            <div id="clist_box_1" class="fl width_100 clist_box" data-req="<?php echo $k?>" onClick="openImgBar(<?php echo $k?>)">
                <label class="fl clist_bar_lab1 black_font tac"><?php echo $list['serial']?></label>
                <div class="clist_box_dot fl">    
                    <label class="green_font clist_bar_lab2"><?php echo $list['name']?></label>
                    <label class="black_font clist_bar_lab3">&nbsp;-&nbsp;</label>
                    <label class="gray_font clist_bar_lab4"><?php echo $list['ename']?></label>
                </div>
                <div class="clist_color_box tac flr"><?php echo getCost($list['cost']);?></div>
            </div>
            <script>
			<?php $img_src=is_file('../file/'.$this_set['abbr'].'/'.$list['serial'].'.jpg')?
			                      ('../file/'.$this_set['abbr'].'/'.$list['serial'].'.jpg'):
								  ('../file/'.$this_set['abbr'].'.e/'.$list['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $list['id']?>\'">');
			</script>
            <?php 
			$k++;
        }
        ?>
        </div>
    </div>
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function() {
	$('title').html('<?php echo $sets['name']?> - 爱基兔万智牌');
	$('.title_lab').html('牌库');
	
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth();  
	pageAll();

	//展开
	$('#img_mode_img_1').click(function(){
		$('#img_enlarge').fadeIn(200);		
	});
	
	$('.close_bt').click(function(){
		$('#img_enlarge').fadeOut(200);	
	});
});

//文字模式下  点击每条弹出图片
var img_number=<?php echo $count?>,count;
function openImgBar(s){
	count=s;
	$('#img_enlarge').fadeIn(500);
	$('#img_enlarge_img_bar').children().each(function(index, element) {
		$(this).width(616/p).height(879/p).css({left:((parseInt(index+1)-count)*616)/p+'px',top:0/p+'px',position:'absolute',zIndex:2});
	});
}

//手指滑动切换页面
document.getElementById("img_enlarge_img_bar").addEventListener("touchstart", touchStart, false);
document.getElementById("img_enlarge_img_bar").addEventListener("touchmove", touchMove, false);
document.getElementById("img_enlarge_img_bar").addEventListener("touchend", touchEnd, false);

function touchStart(event){
	startX = event.touches[0].clientX;
}
function touchMove(event){
	event.preventDefault();
}
function touchEnd(event){
	endX = event.changedTouches[0].clientX;
	if(startX-endX >50&&count>=1&&count<img_number){
		$('.img_enlarge_img').animate({left:'-='+616/p+'px'});	
		count++;
	}
	if(endX-startX >50&&count>1&&count<=img_number){
		$('.img_enlarge_img').animate({left:'+='+616/p+'px'});	
		count--;
	}
}

//初始化	
function getWidth(){
	$('.category_img_pl').width(99/p).height(136/p).css({marginLeft:18/p+'px',marginTop:14/p+'px'});
	$('.clist_Environment_name').css({lineHeight:70/p+'px',fontSize:35/p+'px'}); 
	$('.clist_Environment_allwritten').css({lineHeight:20/p+'px',fontSize:18/p+'px'});
	
	//文字块
	$('.id_lab').css({lineHeight:40/p+'px',fontSize:18/p+'px',marginRight:15/p+'px'});
	$('.mode_bar').width(327/p).height(76/p).css({marginLeft:23/p+'px',marginTop:23/p+'px'});
	$('.mode_bg_pl').width(327/p).height(76/p);
	$('.mode_lab_pl').css({width:200/p+'px',left:100/p+'px',top:26/p+'px',lineHeight:24/p+'px',fontSize:24/p+'px'});
	$('.down_arrow_img').width(40/p).height(40/p).css({marginLeft:10/p+'px'});
	$('.clist_mode_lab').css({lineHeight:40/p+'px',fontSize:30/p+'px'});
	$('.clist_mode_lab_bar').css({marginBottom:23/p+'px',marginTop:23/p+'px'});
	$('.clist_bar_lab1').css({width:90/p+'px',height:65/p+'px',lineHeight:65/p+'px',fontSize:24/p+'px',background:'#f8f8f8'});
	$('.clist_bar_lab2').css({lineHeight:65/p+'px',fontSize:24/p+'px',marginLeft:10/p+'px'});
	$('.clist_bar_lab3').css({lineHeight:65/p+'px',fontSize:24/p+'px',marginLeft:10/p+'px'});
	$('.clist_bar_lab4').css({lineHeight:65/p+'px',fontSize:18/p+'px',marginLeft:10/p+'px'});
	$('.clist_color_box').width(170/p).height(65/p);
	$('.clist_colour_img').width(27/p).height(27/p).css({marginTop:19/p+'px',marginRight:10/p+'px'});
	$('.clist_box_dot').width(395/p).height(65/p);
	
	//图片块
	$('.img_mode_img').width(320/p).height(457/p).css({margin:5/p+'px'});
	$('#img_enlarge').width(x).height(y).css({left:0,top:0});
	$('#img_enlarge_bar').width(616/p).height(64/p).css({left:(x-616/p)/2+'px',top:123/p+'px'});
	$('#img_enlarge_bar label').css({width:552/p+'px',lineHeight:64/p+'px',fontSize:24/p+'px'});
	$('#img_enlarge_img_bar').width(616/p).height(879/p).css({left:0,top:65/p+'px'});
	$('.close_bt').width(64/p).height(64/p);
	$('.close_bt2').width(100/p).height(100/p);
	$('.width_520').width(520/p);
	$('.HOU_img').width(50/p).height(100/p).css({marginTop:15/p+'px',marginRight:0/p+'px',fontSize:20/p+'px',lineHeight:30/p+'px'});
	$('.HOU_img img').height(36/p);
}
</script>
<?php include_once "down.php";?>