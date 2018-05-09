<?php include_once "top.php";
$origin_url=$_SERVER['HTTP_REFERER'];
if($_POST['suberror']){
    $value=array(
        'id'=>'',
		'uid'=>$volunteer['id'],
		'origin_url'=>$_POST['origin_url'],
		'content'=>strip_tags($_POST['errorbody']),
		'pdate'=>date('Y-m-d H:i:s')
	);
	$db->ig2_insert('suberror',$value);
	tellgoto('再次感谢您的意见',$_POST['origin_url']);
}
?>
<div class="mainlist">
    <h1>我发现了错误！</h1>
    <div class="suberrorbody">
        <form action="suberror.php" method="post">
        <li><label>&nbsp;</label>感谢您为IG提供修改意见，如果您留下联系方式，我们将为您提供一份礼品</li>
        <li><label>错误页面：</label><?php echo $origin_url?><input name="origin_url" value="<?php echo $origin_url?>" type="hidden" /></li>
        <li><label>错误描述：</label><label style="width:1000px;"><textarea name="errorbody" style="width:1000px; height:300px;"></textarea></label></li>
        <li style="border:none;"><label>&nbsp;</label><label><input name="suberror" type="submit" value="提交" /></label></li>
        </form>
    </div>
    <img src="images/mtg-top.png" />
</div>
<?php include_once "down.php";?>