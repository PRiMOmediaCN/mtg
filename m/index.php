<?php 
include_once "ra_global.php";
include_once "top.php";
?>
<div id="main_1">
<form action="sch.php" method="get">
	<input id="cards_list_name" type="hidden" name="st" value="0" />
    <div class="fl">
        <div class="cards_bar fl" data-req="1">
            <img id="cards_bg_1" class="fl cards_bg_pl" src="images/cards_bg_h.png">
            <label id="cards_lab_1" class="posit2 black_font cards_lab_pl">全部</label>	
        </div>	
        <div class="cards_bar fl" data-req="2">
            <img id="cards_bg_2" class="fl cards_bg_pl" src="images/cards_bg.png">
            <label id="cards_lab_2" class="posit2 gray_font cards_lab_pl">T2</label>	
        </div>
        <div class="cards_bar fl" data-req="3">
            <img id="cards_bg_3" class="fl cards_bg_pl" src="images/cards_bg.png">
            <label id="cards_lab_3" class="posit2 gray_font cards_lab_pl">摩登</label>	
        </div>
    </div>
    <div class="fl">
        <input id="cards_name" class="input_pl fl" type="text" name="n" placeholder="输入中文或英文牌名，例如：思绪" />
        <input type="submit" id="search_bt" class="fl" value="搜索" />
    </div>
    <div id="energy_box" class="fl">
        <div style="display:none" id="colorbox">
        <input name="cr[]" type="checkbox" value="w" />
        <input name="cr[]" type="checkbox" value="u" />
        <input name="cr[]" type="checkbox" value="b" />
        <input name="cr[]" type="checkbox" value="r" />
        <input name="cr[]" type="checkbox" value="g" />
        <input name="cr[]" type="checkbox" value="c" />
        </div>
        <div data-req="1" class="energy_bar fl">
            <img class="energy_img_pl" src="images/energy_img_1.png">
        </div>
        <div data-req="2" class="energy_bar fl">
            <img class="energy_img_pl" src="images/energy_img_2.png">
        </div>
        <div data-req="3" class="energy_bar fl">
            <img class="energy_img_pl" src="images/energy_img_3.png">
        </div>
        <div data-req="4" class="energy_bar fl">
            <img class="energy_img_pl" src="images/energy_img_4.png">
        </div>
        <div data-req="5" class="energy_bar fl">
            <img class="energy_img_pl" src="images/energy_img_5.png">
        </div>
        <div data-req="6" class="energy_bar fl">
            <img class="energy_img_pl" src="images/energy_img_6.png">
        </div>
    </div>
    <div class="fl">
        <div class="colour_bar fl" data-req="1" data-rew="1">
            <img id="colour_bg_1" class="fl colour_bg_pl" src="images/colour_bg.png">
            <input type="hidden" name="l" value="0" />
            <label id="colour_lab_1" class="posit2 gray_font colour_lab_pl">必须多色</label>	
        </div>  
        <div id="colour_bar_2" class="colour_bar fl" data-req="2" data-rew="2">
            <img id="colour_bg_2" class="fl colour_bg_pl" src="images/colour_bg_h.png">
            <input type="hidden" name="h" value="1" />
            <label id="colour_lab_2" class="posit2 black_font colour_lab_pl">不能含有未选颜色</label>	
        </div>   
    </div>
    <hr class="fl" style=" height:1px; width:100%; background:#ccc; border:none;">
    <div class="fl">
        <div class="fl category_left">
            <img id="category_0" data-req="0" class="fl category_pl category_img_pl" src="images/category_0_h.jpg">		
        </div>
        <div style="display:none" id="categorybox">
        <input name="ct[]" type="checkbox" value="1" />
        <input name="ct[]" type="checkbox" value="2" />
        <input name="ct[]" type="checkbox" value="3" />
        <input name="ct[]" type="checkbox" value="4" />
        <input name="ct[]" type="checkbox" value="5" />
        <input name="ct[]" type="checkbox" value="6" />
        <input name="ct[]" type="checkbox" value="7" />
        <input name="ct[]" type="checkbox" value="119" />
        <input name="ct[]" type="checkbox" value="114" />
        <input name="ct[]" type="checkbox" value="100" />
        </div>
        <div id="category_bar" class="fl category_right">
            <img data-req="1" data-rew="1" class="fl category_pl category_img_pl" src="images/category_1.jpg">
            <img data-req="2" data-rew="1" class="fl category_pl category_img_pl" src="images/category_2.jpg">
            <img data-req="3" data-rew="1" class="fl category_pl category_img_pl" src="images/category_3.jpg">
            <img data-req="4" data-rew="1" class="fl category_pl category_img_pl" src="images/category_4.jpg">
            <img data-req="5" data-rew="1" class="fl category_pl category_img_pl" src="images/category_5.jpg">
            <img data-req="6" data-rew="1" class="fl category_pl category_img_pl" src="images/category_6.jpg">
            <img data-req="7" data-rew="1" class="fl category_pl category_img_pl" src="images/category_7.jpg">
            <img data-req="8" data-rew="1" class="fl category_pl category_img_pl" src="images/category_8.jpg">
            <img data-req="9" data-rew="1" class="fl category_pl category_img_pl" src="images/category_9.jpg">
            <img data-req="10" data-rew="1" class="fl category_pl category_img_pl" src="images/category_10.jpg">		
        </div>   
    </div>
    <div class="fl">
        <div class="fl category_left">
            <img id="category_color_0" data-req="0" class="fl category_color_pl category_img_pl" src="images/category_color_0_h.jpg">		
        </div>
        <div style="display:none" id="category_color_box">
        <input name="r[]" type="checkbox" value="4" />
        <input name="r[]" type="checkbox" value="3" />
        <input name="r[]" type="checkbox" value="2" />
        <input name="r[]" type="checkbox" value="1" />
        <input name="r[]" type="checkbox" value="5" />
        </div>
        <div id="category_color_bar" class="fl category_right">
            <img data-req="1" data-rew="1" class="fl category_color_pl category_img_pl" src="images/category_color_1.jpg">
            <img data-req="2" data-rew="1" class="fl category_color_pl category_img_pl" src="images/category_color_2.jpg">
            <img data-req="3" data-rew="1" class="fl category_color_pl category_img_pl" src="images/category_color_3.jpg">
            <img data-req="4" data-rew="1" class="fl category_color_pl category_img_pl" src="images/category_color_4.jpg">
            <img data-req="5" data-rew="1" class="fl category_color_pl category_img_pl" src="images/category_color_5.jpg">
        </div>   
    </div>
    <div class="fl">
        <div class="legends_bar fl">
            <img id="legends_bg_1" class="fl legends_bg_pl" src="images/legends_bg.png">
            <input id="lg_check" type="hidden" name="lg" value="" />
            <label id="legends_lab_1" class="posit2 gray_font legends_lab_pl">传奇</label>	
        </div>
        <input id="setid" type="hidden" name="setid" value="" />
        <input id="setname" class="fl search_ipt" type="text" name="setname" placeholder="输入中文版本名称，例如：依夏兰" onBlur="getSchSetname($(this).val())"/>
    </div>

    <div id="Biological_categories" class="fl" style="position:relative;">
        <img src="images/crtcateyes.png" id="crtcateyes" class="posit2 dpl" onClick="getCrtCates()" />
        <input id="Biological_categories_ipt" class="fl" type="text" name="Biological_categories_name"
               placeholder="请输入中文生物类别，例如：人类" onInput="$('#crtcateyes').show()" />
    </div>
    <div class="fl" id="crtad">
        <label id="defense_lab" class="fl tac gray_font">生物攻防：</label>
        <div class="fl defense_bar">
            <img id="attack_bg" class="fl defense_img" src="images/attack_bg.jpg">
            <select name="cr_a" class="defense_slt posit2">
                <option value="">不限</option>
                <option value="*">*</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
            </select>	
        </div>
        <div class="fl defense_bar">
            <img id="Anti_bg" class="fl defense_img" src="images/Anti_bg.jpg">	
            <select name="cr_d" class="defense_slt posit2">
                <option value="">不限</option>
                <option value="*">*</option>
                <option value="1+*">1+*</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
            </select>
        </div>
    </div>
    <div class="fl">
        <input class="fl search_ipt" type="text" name="in" placeholder="输入中文内容描述，例如：飞行" />
        <input class="fl search_ipt" type="text" name="fv" placeholder="输入中文背景描述，例如：匿玉玺孙坚背约" />
        <input class="fl search_ipt" type="text" name="p" placeholder="输入英文画家姓名，例如：Jung Park" />
    </div>
    <div class="fl">
        <input type="submit" value="&nbsp;" id="search_bt2" class="fl" />
    </div>
