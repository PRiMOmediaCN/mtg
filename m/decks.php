<?php 
include_once "ra_global.php";
$where='1';
if($_GET['id']) $where.=' and format='.$_GET['id'];
if($_GET['dn']) $where.=' and name like "%'.$_GET['dn'].'%"';
$where.=' order by id desc limit 12';
$decks=$db->ig2_select('decks',$where);
include_once "top.php";
?>
<div id="main_1">
<form action="decks.php" method="get">
    <div id="Deck_bar" class="fl">
    	<a href="?dn=<?php echo $_GET['dn']?>"><img class="fl category_img_pl" src="images/Deck_0<?php echo $_GET['id']?'':'_h'?>.jpg"></a>
    	<a href="?id=1&dn=<?php echo $_GET['dn']?>"><img class="fl category_img_pl" src="images/Deck_1<?php echo $_GET['id']==1?'_h':''?>.jpg"></a>
        <a href="?id=2&dn=<?php echo $_GET['dn']?>"><img class="fl category_img_pl" src="images/Deck_2<?php echo $_GET['id']==2?'_h':''?>.jpg"></a>
        <a href="?id=3&dn=<?php echo $_GET['dn']?>"><img class="fl category_img_pl" src="images/Deck_3<?php echo $_GET['id']==3?'_h':''?>.jpg"></a>
        <a href="?id=4&dn=<?php echo $_GET['dn']?>"><img class="fl category_img_pl" src="images/Deck_4<?php echo $_GET['id']==4?'_h':''?>.jpg"></a>
        <a href="?id=5&dn=<?php echo $_GET['dn']?>"><img class="fl category_img_pl" src="images/Deck_5<?php echo $_GET['id']==5?'_h':''?>.jpg"></a>	
    </div>
    <div class="fl">
        <input name="id" type="hidden" value="<?php echo $_GET['id']?>" />
        <input class="input_pl fl" type="text" name="dn" placeholder="可模糊输入中文套牌名称，例如：妖" />
        <input id="Deck_search_bt" class="fl" value="搜索" type="submit" />
    </div>
</form>     
    <div class="fl">
	<?php 
    foreach($decks as $list){
        $format=$db->ig2_want('formats','id='.$list['format']);
		if($list['dmatch']){
			$match=$db->ig2_want('matchs','id='.$list['dmatch']);
			$game=$db->ig2_want('games','id='.$match['dmatch']);
		}
		$card_cover=$db->ig2_want('deck_list','did='.$list['id'].' order by rand()');
		$cover=$db->ig2_want('cards','ename="'.$card_cover['cename'].'"');
		$card_set=$db->ig2_want('sets','id='.$cover['sets']);
		$cover_url='../file/'.$card_set['abbr'].'.e/'.$cover['serial'].'.jpg';
		$cover_url=file_exists($cover_url)?$cover_url:('../file/'.$card_set['abbr'].'.e/'.$cover['serial'].'a.jpg');
		?>
        <li class="Deck_li_pl" onClick="location.href='view_deck.php?did=<?php echo $list['id']?>'">
        	<div class="fl Deck_face_img"><img src="<?php echo $cover_url;?>" class="posit2 card_cover" /></div>
            <div class="fl Deck_content_bar">
            	<div class="fl width_100">
                	<label class="fl">[<font class="gray_font Deck_content_lab"><?php echo $format['code']?></font>]</label>
                    <label class="green_font fl Deck_Environment_name"><?php echo $list['name']?>
                    <div class="flr clist_color_box"><?php echo getCost(str_replace(',','',$list['colors']));?></div>
                    </label>
                </div>
            	<label class="gray_font fl Deck_Environment_allwritten"><?php echo $list['ename']?></label>
                <label class="black_font fl Deck_lab">来自</label>
                <label class="green_font fl Deck_subtitle"><?php echo $match['id']?($match['country'].$match['city'].$game['abbr'].' - <font color="#ccc">'.date('Y.m',strtotime($match['mdate'])).'</font>'):'System'?></label>
                
            </div>	
        </li>
        <?php 
	}
	?>
        <div id="deckPageMore" data-cPage="1" data-cId="<?php echo $_GET['id']?>" data-cDeckName="<?php echo $_GET['dn']?>"></div>
    </div>
    <div class="fl deckGetMore tac" 
         onClick="deckGetMore($('#deckPageMore').attr('data-cPage'),$('#deckPageMore').attr('data-cId'),$('#deckPageMore').attr('data-cDeckName'))">点击加载更多
    </div>
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function() {
	$('title').html('构筑 - 爱基兔万智牌');
	$('.title_lab').html('构筑');
	
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth(); 
	getWidthList();
	pageAll();
});

function deckGetMore(page,id,name){
    $.post('ra_ajax.php',{
		action:'getDecklistMore',
		deckPage:page,
		formatId:id,
		searchName:name
	},function(res){
		if(res!=0){
			$("#deckPageMore").append(res);
			$("#deckPageMore").attr('data-cPage',parseInt(page)+1);
		}else{
		    $(".deckGetMore").html('没有了');
			$(".deckGetMore").click(null);
		}
	});
}

//初始化	
function getWidth(){
	$('.cards_bar').width(212/p).height(76/p).css({marginLeft:23/p+'px',marginTop:23/p+'px'});
	$('.cards_bg_pl').width(212/p).height(76/p);
	$('.cards_lab_pl').css({width:80/p+'px',left:100/p+'px',top:26/p+'px',lineHeight:24/p+'px',fontSize:24/p+'px'});
	$('.input_pl').width(450/p).height(70/p).css({marginLeft:23/p+'px',marginTop:23/p+'px',padding:0,paddingLeft:20/p+'px',fontSize:24/p+'px'});
	$('#Deck_search_bt').width(200/p).height(70/p).css({marginTop:23/p+'px',border:0,padding:0});
}
function getWidthList(){
	$('.category_img_pl').width(99/p).height(136/p).css({marginLeft:18/p+'px',marginTop:14/p+'px'});
	$('.Deck_li_pl').width(673/p).css({marginLeft:23/p+'px',marginTop:23/p+'px'});
	$('.Deck_face_img').width(193/p).height(156/p).css({margin:8/p+'px'});
	$('.Deck_content_bar').width(435/p).height(156/p).css({marginLeft:15/p+'px',marginTop:8/p+'px'});
	$('.Deck_content_lab').css({lineHeight:40/p+'px',fontSize:26/p+'px'}); 
	$('.Deck_Environment_name').css({lineHeight:40/p+'px',fontSize:26/p+'px',marginLeft:5/p+'px'}); 
	$('.Deck_Environment_allwritten').css({lineHeight:40/p+'px',fontSize:16/p+'px'});
	$('.Deck_subtitle').css({lineHeight:40/p+'px',fontSize:16/p+'px'});
	$('.Deck_lab').css({lineHeight:40/p+'px',fontSize:16/p+'px'});
	$('.clist_color_box').width(150/p).height(27/p).css({marginLeft:10/p+'px'});
	$('.clist_colour_img').width(27/p).height(27/p).css({marginRight:3/p+'px'});
	$('.deckGetMore').width(672/p).height(68/p).css({marginLeft:(x-672/p)/2+'px',marginTop:30/p+'px',fontSize:30/p+'px',lineHeight:68/p+'px'});
	$('.card_cover').width(244/p).css({left:-26/p+'px', top:-39/p+'px'});
}
</script>
<?php include_once "down.php";?>