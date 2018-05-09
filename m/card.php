<?php
include_once "ra_global.php";
if($_GET['id']){
    $card=$db->ig2_want('cards','id='.$_GET['id']);
	$set=$db->ig2_want('sets','id='.$card['sets']);
	$cardnext=$db->ig2_want('cards','`sets`='.$card['sets'].' and `serial`='.($card['serial']+1));
	$cardprev=$db->ig2_want('cards','`sets`='.$card['sets'].' and `serial`='.($card['serial']-1));
}else{
	tellgoto('您的访问有误','index.php');
}
$card_cn='../file/'.$set['abbr']."/".$card['serial'].($card['side']?($card['side']==1?'a':'b'):'').'.jpg';
$card_en='../file/'.$set['abbr'].".e/".$card['serial'].($card['side']?($card['side']==1?'a':'b'):'').'.jpg';
$card_cn=file_exists($card_cn)?$card_cn:$card_en;


include_once "top.php";
?>
<div id="card_top_bar">
    <div  id="card_top" class="width_673">
        <a href="#" onClick="history.go(-1)"><img id="close_clist" class="fl close_bt2" src="images/close_bt2.png"></a>
        <img id="arrow_1" class="flr arrow_img" src="images/arrow_1.png">
        <div id="hou_bar_bt" class="flr hou_bar" data-rew="1">
            <img class="fl HOU_img" src="../images/rarity/<?php echo $set['abbr']?>_1.png" />
            <label class="black_font fl hou_bar_lab"><?php echo strtoupper($set['abbr'])?></label>
        </div>

        <div class="width_430 fl">
            <label class="black_font fl clist_Environment_name"><?php echo $card['name']?></label>
        </div>
        <div class="width_430 fl">
            <label class="gray_font fl clist_Environment_allwritten"><?php echo $card['ename']?></label>
        </div>
    </div>
</div>
<div id="card_top_open" class="dpl">
    <div id="card_top_open_box" class="fl">
        <?php 
		foreach($db->ig2_select('cards','ename="'.$card['ename'].'"') as $list){
			$set=$db->ig2_want('sets','id='.$list['sets']);
			$card_id=$db->ig2_want('cards','ename="'.$card['ename'].'" and sets='.$set['id']);
			?>
            <div class="flr card_top_open_bar" onClick="location.href='card.php?id=<?php echo $card_id['id']?>'">
                <img class="fl card_top_open_img" src="../images/rarity/<?php echo $set['abbr']?>_1.png">
                <label class="black_font fl card_top_open_lab"><?php echo strtoupper($set['abbr'])?></label>
            </div>
            <?php 
		}
		?>
    </div>
</div>

<div id="main_1">
    <div id="card_img_enlarge_bar" class="fl">
        <label id="card_img_enlarge_bar_1" class="fl tac lab_opaticy_1 white_font" data-req="1">中文</label>
        <label id="card_img_enlarge_bar_2" class="fl tac background_gray white_font" data-req="2">English</label>
        <?php if($card['side']){?>
        <div id="card_img_enlarge_bar_3" class="fl tac lab_opaticy_1 white_font" >
            <label id="card_img_enlarge_bar_3_lab" class="fl white_font" data-req="3" data-rew="1">翻面</label>
        </div>
        <?php }?>
    </div>
    <img id="card_img_enlarge_img_1" class="fl img_enlarge_img" src="<?php echo $card_cn;?>">
    <div id="card_img_enlarge_img_content" class="fl">
        <div class="width_100 fl">
            <label class="black_font fl card_content_lab_1"><strong><?php echo $card['name'];?></strong></label>
            <label class="gray_font fl Goring Ceratops card_content_lab_2"><?php echo $card['ename'];?></label>
        </div>
        <div class="width_100 fl">
            <label class="black_font fl card_content_lab_3">
            <?php 
			echo $card['legendary']?"传奇":'';
			if($card['prefix']){
				$prefix=$db->ig2_want('cates','id='.$card['prefix']);
				echo $prefix['name'];
			}
			foreach(explode(',',$card['cate']) as $cate){
				$catename=$db->ig2_want('cates','id='.$cate);
				echo $catename['name'];
			}
			if($card['subcate']){
				$subcate_arr=array();
				foreach(explode(',',$card['subcate']) as $subcate){
					$subcate_name=$db->ig2_want('cates','id='.$subcate);
					$subcate_arr[]=$subcate_name['name'];
				}
				
				echo '～'.implode(' / ',$subcate_arr);
			}
			if(in_array('4',explode(',',$card['cate'])) || $card['prefix']){
				$crtcatename=array();
				foreach(explode(',',$card['crtcate']) as $crt){
					$crtcate=$db->ig2_want('crtcates','id='.$crt);
					$crtcatename[]=$crtcate['name'];
				}
				echo '～'.implode('&nbsp;/&nbsp;',$crtcatename);
			}		
			echo ($card['cate']==5?('('.$card['loyalty'].')'):'').(trim($card['cost'])!=''?('，'.$card['cost'].'('.$card['costs'].')'):'');
			echo in_array('4',explode(',',$card['cate']))?(' , '.$card['power'].' / '.$card['toughness']):'';
			?>
            </label>
        </div>
        <div class="width_100 fl">
            <label class="black_font fl card_content_lab_3 width_100"><?php echo $card['intext']?></label>
        </div>
        <div class="width_100 fl">
            <label class="gray_font fl card_content_lab_3"><i><?php echo $card['flavor']?></i></label>
        </div>
        <div class="width_100 fl">
            <label class="red_font fl card_content_lab_3">
            <?php 
			if($card['restricted']){
				foreach(explode(',',$card['restricted']) as $restricted){
					$restname=$db->ig2_want('formats','id='.$restricted);
			 		echo $restname['name']?> ( <?php echo $restname['code']; echo $restname['code']=='EDH'?'，禁作大将）':'）限制'; ?><br>
			<?php 
				}
			}
			if($card['banned']){
				foreach(explode(',',$card['banned']) as $banned){
					$bannedname=$db->ig2_want('formats','id='.$banned);
				    echo $bannedname['name']?> ( <?php echo $bannedname['code']?> ) 禁止<br>
					<?php 
				}
			}
			?>
            </label>
        </div>
    </div>
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function() {
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth();
	pageAll();
	$('#main_1').width(x).css({marginLeft:0/p+'px',marginTop:250/p+'px'});
	$('#card_top_open_box').width(120*$('#card_top_open_box').children().length/p);

	//中文 英文切换
	var currentSide='cn';
	$('#card_img_enlarge_bar label').click(function(){
		var s=$(this).data('req');	
		if(s==1){//中文
			$('#card_img_enlarge_bar_1').removeClass('background_gray').addClass('lab_opaticy_1');
			$('#card_img_enlarge_bar_2').removeClass('lab_opaticy_1').addClass('background_gray');
            $('#card_img_enlarge_img_1').attr('src','<?php echo $card_cn?>');
		}else if(s==2){//英文
			$('#card_img_enlarge_bar_2').removeClass('background_gray').addClass('lab_opaticy_1');
			$('#card_img_enlarge_bar_1').removeClass('lab_opaticy_1').addClass('background_gray');
            $('#card_img_enlarge_img_1').attr('src','<?php echo $card_en?>');
		}else if(s==3){//正反面
            var w=$(this).data('rew');
            if(w==1){
                $('#card_img_enlarge_img_1').attr('src','<?php echo $card_en?>');
                $(this).data('rew','2');
            }else{
                $('#card_img_enlarge_img_1').attr('src','<?php echo $card_cn?>');
                $(this).data('rew','1');
            }

        }
	});
	$('#hou_bar_bt').click(function () {
		var w=$(this).data('rew');
		if(w==1){
			$('#card_top_open').show();
			$('#arrow_1').attr('src','images/arrow_2.png');
			$(this).data('rew','2');
		}else{
			$('#card_top_open').hide();
			$('#arrow_1').attr('src','images/arrow_1.png');
			$(this).data('rew','1');
		}
	});
});


