<?php 
include_once "ra_global.php";
$deck=$db->ig2_want('decks','id='.$_GET['did']);
if($deck['id']){
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
	$coall+=4;
	$count_crruent=0;
}else{
	tellgoto('您的访问有误','index.php');
}
?>
<script type="text/javascript">
uaredirect("m/view_deck.php?did=<?php echo $_GET['did'];?>","");
function uaredirect(f) {
    try {
        if (document.getElementById("bdmark") != null) {
            return
        }
        var b = false;
        if (arguments[1]) {
            var e = window.location.host;
            var a = window.location.href;
            if (isSubdomain(arguments[1], e) == 1) {
                f = f + "/#m/" + a;
                b = true
            } else {
                if (isSubdomain(arguments[1], e) == 2) {
                    f = f + "/#m/" + a;
                    b = true
                } else {
                    f = a;
                    b = false
                }
            }
        } else {
            b = true
        }
        if (b) {
            var c = window.location.hash;
            if (!c.match("fromapp")) {
                if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|SymbianOS)/i))) {
                    location.replace(f)
                }
            }
        }
    } catch(d) {}
}
function isSubdomain(c, d) {
    this.getdomain = function(f) {
        var e = f.indexOf("://");
        if (e > 0) {
            var h = f.substr(e + 3)
        } else {
            var h = f
        }
        var g = /^www\./;
        if (g.test(h)) {
            h = h.substr(4)
        }
        return h
    };
    if (c == d) {
        return 1
    } else {
        var c = this.getdomain(c);
        var b = this.getdomain(d);
        if (c == b) {
            return 1
        } else {
            c = c.replace(".", "\\.");
            var a = new RegExp("\\." + c + "$");
            if (b.match(a)) {
                return 2
            } else {
                return 0
            }
        }
    }
}
</script>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="万智牌中文数据百科网站。提供查牌、套牌卡组、百科和各种中文万智牌工具。">
<meta name="keywords" content="<?php echo $deck['name'].' '.$deck['ename']?> 万智牌 牌库 中文 百科 查牌"> 
<title><?php echo $deck['name'].' - '.$deck['ename']?> - 爱基兔万智牌 - IG2</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
<script src="inc/jquery.js"></script>
<script src="inc/echarts.simple.min.js"></script>
</head>
<body>
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
        <div style="margin-top:-20px;">
            <form action="sch.php" method="get">
            <input name="n" type="text" value="<?php echo $_GET['n'] ?>" class="ipt" placeholder="输入牌名" style="height:27px;" />
            <input name="" type="submit" value="搜索" class="bt" />
            <input name="" type="button" value="高级搜索" class="bt" onclick="location.href='schfull.php'" />
            </form>
            <div class="fr" id="userbar"></div>
        </div>
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
<div class="main">
<script>
function traggleCardstyle(id){
    if(id=='dis_imag'){
	    $('#dis_imag').attr('src','images/dis_imag_hov.gif');
		$('#dis_line').attr('src','images/dis_line.gif');
		$('.deck_list_bar').attr('class','deck_list_bar_imgs');
	}else{
	    $('#dis_line').attr('src','images/dis_line_hov.gif');
		$('#dis_imag').attr('src','images/dis_imag.gif');
		$('.deck_list_bar_imgs').attr('class','deck_list_bar');
	}
}
</script>
<li style="border:none;">&nbsp;</li>
<div class="midbar deck_list">
    <h2><?php echo '<font color="#377fcf">['.$format['code'].']</font>'.$deck['name'].' - '.$deck['ename'].' <font color="#cccccc">'.$deck['player'].'</font>';
	    foreach(explode(',',$deck['colors']) as $color){?>
		<img src="images/<?php echo $color?>.png" class="coloright" />
		<?php }?>
    </h2>
    <li class="tabbar">
        <div class="tabs" onClick="traggleCardstyle('dis_line')">
            <img id="dis_line" src="images/dis_line_hov.gif"  style="width:20px;" /> 文字模式
        </div>
        <div class="tabs" onClick="traggleCardstyle('dis_imag')" >
            <img id="dis_imag" src="images/dis_imag.gif" style="width:20px;" />  图片模式
        </div>
    </li>
    <ul class="deck_list_bar fl">
    <?php 
	if(count($crts)){
		echo '<li class="headli">生物</li>';$count_crruent++;
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
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $path?>" alt="<?php echo $card['name']?>" class="cardface" /></a>
                <label class="cnum"><?php echo $crt['cnum']?></label>
                <label class="cname"><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><?php echo $card['name']?></a> - <?php echo $card['ename']?></label>
                <label class="fr"><?php getCost($card['cost']);?></label>
			</li>
		    <?php 
			$count_crruent++;
			if($count_crruent>($coall/2)){
				echo '</ul><ul class="deck_list_bar fr">';
				$count_crruent=0;
			}
		}
	}
	if(count($plan)){
		echo '<li class="headli">鹏洛客</li>';$count_crruent++;
		foreach($plan as $plans){
			$card=NULL;
			foreach($db->ig2_select('cards','ename="'.$plans['cename'].'"') as $thiscard){
				$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
				$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
				if(is_dir('file/'.$sets['abbr'])){
					$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
					$card=$thiscard;
				}
			}
			if(!$card){
				$card=$db->ig2_want('cards','ename="'.$plans['cename'].'"');
				$sets=$db->ig2_want('sets','id='.$card['sets']);
			    $side=$card['side']?($card['side']==1?'a':'b'):'';
				$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
			}
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $path?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $plans['cnum']?></label>
                <label class="cname"><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><?php echo $card['name']?></a> - <?php echo $card['ename']?></label>
                <label class="fr"><?php getCost($card['cost']);?></label>
			</li>
		    <?php 
			$count_crruent++;
			if($count_crruent>($coall/2)){
				echo '</ul><ul class="deck_list_bar fr">';
				$count_crruent=0;
			}
		}
	}
	if(count($aane)){
		echo '<li class="headli">神器/结界</li>';$count_crruent++;
		foreach($aane as $aanes){
			$card=NULL;
			foreach($db->ig2_select('cards','ename="'.$aanes['cename'].'"') as $thiscard){
				$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
				$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
				if(is_dir('file/'.$sets['abbr'])){
					$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
					$card=$thiscard;
				}
			}
			if(!$card){
				$card=$db->ig2_want('cards','ename="'.$aanes['cename'].'"');
				$sets=$db->ig2_want('sets','id='.$card['sets']);
			    $side=$card['side']?($card['side']==1?'a':'b'):'';
				$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
			}
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $path?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $aanes['cnum']?></label>
                <label class="cname"><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><?php echo $card['name']?></a> - <?php echo $card['ename']?></label>
                <label class="fr"><?php getCost($card['cost']);?></label>
			</li>
		    <?php 
			$count_crruent++;
			if($count_crruent>($coall/2)){
				echo '</ul><ul class="deck_list_bar fr">';
				$count_crruent=0;
			}
		}
	}
	if(count($spel)){
		echo '<li class="headli">法术/瞬间</li>';$count_crruent++;
		foreach($spel as $spels){
			$card=NULL;
			foreach($db->ig2_select('cards','ename="'.$spels['cename'].'"') as $thiscard){
				$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
				$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
				if(is_dir('file/'.$sets['abbr'])){
					$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
					$card=$thiscard;
				}
			}
			if(!$card){
				$card=$db->ig2_want('cards','ename="'.$spels['cename'].'"');
				$sets=$db->ig2_want('sets','id='.$card['sets']);
			    $side=$card['side']?($card['side']==1?'a':'b'):'';
				$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
			}
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $path?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $spels['cnum']?></label>
                <label class="cname"><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><?php echo $card['name']?></a> - <?php echo $card['ename']?></label>
                <label class="fr"><?php getCost($card['cost']);?></label>
			</li>
		    <?php 
			$count_crruent++;
			if($count_crruent>($coall/2)){
				echo '</ul><ul class="deck_list_bar fr">';
				$count_crruent=0;
			}
		}
	}
	if(count($land)){
		echo '<li class="headli">地</li>';$count_crruent++;
		foreach($land as $lands){
			$card=NULL;
			foreach($db->ig2_select('cards','ename="'.$lands['cename'].'"') as $thiscard){
				$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
				$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
				if(is_dir('file/'.$sets['abbr'])){
					$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
					$card=$thiscard;
				}
			}
			if(!$card){
				$card=$db->ig2_want('cards','ename="'.$lands['cename'].'"');
				$sets=$db->ig2_want('sets','id='.$card['sets']);
			    $side=$card['side']?($card['side']==1?'a':'b'):'';
				$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
			}
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $path?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $lands['cnum']?></label>
                <label class="cname"><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><?php echo $card['name']?></a> - <?php echo $card['ename']?></label>
                <label class="fr"><?php getCost($card['cost']);?></label>
			</li>
		    <?php 
			$count_crruent++;
			if($count_crruent>($coall/2)){
				echo '</ul><ul class="deck_list_bar fr">';
				$count_crruent=0;
			}
		}
	}

	echo '<li class="headli">备牌</li>';
	foreach($sideb as $sidebs){
		$card=NULL;
		foreach($db->ig2_select('cards','ename="'.$sidebs['cename'].'"') as $thiscard){
				$sets=$db->ig2_want('sets','id='.$thiscard['sets']);
				$side=$thiscard['side']?($thiscard['side']==1?'a':'b'):'';
				if(is_dir('file/'.$sets['abbr'])){
					$path='file/'.$sets['abbr'].'/'.$thiscard['serial'].$side.".jpg";
					$card=$thiscard;
				}
			}
			if(!$card){
				$card=$db->ig2_want('cards','ename="'.$sidebs['cename'].'"');
				$sets=$db->ig2_want('sets','id='.$card['sets']);
			    $side=$card['side']?($card['side']==1?'a':'b'):'';
				$path='file/'.$sets['abbr'].'.e/'.$card['serial'].$side.".jpg";
			}
		?>
		<li style="background:#f4f4f4;"><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $path?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $sidebs['cnum']?></label>
            <label class="cname"><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><?php echo $card['name']?></a> - <?php echo $card['ename']?></label>
            <label class="fr"><?php getCost($card['cost']);?></label>
		</li>
		<?php 
		$count_crruent++;
		if($count_crruent>($coall/2)){
			echo '</ul><ul class="deck_list_bar fr">';
			$count_crruent=0;
		}
	}
	?>
    </ul>