</form>    
</div>
<script>
var x,y,p,lt=1,lg=1;
$(document).ready(function() {
	$('title').html('首页 - 爱基兔万智牌');
	$('.title_lab').html('查牌工具');
	
	x=parseInt(window.innerWidth);
	y=parseInt(window.innerHeight);
	p=720/x;
	getWidth();  
	pageAll();

	// 点击6种能量
	$('.energy_bar').click(function(){
		var s=$(this).data('req');
		if($(this).hasClass("bg_ccc")){
			$(this).removeClass("bg_ccc");
		}else{
			$(this).addClass("bg_ccc");
		}
		if($('#colorbox').children('input').eq(s-1).attr('checked')) $('#colorbox').children('input').eq(s-1).attr('checked',false);
	    else $('#colorbox').children('input').eq(s-1).attr('checked',true);
	});

	// 	选择类型  T2 或者  摩登
	$('.cards_bar').click(function(){
		var s=$(this).data('req');
		$('.cards_lab_pl').removeClass('black_font').addClass('gray_font');
		$('#cards_lab_'+s).removeClass('gray_font').addClass('black_font');
		$('.cards_bg_pl').attr('src','images/cards_bg.png');	
		$('#cards_bg_'+s).attr('src','images/cards_bg_h.png');	
		$('#cards_list_name').val(s-1);
	});
	
	// 	选择多色 或者  不能含有未选颜色
	$('.colour_bar').click(function(){
		var s=$(this).data('req');
		if($(this).data('rew')==1){
			$('#colour_lab_'+s).removeClass('gray_font').addClass('black_font');
			$('#colour_bg_'+s).attr('src','images/colour_bg_h.png');	
			$(this).find('input').val(1);
			$(this).data('rew','2');
		}else{
			$('#colour_lab_'+s).removeClass('black_font').addClass('gray_font');
			$('#colour_bg_'+s).attr('src','images/colour_bg.png');
			$(this).find('input').val(0);
			$(this).data('rew','1');
		}
	});
	//选择牌类别 结界神器鹏洛克等
	$('.category_pl').click(function(){
		var s=$(this).data('req');
		console.log(s);
		$('#category_0').attr('src','images/category_0.jpg');
		if($(this).data('rew')==1){
			$(this).attr('src','images/category_'+s+'_h.jpg');
			$('#categorybox').children().eq(s-1).attr('checked',true);
			if(s==4) $('#crtad').show();
			$(this).data('rew','2');
		}else{
			$(this).attr('src','images/category_'+s+'.jpg');
			$('#categorybox').children().eq(s-1).attr('checked',false);
			if(s==4) $('#crtad').hide();
			$(this).data('rew','1');
		}
	});
	
	$('#category_0').click(function(){
		var s=$(this).data('req');
		$('#category_bar').children().each(function(){
			var j=$(this).data('req');
			$(this).attr('src','images/category_'+j+'.jpg');
			$(this).data('rew','1');
		})
		$('#categorybox').children().attr('checked',false);
		$('#category_0').attr('src','images/category_0_h.jpg');
	});
	//选择牌类别    金银铁等
	$('.category_color_pl').click(function(){
		var s=$(this).data('req');
		$('#category_color_0').attr('src','images/category_color_0.jpg');
		if($(this).data('rew')==1){
			$(this).attr('src','images/category_color_'+s+'_h.jpg');	
			$('#category_color_box').children().eq(s-1).attr('checked',true);
			$(this).data('rew','2');
		}else{
			console.log(s);
			$(this).attr('src','images/category_color_'+s+'.jpg');
			$('#category_color_box').children().eq(s-1).attr('checked',false);
			$(this).data('rew','1');
		}
	});
	
	$('#category_color_0').click(function(){
		var s=$(this).data('req');
		$('#category_color_bar').children().each(function(){
			var j=$(this).data('req');
			$(this).attr('src','images/category_color_'+j+'.jpg');
			$(this).data('rew','1');
		});
		$('#category_color_box').children().attr('checked',false);
		$('#category_color_0').attr('src','images/category_color_0_h.jpg');
	});
	
	//选择传奇
	
	$('.legends_bar').click(function(){
		if(lg==1){
			$('.legends_lab_pl').removeClass('gray_font').addClass('black_font');
			$('.legends_bg_pl').attr('src','images/legends_bg_h.png');
			$('#lg_check').val(1);
			lg=2;
		}else{
			$('.legends_lab_pl').removeClass('black_font').addClass('gray_font');
			$('.legends_bg_pl').attr('src','images/legends_bg.png');	
			$('#lg_check').val('');
			lg=1;	
		}
	});
});

