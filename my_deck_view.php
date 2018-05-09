<?php include_once "top.php";
if($_GET['did']){
	$deck=$db->ig2_want('my_decks','id='.$_GET['did']);
	$vo=$db->ig2_want('volunteer','id='.$deck['uid']);
	$format=$db->ig2_want('formats','id='.$deck['format']);
	$crts=$db->ig2_select('my_deck_list','did='.$deck['id'].' and ismain=1 and ccate=1');
	$plan=$db->ig2_select('my_deck_list','did='.$deck['id'].' and ismain=1 and ccate=2');
	$aane=$db->ig2_select('my_deck_list','did='.$deck['id'].' and ismain=1 and ccate=3');
	$spel=$db->ig2_select('my_deck_list','did='.$deck['id'].' and ismain=1 and ccate=4');
	$land=$db->ig2_select('my_deck_list','did='.$deck['id'].' and ismain=1 and ccate=5');
	$othe=$db->ig2_select('my_deck_list','did='.$deck['id'].' and ismain=1 and ccate=6');
	$sideb=$db->ig2_select('my_deck_list','did='.$deck['id'].' and ismain=0');
	$coall=count($crts)+count($plan)+count($aane)+count($spel)+count($land)+count($othe)+count($sideb);
	$coall+=4;
	$count_crruent=0;
}else{
	tellgoto('您的访问有误','index.php');
}
?>
<script type="text/javascript" src="inc/Chart.js"></script>
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
<div class="midbar">
    <h2 style="margin-bottom:30px; padding-bottom:10px; border-bottom:1px solid #ccc">
	    <?php echo '['.$format['code'].'] '.$deck['name'].' - '.$deck['ename'].' <font color="#ccc">by '.$vo['voname'].'</font>';?>
        <img id="dis_line" src="images/dis_line_hov.gif" onClick="traggleCardstyle(this.id)" style="width:20px;" />
        <img id="dis_imag" src="images/dis_imag.gif" onClick="traggleCardstyle(this.id)" style="width:20px;" />
        <?php
	    foreach(explode(',',$deck['colors']) as $color){?>
		<img src="images/<?php echo $color?>.png" class="coloright" />
		<?php }?>
    </h2>
    
    <ul class="deck_list_bar fl">
    <?php 
	if(count($crts)){
		echo '<li class="headli">生物</li>';$count_crruent++;
		foreach($crts as $crt){
			$card=$db->ig2_want('cards','id='.$crt['cid']);
			$sets=$db->ig2_want('sets','id='.$card['sets']);
			$side=$card['side']?($card['side']==1?'a':'b'):'';
			$imgSrc=is_file("file/".$sets['abbr']."/".$card['serial'].$side.".jpg")?("file/".$sets['abbr']."/".$card['serial'].$side.".jpg"):("file/".$sets['abbr'].".e/".$card['serial'].".jpg");
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $imgSrc?>" alt="<?php echo $card['name']?>" class="cardface" /></a>
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
			$card=$db->ig2_want('cards','id='.$plans['cid']);
			$sets=$db->ig2_want('sets','id='.$card['sets']);
			$side=$card['side']?($card['side']==1?'a':'b'):'';
			$imgSrc=is_file("file/".$sets['abbr']."/".$card['serial'].$side.".jpg")?("file/".$sets['abbr']."/".$card['serial'].$side.".jpg"):("file/".$sets['abbr'].".e/".$card['serial'].".jpg");
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $imgSrc?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $plans['cnum']?></label>
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
			$card=$db->ig2_want('cards','id='.$aanes['cid']);
			$sets=$db->ig2_want('sets','id='.$card['sets']);
			$side=$card['side']?($card['side']==1?'a':'b'):'';
			$imgSrc=is_file("file/".$sets['abbr']."/".$card['serial'].$side.".jpg")?("file/".$sets['abbr']."/".$card['serial'].$side.".jpg"):("file/".$sets['abbr'].".e/".$card['serial'].".jpg");
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $imgSrc?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $aanes['cnum']?></label>
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
			$card=$db->ig2_want('cards','id='.$spels['cid']);
			$sets=$db->ig2_want('sets','id='.$card['sets']);
			$side=$card['side']?($card['side']==1?'a':'b'):'';
			$imgSrc=is_file("file/".$sets['abbr']."/".$card['serial'].$side.".jpg")?("file/".$sets['abbr']."/".$card['serial'].$side.".jpg"):("file/".$sets['abbr'].".e/".$card['serial'].".jpg");
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $imgSrc?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $spels['cnum']?></label>
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
	if(count($othe)){
		echo '<li class="headli">其他</li>';$count_crruent++;
		foreach($othe as $other){
			$card=$db->ig2_want('cards','id='.$other['cid']);
			$sets=$db->ig2_want('sets','id='.$card['sets']);
			$side=$card['side']?($card['side']==1?'a':'b'):'';
			$imgSrc=is_file("file/".$sets['abbr']."/".$card['serial'].$side.".jpg")?("file/".$sets['abbr']."/".$card['serial'].$side.".jpg"):("file/".$sets['abbr'].".e/".$card['serial'].".jpg");
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $imgSrc?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $other['cnum']?></label>
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
			$card=$db->ig2_want('cards','id='.$lands['cid']);
			$sets=$db->ig2_want('sets','id='.$card['sets']);
			$side=$card['side']?($card['side']==1?'a':'b'):'';
			$imgSrc=is_file("file/".$sets['abbr']."/".$card['serial'].$side.".jpg")?("file/".$sets['abbr']."/".$card['serial'].$side.".jpg"):("file/".$sets['abbr'].".e/".$card['serial'].".jpg");
			?>
			<li><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $imgSrc?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $lands['cnum']?></label>
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
		$card=$db->ig2_want('cards','id='.$sidebs['cid']);
		$sets=$db->ig2_want('sets','id='.$card['sets']);
		$side=$card['side']?($card['side']==1?'a':'b'):'';
		$imgSrc=is_file("file/".$sets['abbr']."/".$card['serial'].$side.".jpg")?("file/".$sets['abbr']."/".$card['serial'].$side.".jpg"):("file/".$sets['abbr'].".e/".$card['serial'].".jpg");
		?>
		<li style="background:#f4f4f4;"><a href="card.php?id=<?php echo $card['id']?>" target="_blank"><img src="<?php echo $imgSrc?>" alt="<?php echo $card['name']?>" class="cardface" /></a><label class="cnum"><?php echo $sidebs['cnum']?></label>
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
    <li style="margin:14px 0 20px;"><a href="my_decks.php">返回</a></li>
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
                    <span style="width:<?php echo $v_res[$i]*8?>px;"><img src="images/<?php echo $i%5;?>.jpg" /></span>
                    <label><font color="#cccccc" size="1"><?php echo $v_res[$i]?>张</font></label>
                </li>
				<?php 
			}
		}
		?>
    </div>

    <div class="piebar">
        <!-- PTV用户行为峰值占比调整  -->        
        <div style="float:left; margin:0; padding:0; width:100%;">
            <canvas id="chart-area_1" />
        </div>
        <!--预加载纹理图片-->
        <img src="images/1.jpg" style="display:none"/>
        <img src="images/2.jpg" style="display:none"/>
        <img src="images/3.jpg" style="display:none"/>
        <img src="images/4.jpg" style="display:none"/>
        <img src="images/5.jpg" style="display:none"/>
        <img src="images/6.jpg" style="display:none"/>
        <img src="images/7.jpg" style="display:none"/>
    </div>
    
    <?php $sum_arr=explode(',',$deck['proportion']);?>
    <script type="text/javascript">
	$(document).ready(function() {
		
		//建立数据数组
		var doughnutData = [
		    <?php
			//总数、白、蓝、黑、红、绿、无、地 
			for($i=1;$i<count($sum_arr);$i++){
				if($sum_arr[$i]){
					$color_js='';
					switch($i){
					    case 1 : $color_js='白:'.$sum_arr[$i].'张'; break;
						case 2 : $color_js='蓝:'.$sum_arr[$i].'张'; break;
						case 3 : $color_js='黑:'.$sum_arr[$i].'张'; break;
						case 4 : $color_js='红:'.$sum_arr[$i].'张'; break;
						case 5 : $color_js='绿:'.$sum_arr[$i].'张'; break;
						case 6 : $color_js='无色:'.$sum_arr[$i].'张'; break;
						case 7 : $color_js='地:'.$sum_arr[$i].'张'; break;
						default:break;
					}
					?>
					{
						value: <?php echo $sum_arr[$i]?>,	//牌张数
						scale: <?php echo round(($sum_arr[$i]/$sum_arr[0]),2)*100?>,	//百分比
						color:"#F7464A",	//颜色
						highlight: "#FF5A5E",	//不知道，看意思是高光
						pattern:'images/<?php echo $i?>.jpg',	//纹理图片
						label: "<?php echo $color_js?>"	//描述文字
						
					},
					<?php 
				}
			}
			?>
		];
		//建立设置对象
		var op1={
			responsive : true,	//是否resize
			showTooltips: false,	//是否显示tooltip，由于咱们不要求鼠标经过显示，而是直接显示，所以这里设成false，如果设成true，每次鼠标经过会把所有百分比清空然后显示鼠标经过的块
			tooltipTemplate: "<%= label %>",	//tooltip显示内容，这里是显示百分比
			scaleYPadding: -13,	//文字到tooltip背景外沿的距离，这里用负数来调整文字位置，这个-15是根据文字大小14设的
			tooltipTitleFontSize: 12,	//用这句话可以调整文字大小，默认是14
			animationEasing: "easeInOutQuint",	//圆环动画方式
			scaleFillColor: "rgba(0,0,0,0)",	//tooltip背景颜色，支持alpha通道，设成了透明
			onAnimationComplete:function(){	//动画结束之后的回调函数，在这里显示tooltip
				myDoughnut1.showscale();
			}
		}
		var ctx_1 = document.getElementById("chart-area_1").getContext("2d"); //获取canvas的绘图对象
		//实例化一个新的chart对象，其中构造函数传入的是canvas绘图对象，然后用doughnut令chart对象成为一个饼状图，其他形状图用别的方法，传入的参数分别是饼状图数据和饼状图设置，然后返回一个饼状图对象赋值给一个变量，之后通过对这个变量的操作就可以操作这个饼状图
		window.myDoughnut1 = new Chart(ctx_1).Doughnut(doughnutData, op1);
		//其他的图形和动画方式可以通过官网查询，官网地址在chart.js的开头，关于饼状图上显示百分比部分是经过修改得到的，并非官方版本	
	});
	</script>    
</div>
<?php include_once "down.php";?>