</div>



<div class="rightbar">
    <li style=" border:none; margin:8px 0 20px;">
	<?php 
	if($deck['type']==1){
		echo $match['city'].' '.strtoupper($game['abbr']).' '.date('Y',strtotime($match['mdate'])).' '.$match['mrange']?> &nbsp; 
        <select onChange="location.href='?did='+this.value">
			<?php foreach($db->ig2_select('decks','dmatch='.$match['id']) as $decks){?>
            <option value="<?php echo $decks['id']?>" <?php echo $deck['id']==$decks['id']?'selected="selected"':''?>>
                <?php echo $decks['name']?>
            </option>
            <?php }?>
        </select>
    <?php }else{?>
    网站录入 <a href="letsgo.php">我也要录入</a>
    <?php }?>
    </li>
    <div class="linebar">
        <li>法术力曲线</li>
        <?php 
		$curve_arr=explode('|',$deck['curve']);
		foreach(explode('|',$deck['curve']) as $curve){
			$curve_arr_temp=explode(',',$curve); //f_1,4
			if($curve_arr_temp[0]=='land'){
			    $v_land=$curve_arr_temp[1];
			}else{
				$v_item=substr($curve_arr_temp[0],2);
				$v_value=$curve_arr_temp[1];
				$v_res[$v_item]=$v_value;
			}
		}
		for($i=0;$i<=15;$i++){
			if($v_res[$i]){
				?>
				<li><label><?php echo $i?>费：</label>
                    <span style="width:<?php echo $v_res[$i]*8?>px; background:#690;"></span>
                    <label><font color="#cccccc" size="1"><?php echo $v_res[$i]?>张</font></label>
                </li>
				<?php 
			}
		}
		?>
    </div>

    <div class="piebar" id="piebar" style="width:300px;height:200px;"></div>
    <?php if($vo['rights']==1){?>
    <div style="clear:both">
        <select name="lang" id="lang">
            <option value="en">EN</option>
            <option value="">CN</option>
        </select>
        <select name="noland" id="noland">
            <option value="">land</option>
            <option value="1">no</option>
        </select>
        <select name="sbwater" id="sbwater">
            <option value="1">Water</option>
            <option value="">no</option>
        </select>
        <select name="uhland" id="uhland">
            <option value="1">uhland</option>
            <option value="">normal</option>
        </select>
        <select name="treasure" id="treasure">
            <option value="">noTreasure</option>
            <option value="1">yes</option>
        </select>
        <select name="usenew" id="usenew">
            <option value="">useOld</option>
            <option value="1">new</option>
        </select>
        <input name="create" type="button" value="生成" onClick="location.href='image_worker.php?id=<?php echo $_GET['did']?>&lang='+$('#lang').val()+'&noland='+$('#noland').val()+'&sbwater='+$('#sbwater').val()+'&uhland='+$('#uhland').val()+'&treasure='+$('#treasure').val()+'&usenew='+$('#usenew').val()" />
    </div>
    <?php
	}
	$sum_arr=explode(',',$deck['proportion']);
	$dataRealArray=array();
	$colorRealArray=array();
	for($i=1;$i<count($sum_arr);$i++){
		if($sum_arr[$i]){
			$color_js='';
			
			switch($i){
				case 1 : $color_js='白:'.$sum_arr[$i].'张'; $colorReal='#eee'; break;
				case 2 : $color_js='蓝:'.$sum_arr[$i].'张'; $colorReal='#09c';break;
				case 3 : $color_js='黑:'.$sum_arr[$i].'张'; $colorReal='#333';break;
				case 4 : $color_js='红:'.$sum_arr[$i].'张'; $colorReal='#c66';break;
				case 5 : $color_js='绿:'.$sum_arr[$i].'张'; $colorReal='#9c0';break;
				case 6 : $color_js='无色:'.$sum_arr[$i].'张'; $colorReal='#ccc';break;
				case 7 : $color_js='地:'.$sum_arr[$i].'张'; $colorReal='#c93';break;
				default:break;
			}
			$dataRealArray[]='{value:'.$sum_arr[$i].',name:"'.$color_js.'"}';
			$colorRealArray[]="'".$colorReal."'";
		}
	}
	?>
    <script type="text/javascript">
	$(document).ready(function() {
		var myChart = echarts.init(document.getElementById('piebar'));
		option = {
			series: [
				{
					name:'访问来源',
					type:'pie',
					radius: ['50%', '70%'],
					data:[
					<?php echo implode(',',$dataRealArray)?>
					],
					itemStyle: {
					   normal: {
						  color: function(params) {
							 // build a color map as your need.
							 var colorList = [
							  <?php echo implode(',',$colorRealArray)?>
							 ];
							 return colorList[params.dataIndex]
						  }
					   }
					}
				}
			]
		};
        myChart.setOption(option);
	});
	</script>    
</div>
<?php include_once "down.php";?>