//获取生物类别
var es=1;
function getCrtCates(){
	var s=$('#Biological_categories_ipt').val();
	if(s!==''){
		if(es<=3){
			$('#Biological_categories').prepend('<div class="bc_div fl" onclick="$(this).remove()"><input name="crtct[]" type="hidden" value="'+s+'"><label class="bc_lab white_font fl">'+s+'</label><img src="images/crtCateCloseBt.png" class="fl crtCateCloseBt" /></div>');
			$('.bc_div').width(112/p).height(44/p).css({marginLeft:15/p+'px',marginTop:15/p+'px',borderRadius:10/p+'px'});
			$('.bc_lab').css({width:77/p+'px',fontSize:24/p+'px',lineHeight:44/p+'px',color:"white",textAlign:'center'});
			$('#Biological_categories_ipt').width(650/p-(es*142/p));
			$('.crtCateCloseBt').width(30/p).css({marginTop:6/p+'px',marginRight:5/p+'px'});
			es++;
		}else{
			alert('最多输入3个生物类别');
		}
		$('#Biological_categories_ipt').val('');
	}
}

//获取版本
function getSchSetname(name){
	if(name){
		$.post('ra_ajax.php',{
			action:'getSchSetname',
			setname:name
		},function(res){
			if(res=='no'){
				alert('未找到对应版本，请重新输入');
			}else if(res=='null'){
				return;
			}else{
			    $('#setid').val(res);
			}
		});
	}
}

