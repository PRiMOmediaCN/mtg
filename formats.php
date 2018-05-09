<?php include_once "top.php";
if($_GET['id']) $format=$db->ig2_want('formats','id='.$_GET['id']);
?>
<div class="addleft">
    <a href="formats.php">总览</a>
    <?php foreach($db->ig2_select('formats','1') as $formats){?>
    <a href="?id=<?php echo $formats['id'] ?>"><?php echo $formats['name']?></a>
    <?php }?>
</div>
<div class="addbar disimg">
    <ul>
    <?php if($_GET['id']){?>

    <div class="midbar">
        <h2><?php echo $format['name'].'赛制 - '.$format['code'].' - '.$format['ename']?></h2>
        <li><?php echo $format['note'] ?></li>
        <li style="margin-top:10px;"><strong>套牌收录</strong></li>
        <li style="background:#f4f4f4"><strong><label style="width:300px;">地点</label><label>赛级</label><label style="width:135px;">时间</label><label>查看</label></strong></li>
        <?php 
		foreach($db->ig2_select('matchs','format='.$_GET['id'].' order by mdate desc') as $match){
			$game=$db->ig2_want('games','id='.$match['game']);
		    $format=$db->ig2_want('formats','id='.$match['format']);
			?>
            <li><label style="width:300px;"><?php echo $match['country'].' - '.$match['city']?></label>
                <label><?php echo strtoupper($game['abbr'])?></label>
                <label style="width:135px;"><?php echo $match['mdate']?></label>
                <label><a href="match.php?id=<?php echo $match['id']?>">查看</a></label></li>
        <?php }?>
    </div>
    <script>
	function getBanned(bannedFormatId){
		$('#bannedBar').html('<img src="images/loading.gif" width="80" />');
		$.ajax({
			type: 'POST',
			url: 'ra_ajax.php',
			data: {
				bannedFormatId:bannedFormatId
			},		
			success:function(data){
				console.log(data);
			    $('#bannedBar').html(data);
			},
			dataType: 'html'
		});
	}
	function getRestricted(){
		$('#restrictedBar').html('<img src="images/loading.gif" width="80" />');
		$.ajax({
			type: 'POST',
			url: 'ra_ajax.php',
			data: {
				restrictedFormatId:1
			},		
			success:function(data){
				console.log(data);
			    $('#restrictedBar').html(data);
			},
			dataType: 'html'
		});
	}
	</script>
    <div class="rightbar">
        <h2>禁限牌表</h2>
        <li>限制牌表：
		    <?php if($_GET['id']==5){?>[<a onClick="getRestricted()">获取</a>]<?php }else{echo '-';}?>
        </li> 
        <div id="restrictedBar" class="fl"></div>
        <li>禁止牌表：[<a onClick="getBanned(<?php echo $format['id']?>)">获取</a>]</li>
        <div id="bannedBar" class="fl"></div>
    </div>
    
    
    
    <?php }else{?>
    <h2>总览</h2>
    <li style="line-height:28px;">
        <label>通用规则：</label>
        <label style="width:820px;">
        万智牌的规则与玩法很多，一般讲的比赛和对战规则如下：<br>
        ① 比赛由每位牌手根据限定的牌池选择卡牌构成自己的套牌<br>
        ② 一幅套牌（Deck）由主牌（Main Decks）和备牌（Sideboard）组成，主牌的数量必须大于60张，备牌的数量必须少于15张。<br>
        ③ 一般来说，一盘比赛要通过三局两胜来决定最终胜负。而第一局比赛时，牌手不能更换备牌。<br>
        ④ 两位牌手可以通过掷骰子或猜硬币来决定“由谁来决定先后手”。<br>
        ⑤ 游戏开始时，牌手从牌库顶抓满7张牌来开始游戏，对手牌不满可以调度重新洗牌后重抓，但要每次调度要比前一次抓拍少抓1张。<br>
        ⑥ 先手玩家略过抓牌步骤直接开始。<br><br>
        具体的游戏规则和游戏流程可以参考<a href="rules.php">详细规则</a>进行。
        </label>
    </li>
    <li><label>牌池：</label><label style="width:820px;">万智牌每隔几个月，就会更新一个版本，也称“扩展”。比赛中允许使用哪些版本中的牌，这个允许的范围称为牌池。</label></li>
    <li><label>&nbsp;</label>目前国内外最常见的牌池为<a href="#">标准</a>（Standard，T2）、<a href="#">摩登</a>（也称“近代”，Modern，Mod）和<a href="#">薪传</a>（也称古典，Legacy，T1.5）三种。</label></li>
    <li><label>赛制：</label><label style="width:820px;">将几种不同范围的牌池作为限定，形成了几种经典的赛制。以牌池作为区分的赛制又称为“构筑赛”。</label></li>
    <?php foreach($db->ig2_select('games','1') as $gm){?>
    <li><label>&nbsp;</label><label style="width:820px;"><a href="#"><?php echo $gm['name']?></a> - <?php echo $gm['enname']?> - <strong><?php echo $gm['abbr']?></strong></label></li>
    <?php }?>
    <li><label>玩法：</label><label style="width:820px;">万智牌的民间有很多种玩法，将几种常见玩法罗列如下：</label></li>
    <li><label>&nbsp;</label><label style="width:820px;"><a href="#">轮抓</a> - Sealed</label></li>
    <li><label>&nbsp;</label><label style="width:820px;"><a href="#">现开</a> - Booster Draft</label></li>
    <li><label>&nbsp;</label><label style="width:820px;"><a href="#">指挥官</a> - Commander，EDH</label></li>
    <li><label>&nbsp;</label><label style="width:820px;"><a href="#">方阵</a> - Cube</label></li>
    <li><label>&nbsp;</label><label style="width:820px;"><a href="#">双头巨人</a> - Two-Headed Giant</label></li>
    <li><label>&nbsp;</label><label style="width:820px;"><a href="#">环境赛</a> - Block</label></li>
    
    
    <?php }?>
    </ul>
</div>
<?php include_once "down.php";?>