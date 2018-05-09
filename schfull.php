<?php include_once "top.php";?>
<div class="inbar">
    <h1>高级搜索 <span></span></h1>
    <ul style="float:left;width:760px;">
        <li><span style="line-height:22px;">* 牌名、内文描述和背景描述都支持<strong>中英文</strong>模糊搜索，可同时填写不同语言的任意词汇；</span><br>
            <span style="line-height:22px;color:#09c;">* 所有复选框如没有任何勾选则默认为「<strong>全部</strong>」。</span>
        </li>
        <form method="get" action="sch.php">
        <li><label>牌名</label><input name="n" type="text" value="" class="ipt" /> <input name="schfull" type="submit" value="搜索" /></li>        
        <li><label>颜色选择</label>
            <input name="cr[]" type="checkbox" value="w" /><img src="images/W.png" width="30" />
            <input name="cr[]" type="checkbox" value="u" /><img src="images/U.png" width="30" />
            <input name="cr[]" type="checkbox" value="b" /><img src="images/B.png" width="30" />
            <input name="cr[]" type="checkbox" value="r" /><img src="images/R.png" width="30" />
            <input name="cr[]" type="checkbox" value="g" /><img src="images/G.png" width="30" />
        </li>
        <li><label>颜色选项</label>
            <input name="l" type="checkbox" value="1" /> 必须多色 
            <span><input name="h" type="checkbox" value="1" checked="checked" /> 不能含有未选颜色</span>
        </li>
        
        <li><label>法术力</label>
            <input name="c" id="cost" type="text" value="" class="ipt" style="width:208px;" /> 
            <span><input name="" type="button" onclick="document.getElementById('cost').value=''" value="清空" /></span>
            <select name="cs" id="cs">
                <option value="">总费用</option>
                <?php for($i=0;$i<=16;$i++){?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php }?>
            </select><span><a href="javascript:void(0)" onclick="document.getElementById('clrcode').style.display=''">法术力代码</a></span>
        </li>
        
        <script language="javascript">
        function getCostcodeInit(v){
		    document.getElementById('cost').value=document.getElementById('cost').value+v
		}
        </script>
        <li id="clrcode" style="display:none;"><label>&nbsp;</label>
            <label style="width:500px;">
            <div class="clrblk" onclick="getCostcodeInit('B')"><img src="images/B.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('W')"><img src="images/W.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('U')"><img src="images/U.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('R')"><img src="images/R.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('G')"><img src="images/G.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{W/B}')"><img src="images/Q.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{B/R}')"><img src="images/L.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{B/G}')"><img src="images/J.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{U/B}')"><img src="images/D.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{R/W}')"><img src="images/S.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{R/G}')"><img src="images/K.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{U/R}')"><img src="images/I.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{G/W}')"><img src="images/N.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{W/U}')"><img src="images/A.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{G/U}')"><img src="images/M.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{BP}')"><img src="images/H.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{WP}')"><img src="images/E.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{UP}')"><img src="images/P.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('{RP}')"><img src="images/F.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('C')"><img src="images/C.png" /></div>
            <div class="clrblk" onclick="getCostcodeInit('X')"><img src="images/X.png" /></div>
            <div class="clrblk" style="width:120px;"><img src="images/0.png" /> - <img src="images/15.png" /></div>
            </label>
        </li>
        <li><label>内文描述</label><input name="in" type="text" value="" class="ipt" /></li>
        <li><label>牌池</label>
            <label><input name="st" type="radio" value="0" checked="checked" />全部</label>
            <label><input name="st" type="radio" value="1" />T2</label>
            <label><input name="st" type="radio" value="2" /> 摩登</label>
            <label style="width:230px;color:#09c;">* 缩小搜索范围能够提高搜索速度</label>
        </li>
        <li><label>稀有度</label>
            <label><input name="r[]" type="checkbox" value="4" />秘稀</label>
            <label><input name="r[]" type="checkbox" value="3" />金</label>
            <label><input name="r[]" type="checkbox" value="2" />银</label>
            <label><input name="r[]" type="checkbox" value="1" />铁</label>
        </li>
        <script language="javascript">
		
        function isPermanent(){
		    if(document.getElementById('pm').checked==true){
			    document.getElementById('cate1').checked=true;
				document.getElementById('cate2').checked=true;
				document.getElementById('cate3').checked=true;
				document.getElementById('cate4').checked=true;
				document.getElementById('cate5').checked=true;
				document.getElementById('cate120').checked=true;
				
			}else{
			    document.getElementById('cate1').checked=false;
				document.getElementById('cate2').checked=false;
				document.getElementById('cate3').checked=false;
				document.getElementById('cate4').checked=false;
				document.getElementById('cate5').checked=false;
				document.getElementById('cate120').checked=false;
			}
		}
		function isNonPermanent(){
		    if(document.getElementById('npm').checked==true){
			    document.getElementById('cate6').checked=true;
				document.getElementById('cate7').checked=true;
			}else{
			    document.getElementById('cate6').checked=false;
				document.getElementById('cate7').checked=false;
			}
		}
        </script>
        
		<li><label>类别</label>
            <label><input name="pm" id="pm" type="checkbox" value="" onclick="isPermanent()" /> 永久物</label>
			<?php foreach($db->ig2_select('cates','belong=1 and pid=0') as $cate1){?>
            <label><input name="ct[]" id="cate<?php echo $cate1['id'] ?>" type="checkbox" value="<?php echo $cate1['id'] ?>" /> <?php echo $cate1['name'] ?></label>
            <?php }?>
        </li>
        <li><label>&nbsp;</label>
            <label><input name="npm" id="npm" type="checkbox" value="" onclick="isNonPermanent()" /> 非永久</label>
            <?php foreach($db->ig2_select('cates','belong=2 and pid=0') as $cate2){?>
            <label><input name="ct[]" id="cate<?php echo $cate2['id'] ?>" type="checkbox" value="<?php echo $cate2['id'] ?>" /> <?php echo $cate2['name'] ?></label>
            <?php }?>
        </li>
        <script>
        var http = createXMLHTTP(); 
		function getsubsets(cid){
			var url = "ra_ajax.php?subset="+cid;
			http.open("GET", url, true); 
			http.onreadystatechange = getValue; 
			http.send(null);
		}
		function getValue()  { 
			if (http.readyState == 4)  {
				var backInner = http.responseText; 
				document.getElementById("subset").innerHTML = backInner;
			}
		}
        </script>
        <li style="display:none;"><label>生物类别</label><input name="crtcate" value="" /></li>
        <!--<li><label>制定版本</label>
            <label style="width:60px;">
            <select name="getsubset" onchange="getsubsets(this.value)">
                <option value="1">扩展</option>
                <option value="2">核心</option>
                <option value="3">其他</option>
            </select>
            </label>
            <label id="subset">
            <select name="sets" onchange="getsetcounter(this.value)">
            <?php foreach($db->ig2_select('sets','isroot=1 and belong=1') as $rset){?>
                <option value="<?php echo $rset['id'] ?>"> - <?php echo $rset['name'] ?> (<?php echo substr($rset['pub'],0,4) ?>)</option>
                <?php foreach($db->ig2_select('sets','pid='.$rset['id']) as $sset){?>
                <option value="<?php echo $sset['id'] ?>">&nbsp;&nbsp;<?php echo $sset['name'] ?></option>
                <?php }?>
            <?php }?>
            </select>
            </label>
        </li>-->
        <li><label>超类</label>
            <?php foreach($db->ig2_select('cates','belong=3') as $cate3){?>
            <label><input name="prefix" id="cate<?php echo $cate3['id'] ?>" type="checkbox" value="<?php echo $cate3['id'] ?>" /> <?php echo $cate3['name'] ?></label>
            <?php }?>
        </li>
        </li>
        <div id="subcateValue"></div>
        <li><label>传奇</label><input name="lg" type="checkbox" value="1" /> 传奇</li>
        
        <li><label>背景描述</label><input name="fv" type="text" value="" class="ipt" /></li>
        <li><label>绘师名字</label><input name="p" type="text" value="" class="ipt" /></li>
        <li style="border:none;"><label>&nbsp;</label><input name="schfull" type="submit" value="搜索" /></li>
        </form>
    </ul>
    <ul class="ulright"><img src="images/schright.jpg" /></ul>
</div>
<?php include_once "down.php";?>