//初始化	
function getWidth(){
	$('.clist_Environment_name').css({lineHeight:70/p+'px',fontSize:35/p+'px'}); 
	$('.clist_Environment_allwritten').css({lineHeight:20/p+'px',fontSize:18/p+'px'});

	//图片块
	$('#card_img_enlarge_bar').width(673/p).height(62/p).css({marginLeft:(x-673/p)/2+'px'});
	$('#card_img_enlarge_bar label').css({width:673/3/p+'px',lineHeight:64/p+'px',fontSize:24/p+'px'});
	$('#card_img_enlarge_bar_3').width(673/3/p).height(64/p);
	$('#card_img_enlarge_bar_3_lab').css({paddingLeft:30/p+'px',width:(673/3-30)/p+'px'});
	$('#card_img_enlarge_img_1').width(673/p).height(879/p).css({marginLeft:(x-673/p)/2+'px'});
	$('.close_bt').width(64/p).height(64/p);
	$('.close_bt2').width(100/p).height(100/p);
	$('.width_430').width(430/p);
	$('.HOU_img').width(40/p).css({marginTop:0/p+'px',marginRight:10/p+'px'});
	$('.arrow_img').width(7/p).css({marginTop:8/p+'px',marginRight:0/p+'px'});
	$('#card_top_bar').width(x).height(140/p).css({top:83/p+'px'});
	$('.hou_bar').width(40/p).css({marginTop:7/p+'px',marginRight:10/p+'px'});
    $('.hou_bar_lab').css({width:40/p+'px',lineHeight:30/p+'px',fontSize:18/p+'px',marginTop:15/p+'px'});
    $('#card_top_open').width(x).height(150/p).css({left:0,top:223/p+'px'});
    $('.card_top_open_bar').width(50/p).css({marginTop:30/p+'px',marginRight:35/p+'px',marginLeft:35/p+'px'});
    $('.card_top_open_img').width(50/p).css({marginTop:0/p+'px',marginRight:5/p+'px'});
    $('.card_top_open_lab').css({width:50/p+'px',lineHeight:30/p+'px',fontSize:18/p+'px'});

    $('#card_img_enlarge_img_content').width(673/p).css({marginLeft:(x-673/p)/2+'px',marginTop:20/p+'px',paddingBottom:50/p+'px'});
    $('.card_content_lab_1').css({lineHeight:70/p+'px',fontSize:30/p+'px'});
    $('.card_content_lab_2').css({lineHeight:70/p+'px',fontSize:30/p+'px',marginLeft:20/p+'px'});
    $('.card_content_lab_3').css({lineHeight:50/p+'px',fontSize:24/p+'px'});
}
</script>
<?php include_once "down.php";?>