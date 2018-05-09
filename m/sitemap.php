<?php 
include_once "ra_global.php";
include_once "top.php";
?>
<div id="main_1">
	<div class="fl">
        <div class="Range_bar fl" data-req="1">
            <img id="Range_bg_1" class="fl Range_bg_pl" src="images/cards_bg_h.png">
            <label id="Range_lab_1" class="posit2 black_font Range_lab_pl">扩展</label>	
        </div>	
        <div class="Range_bar fl" data-req="2">
            <img id="Range_bg_2" class="fl Range_bg_pl" src="images/cards_bg.png">
            <label id="Range_lab_2" class="posit2 gray_font Range_lab_pl">核心</label>	
        </div>
        <div class="Range_bar fl" data-req="3">
            <img id="Range_bg_3" class="fl Range_bg_pl" src="images/cards_bg.png">
            <label id="Range_lab_3" class="posit2 gray_font Range_lab_pl">其他</label>	
        </div>
    </div>
    <div id="Range_box_1" class="fl margin_bm width_673 Range_box_pl">
    <?php foreach($db->ig2_select('sets','belong=1 and isroot=1  order by pub desc') as $list){?>
    <li class="width_100"><label class="black_font fl big_Environment_name"><?php echo $list['name'] ?></label>
        <?php foreach($db->ig2_select('sets','belong=1 and pid='.$list['id'].' order by pub desc') as $sublist){?>
        <div class="fl width_100 Environment_bar" onClick="location.href='clist.php?id=<?php echo $sublist['id'] ?>'">
            <label class="green_font fl Environment_name"><?php echo $sublist['name'] ?></label>	
            <label class="black_font fl Environment_abbreviation">&nbsp;-&nbsp;<?php echo $sublist['abbr'] ?>&nbsp;-&nbsp;</label>
            <label class="gray_font fl Environment_allwritten"><?php echo $sublist['ename'] ?></label>
            <label class="flr brand_mark tac"><img src="../images/rarity/<?php echo $sublist['abbr'] ?>_1.png"></label>
        </div>
        <?php }?>
        <div class="fl width_100 Environment_bar" onClick="location.href='clist.php?id=<?php echo $list['id'] ?>'">
            <label class="green_font fl Environment_name"><?php echo $list['name'] ?></label>	
            <label class="black_font fl Environment_abbreviation">&nbsp;-&nbsp;<?php echo $list['abbr'] ?>&nbsp;-&nbsp;</label>
            <label class="gray_font fl Environment_allwritten"><?php echo $list['ename'] ?></label>
            <label class="flr brand_mark tac"><img src="../images/rarity/<?php echo $list['abbr'] ?>_1.png"></label>
        </div>
    </li>
    <?php }?>
    </div>
    <div id="Range_box_2" class="fl margin_bm width_673 Range_box_pl dpl">
    <?php foreach($db->ig2_select('sets','belong=2 and isroot=1 order by pub desc') as $list){?>
    <li class="width_100">
    <div class="fl width_100 Environment_bar" onClick="location.href='clist.php?id=<?php echo $list['id'] ?>'">
        <label class="green_font fl Environment_name"><?php echo $list['name'] ?></label>	
        <label class="black_font fl Environment_abbreviation">&nbsp;-&nbsp;<?php echo $list['abbr'] ?>&nbsp;-&nbsp;</label>
        <label class="gray_font fl Environment_allwritten"><?php echo $list['ename'] ?></label>
        <label class="flr brand_mark tac"><img src="../images/rarity/<?php echo $list['abbr'] ?>_1.png"></label>
    </div>
    </li>
    <?php }?>
    </div>
    <div id="Range_box_3" class="fl margin_bm width_673 Range_box_pl dpl">
    <?php foreach($db->ig2_select('sets','belong=3 order by pub desc') as $list){?>
    <li class="width_100">
    <div class="fl width_100 Environment_bar" onClick="location.href='clist.php?id=<?php echo $list['id'] ?>'">
        <label class="green_font fl Environment_name"><?php echo $list['name'] ?></label>	
        <label class="black_font fl Environment_abbreviation">&nbsp;-&nbsp;<?php echo $list['abbr'] ?>&nbsp;-&nbsp;</label>
        <label class="gray_font fl Environment_allwritten"><?php echo $list['ename'] ?></label>
        <label class="flr brand_mark tac"><img src="../images/rarity/<?php echo $list['abbr'] ?>_1.png"></label>
    </div>
    </li>
    <?php }?>
    </div>
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function() {
	$('title').html('牌库 - 爱基兔万智牌');
	$('.title_lab').html('牌库');
	
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth();  
	pageAll();
	
	// 	选择类型  T2 或者  摩登
	$('.Range_bar').click(function(){
		var s=$(this).data('req');
		$('.Range_lab_pl').removeClass('black_font').addClass('gray_font');
		$('#Range_lab_'+s).removeClass('gray_font').addClass('black_font');
		$('.Range_bg_pl').attr('src','images/cards_bg.png');	
		$('#Range_bg_'+s).attr('src','images/cards_bg_h.png');	
		$('.Range_box_pl').hide();
		$('#Range_box_'+s).show();
	});
});

//初始化	
function getWidth(){
	$('.Range_bar').width(212/p).height(76/p).css({marginLeft:23/p+'px',marginTop:23/p+'px'});
	$('.Range_bg_pl').width(212/p).height(76/p);
	$('.Range_lab_pl').css({width:80/p+'px',left:100/p+'px',top:26/p+'px',lineHeight:24/p+'px',fontSize:24/p+'px'});
	$('.input_pl').width(440/p).height(70/p).css({marginLeft:23/p+'px',marginTop:23/p+'px',paddingLeft:20/p+'px',fontSize:24/p+'px'});
	
	//
	$('.big_Environment_name').css({lineHeight:60/p+'px',fontSize:30/p+'px'});
	$('.Environment_name').css({lineHeight:60/p+'px',fontSize:24/p+'px'}); 
	$('.Environment_abbreviation').css({lineHeight:60/p+'px',fontSize:24/p+'px'});
	$('.Environment_allwritten').css({lineHeight:60/p+'px',fontSize:18/p+'px'});
	$('.brand_mark').width(100/p).height(34/p).css({marginTop:13/p+'px'});
	$('.brand_mark img').height(34/p);
	$('.Range_box_pl li').css({marginTop:25/p+'px'});
}
</script>
<?php include_once "down.php";?>