<?php include_once "top.php";
if($_GET['id']){
	$match=$db->ig2_want('matchs','id='.$_GET['id']);
	$game=$db->ig2_want('games','id='.$match['game']);
	$format=$db->ig2_want('formats','id='.$match['format']);
}
?>
<div class="addleft">
    <a href="formats.php">总览</a>
    <?php foreach($db->ig2_select('formats','1') as $formats){?>
    <a href="formats.php?id=<?php echo $formats['id'] ?>"><?php echo $formats['name']?></a>
    <?php }?>
</div>
<div class="addbar disimg">
    <ul>
    <div class="midbar">
        <h2><?php echo '[<strong>'.$format['code'].'</strong>] '.$match['country'].' '.$match['city'].' '.$game['abbr'].' '.date('Y',strtotime($match['mdate']))?></h2>
        <div style="float:right;color:#ccc; margin-top:18px;"><?php echo date('m.d',strtotime($match['mdate']));?></div>
        
        <li>注意，一些过于重复的套牌未进行收录</li>
        <li style="margin-top:10px;"><strong>套牌收录</strong></li>
        <li style="background:#f4f4f4"><strong>
            <label style="width:80px;">名次</label>
            <label style="width:200px;">中文名称</label>
            <label style="width:200px;">英文名称</label>
        </strong></li>
        <?php 
		foreach($db->ig2_select('decks','type=1 and dmatch='.$_GET['id'].' order by req') as $deck){
			?>
            <li><label style="width:80px;"><?php echo $deck['req']?></label>
                <label style="width:200px;"><a href="deck_view.php?did=<?php echo $deck['id']?>" target="_blank"><?php echo $deck['name']?></a></label>
                <label style="width:200px;"><?php echo $deck['ename']?></label>
            </li>
        <?php }?>
    </div>
    <div class="rightbar">
        <h2>最新赛事</h2>
        <?php 
		foreach($db->ig2_select('matchs','1 order by mdate desc limit 10') as $list){
			$thisgame=$db->ig2_want('games','id='.$list['game']);
			?>
            <li><?php echo $list['country'].' '.$list['city'].' '.$thisgame['abbr'].' '.date('Y',strtotime($list['mdate']))?><a href="match.php?id=<?php echo $list['id']?>" class="fr">查看</a></li> 
            <?php 
		}
		?>
    </div>
    </ul>
</div>
<?php include_once "down.php";?>