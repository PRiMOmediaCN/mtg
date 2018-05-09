<?php include_once "top.php";
if($_GET['del']){
	foreach($db->ig2_select('my_deck_list','did='.$_GET['del']) as $del){
		$db->ig2_delete('my_deck_list','id='.$del['id']);
	}
    $db->ig2_delete('my_decks','id='.$_GET['del']);
}
if($_GET['advise']){
	$adv=$db->ig2_want('my_decks','id='.$_GET['advise']);
	$value=array(
	    'id'=>'',
		'type'=>2,
		'uid'=>$adv['uid'],
		'dmatch'=>0,
		'dgame'=>0,
		'format'=>$adv['format'],
		't2_format'=>$adv['t2_format']?$adv['t2_format']:NULL,
		'name'=>$adv['name'],
		'ename'=>str_replace('"',"&quot;",str_replace("'","&rsquo;",$adv['ename'])),
		'player'=>'System',
		'req'=>0,
		'colors'=>$adv['colors'],
		'proportion'=>$adv['proportion'],
		'curve'=>$adv['curve']
	);
	$did=$db->ig2_insert('decks',$value);
	$db->ig2_delete('my_decks','id='.$_GET['advise']);
	
    foreach($db->ig2_select('my_deck_list','did='.$_GET['advise']) as $advise){
		$value_card=array(
			'id'=>'',
			'did'=>$did,
			'cid'=>$advise['cid'],
			'ccate'=>$advise['ccate'],
			'ccosts'=>$advise['ccosts'],
			'cnum'=>$advise['cnum'],
			'is_main'=>$advise['ismain']
		);
		$db->ig2_insert('deck_list',$value_card);
		$db->ig2_delete('my_deck_list','id='.$advise['id']);
	}
	tellgoto('移动成功','my_decks.php');
    
}
include_once "my_add_left.php";?>
<div class="addbar">
    <ul>
    <h2>我的套牌</h2>
    <li style="background:#f4f4f4; font-weight:bold;"><label style="width:120px;">牌池</label>
        <label style="width:150px;">名称</label>
        <label style="width:150px;">英文名称</label>
        <label>主牌</label>
        <label>备牌</label>
        <label style="width:150px;">颜色</label>
        <label style="width:150px;">操作</label>
    </li>
    <?php 
	foreach($db->ig2_select('my_decks','uid='.$vo['id']) as $list){
		$format=$db->ig2_want('formats','id='.$list['format']);
		$count_main=$count_side=0;
		foreach($db->ig2_select('my_deck_list','did='.$list['id']) as $listCount){
		    if($listCount['ismain']==1) $count_main+=$listCount['cnum'];
			else $count_side+=$listCount['cnum'];
		}
    ?>
    <li><label style="width:120px;"><?php echo $format['name'].' . '.$format['code'];?></label>
        <label style="width:150px;"><a href="my_deck_view.php?did=<?php echo $list['id']?>"><?php echo $list['name']?></a></label>
        <label style="width:150px;"><?php echo $list['ename']?></label>
        <label><?php echo $count_main?></label>
        <label><?php echo $count_side?></label>
        <label style="width:150px;"><?php
	    foreach(explode(',',$list['colors']) as $color){?>
		<img src="images/<?php echo $color?>.png" class="coloright" style="float:left;" />
		<?php }?></label>
        <label style="width:150px;"><?php if($vo['rights']==1){?><a href="?advise=<?php echo $list['id']?>">移动</a><?php }?> | <a href="#">编辑</a> | <a href="?del=<?php echo $list['id']?>">删除</a></label>
    </li>
    <?php }?>
    </ul>
</div>

<?php include_once "down.php";?>