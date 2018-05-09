<?php 
include_once "ra_global.php";
if($_GET['did']){
	$deck=$db->ig2_want('decks','id='.$_GET['did']);
	if($deck['dmatch']){
		$match=$db->ig2_want('matchs','id='.$deck['dmatch']);
		$game=$db->ig2_want('games','id='.$match['game']);
	}
	$format=$db->ig2_want('formats','id='.$deck['format']);
	$crts=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=1');
	$plan=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=2');
	$aane=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=3');
	$spel=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=4');
	$land=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=1 and ccate=5');
	$sideb=$db->ig2_select('deck_list','did='.$deck['id'].' and ismain=0');
	$coall=count($crts)+count($plan)+count($aane)+count($spel)+count($land)+count($othe)+count($sideb);
	//$coall=$countall+4;
	$count_crruent=0;
}else{
	tellgoto('您的访问有误','index.php');
}
include_once 'top.php';
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
    	<a href="decks.php"><img id="close_decks" class="fl close_bt2" src="images/close_bt2.png"></a>
        <div class="width_570 fl">
            <label class="fl">[ <font class="gray_font"><?php echo $format['code']?></font> ]</label>	
            <label class="fl Deck_Environment_name"> <?php echo $deck['name']?></label>
            <div class="flr"><?php echo getCost(str_replace(',','',$deck['colors']));?></div>
            <label class="black_font flr id_lab"><font class="gray_font">id : </font><?php echo $deck['id']?></label>
        </div>
        <div class="width_570 fl">
            <label class="gray_font fl Deck_Environment_allwritten"><?php echo $deck['ename']?></label>
            <label class="black_font fl Deck_lab">来自</label>
            <label class="green_font fl Deck_subtitle"><?php echo $match['id']?($match['country'].$match['city'].$game['abbr'].' - <font color="#ccc">'.date('Y.m',strtotime($match['mdate'])).'</font>'):'System'?></label>
        </div>
    </div>
    <div class="fl margin_bm">
    	<div class="mode_bar fl" data-req="1" data-rew="2">
            <img id="mode_bg_1" class="fl mode_bg_pl" src="images/colour_bg_h.png">
            <label id="mode_lab_1" class="posit2 black_font mode_lab_pl">文字模式</label>	
        </div>	
        <div id="switchImg" class="mode_bar fl" data-req="2" data-rew="1">
            <img id="mode_bg_2" class="fl mode_bg_pl" src="images/colour_bg.png">
            <label id="mode_lab_2" class="posit2 gray_font mode_lab_pl">图片模式</label>	
        </div>
        <div id="word_mode" class="width_673 fl">
            <?php 
			$k=1;
			if(count($crts)){?>
        	<li class="width_100">
            	<div class="width_100 fl word_mode_lab_bar" data-req="1" data-rew="1">
                    <label class="fl word_mode_lab black_font">生物（<font id="crt_count">0</font>）</label>
                    <img id="down_arrow_1" class="fl down_arrow_img" src="images/down_arrow.png">
                </div>
                <div id="word_bar_1" class="width_100 fl word_bar" data-req="1">
                <?php 
				$crt_count=0;
				foreach($crts as $crt){
					$card=NULL;
					foreach($db->ig2_select('cards','ename="'.$crt['cename'].'"') as $thiscard){
						$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
						$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
						if(is_dir('file/'.$sets['abbr'])){
							$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
							$card=$thiscard;
						}
					}
					if(!$card){
						$card=$db->ig2_want('cards','ename="'.$crt['cename'].'"');
						$sets=$db->ig2_want('sets','id='.$card['sets']);
						$side=$card['side']?($card['side']==1?'a':'b'):'';
						$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
					}
					?>
					<div class="fl width_100 word_box" data-req="<?php echo $k?>"  onClick="openImgBar(<?php echo $k?>)">
						<label class="fl word_bar_lab1 black_font tac"><?php echo $crt['cnum']?></label>
						<div class="word_box_dot fl">    
							<label class="green_font word_bar_lab2"><?php echo $card['name']?></label>
							<label class="black_font word_bar_lab3">&nbsp;-&nbsp;</label>
							<label class="gray_font word_bar_lab4"><?php echo $card['ename']?></label>
						</div>
						<div class="flr clist_color_box tac"><?php getCost($card['cost']);?></div>
					</div>
                    <script>
					<?php 
					$img_src=is_file('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg')?
									('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg'):
									('../file/'.$sets['abbr'].'.e/'.$card['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
					</script>
					<?php
					$crt_count+=$crt['cnum'];
					$k++;
				}
				?>
                <script>$('#crt_count').html('<?php echo $crt_count?>')</script>
                </div>
            </li>
            <?php 
			}
			if(count($plan)){?>
        	<li class="width_100">
            	<div class="width_100 fl word_mode_lab_bar" data-req="2" data-rew="1">
                    <label class="fl word_mode_lab black_font">鹏洛客（<font id="plan_count">0</font>）</label>
                    <img id="down_arrow_2" class="fl down_arrow_img" src="images/down_arrow.png">
                </div>
                <div id="word_bar_2" class="width_100 fl word_bar" data-req="1">
                <?php 
				$plan_count=0;
				foreach($plan as $crt){
					$card=NULL;
					foreach($db->ig2_select('cards','ename="'.$crt['cename'].'"') as $thiscard){
						$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
						$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
						if(is_dir('file/'.$sets['abbr'])){
							$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
							$card=$thiscard;
						}
					}
					if(!$card){
						$card=$db->ig2_want('cards','ename="'.$crt['cename'].'"');
						$sets=$db->ig2_want('sets','id='.$card['sets']);
						$side=$card['side']?($card['side']==1?'a':'b'):'';
						$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
					}
					?>
					<div class="fl width_100 word_box" data-req="<?php echo $k?>" onClick="openImgBar(<?php echo $k?>)">
						<label class="fl word_bar_lab1 black_font tac"><?php echo $crt['cnum']?></label>
						<div class="word_box_dot fl">    
							<label class="green_font word_bar_lab2"><?php echo $card['name']?></label>
							<label class="black_font word_bar_lab3">&nbsp;-&nbsp;</label>
							<label class="gray_font word_bar_lab4"><?php echo $card['ename']?></label>
						</div>
						<div class="flr clist_color_box tac"><?php getCost($card['cost']);?></div>
					</div>
                    <script>
					<?php 
					$img_src=is_file('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg')?
									('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg'):
									('../file/'.$sets['abbr'].'.e/'.$card['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
					</script>
					<?php
					$plan_count+=$crt['cnum'];
					$k++;
				}
				?>
                <script>$('#plan_count').html('<?php echo $plan_count?>')</script>
                </div>
            </li>
            <?php 
			}
			if(count($aane)){?>
        	<li class="width_100">
            	<div class="width_100 fl word_mode_lab_bar" data-req="3" data-rew="1">
                    <label class="fl word_mode_lab black_font">神器／结界（<font id="aane_count">0</font>）</label>
                    <img id="down_arrow_3" class="fl down_arrow_img" src="images/down_arrow.png">
                </div>
                <div id="word_bar_3" class="width_100 fl word_bar" data-req="1">
                <?php 
				$aane_count=0;
				foreach($aane as $crt){
					$card=NULL;
					foreach($db->ig2_select('cards','ename="'.$crt['cename'].'"') as $thiscard){
						$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
						$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
						if(is_dir('file/'.$sets['abbr'])){
							$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
							$card=$thiscard;
						}
					}
					if(!$card){
						$card=$db->ig2_want('cards','ename="'.$crt['cename'].'"');
						$sets=$db->ig2_want('sets','id='.$card['sets']);
						$side=$card['side']?($card['side']==1?'a':'b'):'';
						$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
					}
					?>
					<div class="fl width_100 word_box" data-req="<?php echo $k?>" onClick="openImgBar(<?php echo $k?>)">
						<label class="fl word_bar_lab1 black_font tac"><?php echo $crt['cnum']?></label>
						<div class="word_box_dot fl">    
							<label class="green_font word_bar_lab2"><?php echo $card['name']?></label>
							<label class="black_font word_bar_lab3">&nbsp;-&nbsp;</label>
							<label class="gray_font word_bar_lab4"><?php echo $card['ename']?></label>
						</div>
						<div class="flr clist_color_box tac"><?php getCost($card['cost']);?></div>
					</div>
                    <script>
					<?php 
					$img_src=is_file('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg')?
									('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg'):
									('../file/'.$sets['abbr'].'.e/'.$card['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
					</script>
					<?php
					$aane_count+=$crt['cnum'];
					$k++;
				}
				?>
                <script>$('#aane_count').html('<?php echo $aane_count?>')</script>
                </div>
            </li>
            <?php 
			}
			if(count($spel)){?>
        	<li class="width_100">
            	<div class="width_100 fl word_mode_lab_bar" data-req="4" data-rew="1">
                    <label class="fl word_mode_lab black_font">法术／瞬间（<font id="spel_count">0</font>）</label>
                    <img id="down_arrow_4" class="fl down_arrow_img" src="images/down_arrow.png">
                </div>
                <div id="word_bar_4" class="width_100 fl word_bar" data-req="1">
                <?php 
				$spel_count=0;
				foreach($spel as $crt){
					$card=NULL;
					foreach($db->ig2_select('cards','ename="'.$crt['cename'].'"') as $thiscard){
						$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
						$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
						if(is_dir('file/'.$sets['abbr'])){
							$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
							$card=$thiscard;
						}
					}
					if(!$card){
						$card=$db->ig2_want('cards','ename="'.$crt['cename'].'"');
						$sets=$db->ig2_want('sets','id='.$card['sets']);
						$side=$card['side']?($card['side']==1?'a':'b'):'';
						$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
					}
					?>
					<div class="fl width_100 word_box" data-req="<?php echo $k?>" onClick="openImgBar(<?php echo $k?>)">
						<label class="fl word_bar_lab1 black_font tac"><?php echo $crt['cnum']?></label>
						<div class="word_box_dot fl">    
							<label class="green_font word_bar_lab2"><?php echo $card['name']?></label>
							<label class="black_font word_bar_lab3">&nbsp;-&nbsp;</label>
							<label class="gray_font word_bar_lab4"><?php echo $card['ename']?></label>
						</div>
						<div class="flr clist_color_box tac"><?php getCost($card['cost']);?></div>
					</div>
                    <script>
					<?php 
					$img_src=is_file('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg')?
									('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg'):
									('../file/'.$sets['abbr'].'.e/'.$card['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
					</script>
					<?php
					$spel_count+=$crt['cnum'];
					$k++;
				}
				?>
                <script>$('#spel_count').html('<?php echo $spel_count?>')</script>
                </div>
            </li>
            <?php 
			}
			if(count($land)){?>
        	<li class="width_100">
            	<div class="width_100 fl word_mode_lab_bar" data-req="5" data-rew="1">
                    <label class="fl word_mode_lab black_font">地（<font id="land_count">0</font>）</label>
                    <img id="down_arrow_5" class="fl down_arrow_img" src="images/down_arrow.png">
                </div>
                <div id="word_bar_5" class="width_100 fl word_bar" data-req="1">
                <?php 
				$land_count=0;
				foreach($land as $crt){
					$card=NULL;
					foreach($db->ig2_select('cards','ename="'.$crt['cename'].'"') as $thiscard){
						$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
						$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
						if(is_dir('file/'.$sets['abbr'])){
							$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
							$card=$thiscard;
						}
					}
					if(!$card){
						$card=$db->ig2_want('cards','ename="'.$crt['cename'].'"');
						$sets=$db->ig2_want('sets','id='.$card['sets']);
						$side=$card['side']?($card['side']==1?'a':'b'):'';
						$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
					}
					?>
					<div class="fl width_100 word_box" data-req="<?php echo $k?>" onClick="openImgBar(<?php echo $k?>)">
						<label class="fl word_bar_lab1 black_font tac"><?php echo $crt['cnum']?></label>
						<div class="word_box_dot fl">    
							<label class="green_font word_bar_lab2"><?php echo $card['name']?></label>
							<label class="black_font word_bar_lab3">&nbsp;-&nbsp;</label>
							<label class="gray_font word_bar_lab4"><?php echo $card['ename']?></label>
						</div>
						<div class="flr clist_color_box tac"><?php getCost($card['cost']);?></div>
					</div>
                    <script>
					<?php 
					$img_src=is_file('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg')?
									('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg'):
									('../file/'.$sets['abbr'].'.e/'.$card['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
					</script>
					<?php
					$land_count+=$crt['cnum'];
					$k++;
				}
				?>
                <script>$('#land_count').html('<?php echo $land_count?>')</script>
                </div>
            </li>
            <?php 
			}
			if(count($sideb)){?>
        	<li class="width_100">
            	<div class="width_100 fl word_mode_lab_bar" data-req="6" data-rew="1">
                    <label class="fl word_mode_lab black_font">备牌（<font id="sideb_count">0</font>）</label>
                    <img id="down_arrow_6" class="fl down_arrow_img" src="images/down_arrow.png">
                </div>
                <div id="word_bar_6" class="width_100 fl word_bar" data-req="1">
                <?php 
				$sideb_count=0;
				foreach($sideb as $crt){
					$card=NULL;
					foreach($db->ig2_select('cards','ename="'.$crt['cename'].'"') as $thiscard){
						$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
						$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
						if(is_dir('file/'.$sets['abbr'])){
							$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
							$card=$thiscard;
						}
					}
					if(!$card){
						$card=$db->ig2_want('cards','ename="'.$crt['cename'].'"');
						$sets=$db->ig2_want('sets','id='.$card['sets']);
						$side=$card['side']?($card['side']==1?'a':'b'):'';
						$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
					}
					?>
					<div class="fl width_100 word_box" data-req="<?php echo $k?>" onClick="openImgBar(<?php echo $k?>)">
						<label class="fl word_bar_lab1 black_font tac"><?php echo $crt['cnum']?></label>
						<div class="word_box_dot fl">    
							<label class="green_font word_bar_lab2"><?php echo $card['name']?></label>
							<label class="black_font word_bar_lab3">&nbsp;-&nbsp;</label>
							<label class="gray_font word_bar_lab4"><?php echo $card['ename']?></label>
						</div>
						<div class="flr clist_color_box tac"><?php getCost($card['cost']);?></div>
					</div>
                    <script>
					<?php 
					$img_src=is_file('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg')?
									('../file/'.$sets['abbr'].'/'.$card['serial'].'.jpg'):
									('../file/'.$sets['abbr'].'.e/'.$card['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
					</script>
					<?php
					$sideb_count+=$crt['cnum'];
					$k++;
				}
				?>
                <script>$('#sideb_count').html('<?php echo $sideb_count?>')</script>
                </div>
            </li>
            <?php 
			}
			?>
        </div>
        <div id="img_mode" class="width_673 fl dpl"><img class="fl width_100" src="images/loading.gif"></div>
    </div>
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function() {
	$('title').html('<?php echo $deck['name']?> - 爱基兔万智牌');
	$('.title_lab').html('构筑');
	
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth();  
	pageAll();

	//选择文字模式或者图片模式
	var imgDisplayed=false;
	$('.mode_bar').click(function(){
		var s=$(this).data('req');
		$(this).parent().children().each(function(){
			var r=$(this).data('req');
			if(r==s){
				$('#mode_lab_'+r).removeClass('gray_font').addClass('black_font');
				$('#mode_bg_'+r).attr('src','images/colour_bg_h.png');	
			}else{
				$('#mode_lab_'+r).removeClass('black_font').addClass('gray_font');
				$('#mode_bg_'+r).attr('src','images/colour_bg.png');	
			}
		});
		if(s==1){
			$('#word_mode').show();	
			$('#img_mode').hide();	
		}else{
			$('#word_mode').hide();	
			$('#img_mode').show();
		}
		if(imgDisplayed==false){
			console.log(imgDisplayed);
			deckViewGetImg(<?php echo $_GET['did']?>);
			imgDisplayed=true;
		}
	});
	
	//展开收起牌张类别
	$('.word_mode_lab_bar').click(function(){
		var s=$(this).data('req');
		if($(this).data('rew')==1){
			$('#word_bar_'+s).hide();
			$('#down_arrow_'+s).attr('src','images/down_arrow_h.png');
			$(this).data('rew','2');
		}else{
			$('#word_bar_'+s).show();
			$('#down_arrow_'+s).attr('src','images/down_arrow.png');
			$(this).data('rew','1');
		}
	});
		
	//关闭牌张
	$('.close_bt').click(function(){
		$('#img_enlarge').fadeOut(200);	
	});
});

//文字模式下点击每条弹出图片
var img_number=<?php echo $coall?>,count;
function openImgBar(s){
	count=s;
	$('#img_enlarge').fadeIn(200);
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

//获取图片
function deckViewGetImg(did){
    $.post('ra_ajax.php',{
		action:'deckViewGetImg',
		did:did,
	},function(res){
		if(res) console.log('ok');
		$("#img_mode").html(res);
	});
}

//初始化	
function getWidth(){	
	
	//套牌展示部分
	$('.Deck_Environment_name').css({lineHeight:34/p+'px',fontSize:34/p+'px'}); 
	$('.Deck_Environment_allwritten').css({lineHeight:40/p+'px',fontSize:18/p+'px'});
	$('.Deck_subtitle').css({lineHeight:40/p+'px',fontSize:18/p+'px'});
	$('.Deck_lab').css({lineHeight:40/p+'px',fontSize:18/p+'px'});
	$('.clist_color_box').width(170/p).height(65/p);
	$('.width_570').width(570/p);
	
	//套牌具体内容
	$('.id_lab').css({lineHeight:40/p+'px',fontSize:18/p+'px',marginRight:15/p+'px'});
	$('.mode_bar').width(327/p).height(76/p).css({marginLeft:23/p+'px',marginTop:23/p+'px'});
	$('.mode_bg_pl').width(327/p).height(76/p);
	$('.mode_lab_pl').css({width:200/p+'px',left:100/p+'px',top:26/p+'px',lineHeight:24/p+'px',fontSize:24/p+'px'});
	$('.down_arrow_img').width(40/p).height(40/p).css({marginLeft:10/p+'px'});
	$('.word_mode_lab').css({lineHeight:40/p+'px',fontSize:30/p+'px'});
	$('.word_mode_lab_bar').css({marginBottom:23/p+'px',marginTop:23/p+'px'});
	$('.word_bar_lab1').css({width:90/p+'px',height:65/p+'px',lineHeight:65/p+'px',fontSize:24/p+'px',background:'#f8f8f8'});
	$('.word_bar_lab2').css({lineHeight:65/p+'px',fontSize:24/p+'px',marginLeft:10/p+'px'});
	$('.word_bar_lab3').css({lineHeight:65/p+'px',fontSize:24/p+'px',marginLeft:10/p+'px'});
	$('.word_bar_lab4').css({lineHeight:65/p+'px',fontSize:18/p+'px',marginLeft:10/p+'px'});
	$('.clist_colour_img').width(27/p).height(27/p).css({marginTop:19/p+'px',marginRight:10/p+'px'});
	$('.word_box_dot').width(395/p).height(65/p);
	$('.close_bt2').width(100/p).height(100/p);
	
	//打开图片浮层
	$('.img_mode_img').css({marginTop:5/p+'px'});
	$('#img_enlarge').width(x).height(y).css({left:0,top:0});
	$('#img_enlarge_bar').width(616/p).height(64/p).css({left:(x-616/p)/2+'px',top:123/p+'px'});
	$('#img_enlarge_bar label').css({width:552/p+'px',lineHeight:64/p+'px',fontSize:24/p+'px'});
	$('#img_enlarge_img_bar').width(616/p).height(879/p).css({left:0,top:65/p+'px'});
	$('.close_bt').width(64/p).height(64/p);
}
</script>
<?php include_once "down.php";?>