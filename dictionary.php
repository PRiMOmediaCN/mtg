<?php include_once "top.php";

?>
<div class="addleft">
    <a href="dictionary.php">首页</a>
    <a href="dictionary.php?t=4">规则</a>
    <a href="dictionary.php?t=1">关键词异能</a>
    <a href="dictionary.php?t=5">鹏洛客</a>
    <a href="dictionary.php?t=2">生物类别</a>
    <a href="dictionary.php?t=3">文化</a>  
</div>
<div class="addbar">
    <ul class="ruluebar">
    <h2>百科</h2>
    <li><input name="keywords" type="text" value="" class="ipt" /> <input name="schdic" type="submit" value="搜索" /></li>
    <?php if($_GET['t']==4){?>
    <script type="text/javascript" src="inc/ZeroClipboard.js"></script>
	<script language="javascript">
    ZeroClipboard.setMoviePath("inc/ZeroClipboard.swf"); 
	var clip = null;
	function init(id,content) {
		clip = new ZeroClipboard.Client();
		clip.setHandCursor( true );
		clip.glue(id);
		clip.setText(content);
		clip.addEventListener( "complete", function(){
			alert("复制成功！您可以Ctrl+V粘贴在其他地方。");
		}); 
	}
	</script>
    <li style="margin-top:20px;"><label><strong>规则</strong></label></li>
    <?php foreach($db->ig2_select('rules','code=""') as $rules){?>
    <li><strong><?php echo $rules['serial'].' - '.$rules['content'] ?></strong> - <?php echo $rules['econtent'] ?></label></li>
	<?php foreach($db->ig2_select('rules','serial='.$rules['serial'].' and code <> ""') as $subrules){?>
    <li style="line-height:24px;"><label><?php echo $subrules['code'] ?></label><?php echo $subrules['content'] ?> [<a id="copyit<?php echo $subrules['id'] ?>" onmouseover="init(this.id,'<?php echo $subrules['content'] ?>')">复制</a>]<br>
    <span class="gray"><label>&nbsp;</label><?php echo $subrules['econtent'] ?></span>
    <?php 
	}
	}
	}
	?>
    
    
    <?php if(!$_GET['t'] || $_GET['t']==1){?>
    <li style="margin-top:20px;"><label><strong>关键词异能</strong></label></li>
    <li><label>静止式</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('keywords','type=1') as $key1){
		    $sets=$db->ig2_want('sets','id='.$key1['start']);	
		?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'，<font size="small">最早出现于<strong>'.$sets['name'].'</strong>（'.$sets['ename'].','.date('Y.m',strtotime($sets['pub'])).'）</font><br>'.$key1['note'].'<br><font class="gray">'.$key1['enote'].'</font>' ?></div>
        <?php }?>
        </label>
    </li>
    <li><label>启动式</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('keywords','type=2') as $key1){
			 $sets=$db->ig2_want('sets','id='.$key1['start']);
	    ?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'，<font size="small">最早出现于<strong>'.$sets['name'].'</strong>（'.$sets['ename'].','.date('Y.m',strtotime($sets['pub'])).'）</font><br>'.$key1['note'].'<br><font class="gray">'.$key1['enote'].'</font>' ?></div>
        <?php }?>
        </label>
    </li>
    <li><label>触发式</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('keywords','type=3') as $key1){
			 $sets=$db->ig2_want('sets','id='.$key1['start']);
	    ?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'，<font size="small">最早出现于<strong>'.$sets['name'].'</strong>（'.$sets['ename'].','.date('Y.m',strtotime($sets['pub'])).'）</font><br>'.$key1['note'].'<br><font class="gray">'.$key1['enote'].'</font>' ?></div>
        <?php }?>
        </label>
    </li>
    <li><label>躲避式</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('keywords','type=4') as $key1){
			 $sets=$db->ig2_want('sets','id='.$key1['start']);
	    ?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'，<font size="small">最早出现于<strong>'.$sets['name'].'</strong>（'.$sets['ename'].','.date('Y.m',strtotime($sets['pub'])).'）</font><br>'.$key1['note'].'<br><font class="gray">'.$key1['enote'].'</font>' ?></div>
        <?php }?>
        </label>
    </li>
    <li><label>替代式</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('keywords','type=5') as $key1){?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'，<font size="small">最早出现于<strong>'.$sets['name'].'</strong>（'.$sets['ename'].','.date('Y.m',strtotime($sets['pub'])).'）</font><br>'.$key1['note'].'<br><font class="gray">'.$key1['enote'].'</font>' ?></div>
        <?php }?>
        </label>
    </li>
    <?php }?>
    
    <?php if($_GET['t']==5){?>
    <li style="margin-top:20px;"><label><strong>鹏洛客</strong></label></li>
    <li><label>所有：</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('cates','pid=5') as $key1){
		?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php 
		foreach($db->ig2_select('cards','subcate='.$key1['id']) as $card){
		?><label style="float:left;width:200px;"><a href="card_<?php echo $card['id']?>.html" target="_blank"><?php echo $card['name']?></a></label><?php
		}
		?></div>
        <?php }?>
        </label>
    </li>
    <?php }?>
    
    <?php if(!$_GET['t'] || $_GET['t']==2){?>
    <li style="margin-top:20px;"><label><strong>生物类别</strong></label></li>
    <li><label>种族</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('crtcates','type=1') as $key1){?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'<br>'.$key1['note']?></div>
        <?php }?>
        </label>
    </li>
    <li><label>职业</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('crtcates','type=2') as $key1){?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'<br>'.$key1['note']?></div>
        <?php }?>
        </label>
    </li>
    <li><label>动物</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('crtcates','type=3') as $key1){?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'<br>'.$key1['note']?></div>
        <?php }?>
        </label>
    </li>
    <li><label>物件</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('crtcates','type=4') as $key1){?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].' - '.$key1['ename'].'<br>'.$key1['note']?></div>
        <?php }?>
        </label>
    </li>
    <?php }?>
    

    <?php if(!$_GET['t'] || $_GET['t']==3){?>
    <li style="margin-top:20px;"><label><strong>文化</strong></label></li>
    <li><label>角色</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('cultures','type=1') as $key1){?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].'<br>'.$key1['ename']?></div>
        <?php }?>
        </label>
    </li>
    <li><label>地理</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('cultures','type=2') as $key1){?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].'<br>'.$key1['ename']?></div>
        <?php }?>
        </label>
    </li>
    <li><label>组织</label>
        <label style="width:820px;">
        <?php foreach($db->ig2_select('cultures','type=3') as $key1){?>
        <span class="ablk"><a><?php echo $key1['name']?></a> - <?php echo $key1['ename'] ?></span>
        <div class="gotoshow"><?php echo $key1['name'].'<br>'.$key1['ename']?></div>
        <?php }?>
        </label>
    </li>
    <?php }?>
    
    
    </ul>
</div>
<div class="popbar"></div>
<script>
$(function(){
    $('.ablk').find('a').each(function(index,element){
		//console.log(index);
		$(element).click(function(){
		    $('.popbar').html($(this).parent().next('.gotoshow').html()+'<img src="images/popx.png" />').css({left:(parseInt(window.innerWidth)-630)/2+'px'}).fadeIn(500).click(function(){
				$(this).fadeOut(500);
			});
		});
	});
});
</script>
<?php include_once "down.php";?>