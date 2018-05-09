<?php include_once "top.php";
include_once "add_left.php";?>
<div class="addbar">
    <ul>
    <h2>添加比赛</h2>
    <form name="addcard" method="post" action="ra_add.php" enctype="multipart/form-data">
    <li><label>日期</label><input name="mdate" value="" id="" type="date" class="ipt" /></li>
    <li><label>赛制</label><select name="game" class="ipt">
            <?php foreach($db->ig2_select('games','1') as $game){?>
            <option value="<?php echo $game['id']?>"><?php echo $game['name'].' - '.$game['abbr']?></option>
            <?php }?>
        </select></li>
    <li><label>牌池</label><select name="format" class="ipt">
            <?php foreach($db->ig2_select('formats','1') as $format){?>
            <option value="<?php echo $format['id']?>"><?php echo $format['name'].' - '.$format['ename']?></option>
            <?php }?>
        </select></li>
    <li><label>地点</label>
        <input name="country" class="ipt" value="" placeholder="国家" /> 
        <input name="city" class="ipt" value="" placeholder="城市" />
    </li>
    <li><label>范围：</label>
        <select name="mrange">
            <option value="TOP 8">TOP 8</option>
            <option value="TOP 16">TOP 16</option>
            <option value="TOP 32">TOP 32</option>
        </select>
    </li>
    <li><label>说明</label><textarea name="mime" class="ara"></textarea>
    <li style="border:none;"><label>&nbsp;</label><input name="submatch" type="submit" value="提交" /></li>
    </form>
    <?php 
	foreach($db->ig2_select('matchs','1') as $match){
	    $game=$db->ig2_want('games','id='.$match['game']);	
		$format=$db->ig2_want('formats','id='.$match['format']);
    ?>
    <li><?php echo $match['country'].' '.$match['city'].' '.strtoupper($game['abbr']).' '.date('Y',strtotime($match['mdate']))?></li>
    <?php }?>
    </ul>
</div>

<?php include_once "down.php";?>