//初始化	
function getWidth(){
	$('hr').css({marginBottom:23/p+'px',marginTop:23/p+'px'});
	
	$('.cards_bar').width(212/p).height(76/p).css({marginLeft:21/p+'px',marginTop:23/p+'px'});
	$('.cards_bg_pl').width(212/p).height(76/p);
	$('.cards_lab_pl').css({width:80/p+'px',left:100/p+'px',top:26/p+'px',lineHeight:24/p+'px',fontSize:24/p+'px'});
	$('.input_pl').width(450/p).height(67/p).css({marginLeft:23/p+'px',marginTop:23/p+'px',padding:0,paddingLeft:20/p+'px',fontSize:24/p+'px'});
	$('#search_bt').width(200/p).height(67/p).css({marginTop:23/p+'px',border:0,fontSize:24/p+'px'});
	$('#energy_box').css({marginLeft:12/p+'px',marginTop:12/p+'px'});
	$('.energy_bar').width(100/p).height(100/p).css({borderRadius:50/p+'px',marginLeft:12/p+'px',marginTop:12/p+'px'});
	$('.energy_img_pl').width(82/p).css({marginLeft:9/p+'px',marginTop:9/p+'px'});
	$('.colour_bar').width(332/p).height(76/p).css({marginLeft:20/p+'px',marginTop:23/p+'px'});
    $('#colour_bar_2').css({marginLeft:18/p+'px'});
	$('.colour_bg_pl').width(332/p).height(76/p);
	$('.colour_lab_pl').css({width:200/p+'px',left:100/p+'px',top:26/p+'px',lineHeight:24/p+'px',fontSize:24/p+'px'});
	$('.category_img_pl').width(99/p).height(136/p).css({marginLeft:17/p+'px',marginTop:14/p+'px'});
	$('.category_left').width(99/p).css({marginLeft:2/p+'px'});
	$('.category_right').width(589/p).css({marginLeft:18/p+'px'});
	$('.legends_bar').width(215/p).height(76/p).css({marginLeft:20/p+'px',marginTop:23/p+'px'});
	$('.legends_bg_pl').width(215/p).height(76/p);
	$('.legends_lab_pl').css({width:80/p+'px',left:100/p+'px',top:26/p+'px',lineHeight:24/p+'px',fontSize:24/p+'px'});
	$('#Biological_categories').width(675/p).height(74/p).css({marginLeft:20/p+'px',marginTop:23/p+'px'});
	$('#Biological_categories_ipt').css({width:655/p+'px',height:70/p+'px',fontSize:24/p+'px',paddingLeft:20/p+'px'});
	$('#crtcateyes').width(50/p).css({right:15/p+'px',top:15/p+'px'});
	$('#defense_lab').width(222/p).height(76/p).css({lineHeight:76/p+'px',fontSize:30/p+'px',marginTop:23/p+'px',marginLeft:10/p+'px'});
	$('.defense_bar').width(217/p).height(76/p).css({marginLeft:17/p+'px',marginTop:23/p+'px'});
	$('.defense_img').width(217/p).height(76/p);
	$('.defense_slt').width(153/p).height(76/p).css({left:61/p+'px',top:0+'px',paddingLeft:20/p+'px',fontSize:24/p+'px'});
	$('.search_ipt').css({width:652/p+'px',height:68/p+'px',fontSize:24/p+'px',padding:0,paddingLeft:20/p+'px',marginLeft:23/p+'px',marginTop:23/p+'px'});
	$('#search_bt2').width(675/p).height(84/p).css({marginLeft:(x-673/p)/2+'px',marginTop:23/p+'px'});
	$('#setname').css({width:423/p+'px',height:73/p+'px',padding:0,paddingLeft:20/p+'px',fontSize:24/p+'px',marginLeft:18/p+'px'});
}
</script>
<?php include_once "down.php";?>