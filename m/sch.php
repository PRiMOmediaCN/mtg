<?php
include_once "ra_global.php";
if($_GET){
	$where='1';

	//牌名
	if($_GET['n']){
		$n=str_replace("'",'&rsquo;',trim($_GET['n']));
		$en = preg_match("/^[^/x80-/xff]+$/", $n); //判断牌名是否是英文
		$cn = preg_replace("/[^一-龥]/u",'',$n);    //判断牌名是否是中文
		$where.=$cn?(" and name like '%".$n."%'"):(" and ename like '%".$n."%'");
	}
	
	
	//内文描述
	if($_GET['in']){
		$m=str_replace("'",'&rsquo;',trim($_GET['in']));
		$enm = preg_match("/^[^/x80-/xff]+$/", $m); //判断牌名是否是英文
		$cnm = preg_replace("/[^一-龥]/u",'',$m);    //判断牌名是否是中文
		$where.=$cnm?(" and intext like '%".$m."%'"):(" and eintext like '%".$m."%'");
	}
	
	//背景描述
	if($_GET['fv']){
		$mn=str_replace("'",'&rsquo;',trim($_GET['fv']));
		$enmn = preg_match("/^[^/x80-/xff]+$/", $mn); //判断牌名是否是英文
		$cnmn = preg_replace("/[^一-龥]/u",'',$mn);    //判断牌名是否是中文
		$where.=$cnmn?(" and flavor like '%".$mn."%'"):(" and eflavor like '%".$mn."%'");
	}
	
	
	//颜色
	if($_GET['cr']){
		$cr=$_GET['cr'];
		if($_GET['l'] && count($cr)<2) tellgoto('如果选择了必须多色，那么至少要选择两种颜色','index.php');
		
		$where.=' and (';
		
		//不能含有未选颜色且必须多色
		if($_GET['h'] && $_GET['l']) $where.="color='".implode(',',$cr)."'";
		
		//不能含有未选颜色且不必须多色
		if($_GET['h'] && !$_GET['l']){
			$where.=" color='".implode(',',$cr)."'";
			$where_arr=array();
			$where.=" or (";
			foreach($cr as $cr_list){
				$where_arr[]="color='".$cr_list."'";
			}
			$where.=implode(' or ',$where_arr).")";
		}
		
		
		/*$where.=$_GET['h']?(" and color='".implode(',',$cr)."'"):(
			$_GET['l']?(" and color REGEXP '".implode("' and color REGEXP '",$cr)."' "):(" and color='".implode(',',$cr)."'")
		);*/
		
		$where.=')';
	}
	
	//总费用
	if($_GET['cs']) $where.=" and costs=".$_GET['cs'];
	
	//牌池
	if($_GET['st']==1){
		$t2file = fopen("../t2.txt","r") or die("Unable to open file!");
		$t2_format=fgets($t2file);
		fclose($t2file);
		$where.=" and find_in_set(`sets`,'".$t2_format."')";
	}
	if($_GET['st']==2){
		$t2file = fopen("../mdn.txt","r") or die("Unable to open file!");
		$t2_format=fgets($t2file);
		fclose($t2file);
		$where.=" and find_in_set(`sets`,'".$t2_format."')";
	}
	
	//稀有度
	if($_GET['r']){
		$r_arr=array();
	    foreach($_GET['r'] as $r){
			$r_arr[]="rarity=".$r;
		}
		$where.=' and ('.implode(' or ',$r_arr).') ';
	}
	
	//类别
	if($_GET['ct']){
		$ct=$_GET['ct'];
		if(in_array(119,$ct) || in_array(114,$ct)){
			foreach($ct as $ct_arr){
				if($ct_arr==119 || $ct_arr==114){
					$where.=" and `prefix`=".$ct_arr;
					$ct=array_diff($ct,array($ct_arr));
				}
			}
			if(count($ct)) $where.=" and `cate`='".implode(',',$ct)."'";
		}else{
		    $where.=" and `cate`='".implode(',',$ct)."'";
		}
	}
	
	//指定环境
	if($_GET['setname']){
		//$setname=$db->ig2_want('sets','name like "%'.$_GET['setname'].'%"');
		$where.=" and sets=".$_GET['setname'];
	}
	
	//是否传奇
	if($_GET['lg']) $where.=" and legendary=1";
	
	if($_GET['crtct']){
		foreach($_GET['crtct'] as $crtct){
			$crtct_id=$db->ig2_want('crtcates','name="'.$crtct.'"');
		    if($crtct_id) $where.=" and find_in_set('".$crtct_id['id']."',`crtcate`)";
		}
	}
	
	//生物攻防
	if($_GET['cr_a']) $where.=" and power='".$_GET['cr_a']."'";
	if($_GET['cr_d']) $where.=" and toughness='".$_GET['cr_d']."'";
	
	//作者
	if($_GET['p']) $where.=" and painter like '%".$_GET['p']."%'";
	
	$translate=$where;
	
	$rows=mysql_query("select distinct `ename` from cards where ".$where);
	$rows=mysql_num_rows($rows);
	
	$where.=' order by ename limit 20';

	/*echo $where;
	exit();*/
	$cards=$db->ig2_select_distinct('ename','cards',$where);
	$count=count($cards);
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
    	<a href="index.php"><img id="close_clist" class="fl close_bt2" src="images/close_bt2.png"></a>
        <div class="width_520 fl">
            <label class="black_font fl clist_Environment_name">搜索结果</label>
        </div>
        <div class="width_520 fl">
            <label class="gray_font fl clist_Environment_allwritten">共<?php echo $rows?>张牌</label>
        </div>
        
    </div>
    <div class="fl">
    	<div class="mode_bar fl" data-req="1" data-rew="2">
            <img id="mode_bg_1" class="fl mode_bg_pl" src="images/colour_bg_h.png">
            <label id="mode_lab_1" class="posit2 black_font mode_lab_pl">文字模式</label>	
        </div>	
        <div id="switchImg" class="mode_bar fl" data-req="2" data-rew="1">
            <img id="mode_bg_2" class="fl mode_bg_pl" src="images/colour_bg.png">
            <label id="mode_lab_2" class="posit2 gray_font mode_lab_pl">图片模式</label>	
        </div>
    </div>
    <div class="fl">
        <div id="img_mode" class="width_673 fl dpl"></div>
        <div id="word_mode" class="width_673 fl">
            <div id="clist_bar_1" class="width_100 fl clist_bar" data-req="1">
			<?php 
            $k=1;
            foreach($cards as $list){
                $card=$db->ig2_want('cards','ename="'.$list['ename'].'" order by rand() limit 1');
                $this_set=$db->ig2_want('sets','id='.$card['sets']);
                ?>
                <div id="clist_box_<?php echo $card['id']?>" class="fl width_100 clist_box" data-req="<?php echo $k?>" onClick="openImgBar(<?php echo $k?>)">
                    <label class="fl clist_bar_lab1 black_font tac">
                        <img class="clist_sets_img" src="../images/rarity/<?php echo $this_set['abbr']?>_<?php echo $card['rarity']?>.png" />
                    </label>
                    <div class="clist_box_dot fl">    
                        <label class="green_font clist_bar_lab2"><?php echo $card['name']?></label>
                        <label class="black_font clist_bar_lab3">-</label>
                        <label class="gray_font clist_bar_lab4"><?php echo $card['ename']?></label>
                    </div>
                    <div class="clist_color_box tac fl"><?php getCost($card['cost']);?></div>
                </div>
                <script>
                <?php 
				$img_src=is_file('../file/'.$this_set['abbr'].'/'.$card['serial'].'.jpg')?
				                ('../file/'.$this_set['abbr'].'/'.$card['serial'].'.jpg'):
								('../file/'.$this_set['abbr'].'.e/'.$card['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
$('#img_mode').append('<img class="fl width_100" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
                </script>
                <?php 
                $k++;
            }
            ?>
            </div>
            <div id="getMorePage" data-cPage="1"></div>
            <div class="fl cardGetMore tac" onClick="getMorePage($('#getMorePage').attr('data-cPage'))">点击加载更多</div>
        </div>
    </div>
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function() {
	$('title').html('搜索 - 爱基兔万智牌');
	$('.title_lab').html('查牌工具');
	
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth();  
	pageAll();
	
	//关闭牌张
	$('.close_bt').click(function(){
		$('#img_enlarge').fadeOut(200);	
	});
});

//文字模式下  点击每条弹出图片
var img_number=<?php echo $count?>,count;
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
	if(imgDisplayed==false) imgDisplayed=true;
});

//ajax翻页
function getMorePage(page){
	$('.cardGetMore').html('<img src="images/loading.gif" id="loading" />');
	$('#loading').width(150/p);
    $.post('ra_ajax.php',{
		action:'schGetMore',
		where:"<?php echo $translate;?>",
		page: page
	},function(res){
		if(res!=0){
			$("#getMorePage").append(res);
			$("#getMorePage").attr('data-cPage',parseInt(page)+1);
			$(".cardGetMore").html('点击加载更多');
		}else{
		    $(".cardGetMore").html('没有了');
			$(".cardGetMore").click(null);
		}
	});
}

//初始化	
function getWidth(){
	//头
	$('.clist_Environment_name').css({lineHeight:70/p+'px',fontSize:35/p+'px'}); 
	$('.clist_Environment_allwritten').css({lineHeight:20/p+'px',fontSize:18/p+'px'});
    $('.close_bt2').width(100/p).height(100/p);
	$('.width_520').width(520/p);
	
	//切换文字和图片模式
	$('.mode_bar').width(327/p).height(76/p).css({marginLeft:23/p+'px',marginTop:23/p+'px'});
	$('.mode_bg_pl').width(327/p).height(76/p);
	$('.mode_lab_pl').css({width:200/p+'px',left:100/p+'px',top:26/p+'px',lineHeight:24/p+'px',fontSize:24/p+'px'});
    
	//列表
	$('.clist_bar_lab1').css({width:90/p+'px',height:65/p+'px',lineHeight:65/p+'px',fontSize:24/p+'px',background:'#f8f8f8'});
	$('.clist_bar_lab2').css({lineHeight:65/p+'px',fontSize:24/p+'px',marginLeft:10/p+'px'});
	$('.clist_bar_lab3').css({lineHeight:65/p+'px',fontSize:24/p+'px',marginLeft:10/p+'px'});
	$('.clist_bar_lab4').css({lineHeight:65/p+'px',fontSize:18/p+'px',marginLeft:10/p+'px'});
	$('.clist_colour_img').width(27/p).height(27/p).css({marginTop:19/p+'px',marginRight:10/p+'px'});
	$('.clist_color_box').width(185/p).height(65/p);
	$('.clist_sets_img').height(27/p).css({margin:'0 auto'});
	$('.clist_box_dot').width(380/p).height(65/p);
	$('.cardGetMore').width(672/p).height(68/p).css({marginTop:10/p+'px',marginBottom:30/p+'px',fontSize:30/p+'px',lineHeight:68/p+'px'});
	
	//打开图片浮层
	$('.img_mode_img').width(320/p).height(457/p).css({margin:5/p+'px'});
	$('#img_enlarge').width(x).height(y).css({left:0,top:0});
	$('#img_enlarge_bar').width(616/p).height(64/p).css({left:(x-616/p)/2+'px',top:123/p+'px'});
	$('#img_enlarge_bar label').css({width:552/p+'px',lineHeight:64/p+'px',fontSize:24/p+'px'});
	$('#img_enlarge_img_bar').width(616/p).height(879/p).css({left:0,top:65/p+'px'});
	$('.close_bt').width(64/p).height(64/p);
}	
</script>
<?php include_once "down.php";?>