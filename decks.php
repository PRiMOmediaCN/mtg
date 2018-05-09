<?php include_once "top.php";
$leftTitle='总览';
$where=1;
if($_GET['id']) $where.=' and format='.$_GET['id'];
if($_GET['dn']) $where.=' and name like "%'.$_GET['dn'].'%"';
$where.=' order by id desc limit 12';
?>
<script type="text/javascript">
uaredirect("m/decks.php","");
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
<div class="addleft">
    <a href="decks.php">总览</a>
    <?php foreach($db->ig2_select('formats','1') as $formats){
		if($_GET['id']==$formats['id']) $leftTitle=$formats['name'].' - '.$formats['ename']?>
        <a href="?id=<?php echo $formats['id'] ?>"><?php echo $formats['name']?></a>
    <?php }?>
</div>

<div class="blog_list">
    <ul>
    <form action="decks.php" method="get">
    <input type="hidden" value="" id="whereStr" />
    <h2><?php echo $leftTitle?>
        <div class="fr">
        <input name="id" type="hidden" value="<?php echo $_GET['id']?>" />
        <input name="dn" class="ipt" value="<?php echo $_GET['dn']?$_GET['dn']:''?>" placeholder="输入中文套牌名称" style="width:300px;">
        <input name="subsch" type="submit" value="搜索" />
        </div>
    </h2>
    <div id="blog_schBar">
        <div class="choosenbar choosed sAllin">全部</div>
        <div class="choosenbar uchoose sAll">快攻</div>
        <div class="choosenbar uchoose sAll">控制</div>
        <div class="choosenbar uchoose sAll">科技</div>
        <div class="choosenbar uchoose sAll">中速</div>
        <div class="choosenbar uchoose sAll">猛袭</div>
        <div class="choosenbar uchoose sAll">八强卡组</div>
        <div class="choosenbar uchoose sAll">思路卡组</div>
        <div class="choosenbar uchoose sAll">共鸣</div>
        <div class="choosenbar uchoose sAll">风暴</div>
        <div class="choosenbar uchoose sAll">死亡阴影</div>
        <div class="choosenbar uchoose sAll">军伍</div>
        <div class="choosenbar uchoose sAll">杰斯凯</div>
    </div>
    </form>
    <script>
	var whereArr=new Array();
	$('.choosenbar').click(function(){
		var val=$(this).text();
	    $(this).toggleClass('uchoose');
		$(this).toggleClass('choosed');
		if($(this).attr('class')=='choosenbar sAll choosed') whereArr.push(val);
		else $.each(whereArr,function(index,items){if(items==val) whereArr.splice(index,1);});
		$('#whereStr').val(whereArr.join(','));
		if($(this).text()=='全部'){
			$('.sAll').removeClass('choosed').addClass('uchoose');
			whereArr=new Array();
			$('#whereStr').val('');
		}else $('.sAllin').removeClass('choosed').addClass('uchoose');
		$('#deckPageMore').html('');
		deckGetMore($('#deckPageMore').attr('data-cPage'),$('#deckPageMore').attr('data-cId'),$('#deckPageMore').attr('data-cDeckName'),$('#whereStr').val(),'nomore')
	});
    </script>
    <div id="decklist">
    <?php 
	foreach($db->ig2_select('decks',$where) as $list){
		$firstCard=$db->ig2_want('deck_list','did='.$list['id'].' order by rand() limit 1');
		$thisCard=$db->ig2_want('cards','ename="'.$firstCard['cename'].'"');
		$side=$thisCard['side']?($thisCard['side']==1?'a':'b'):'';
		$thisSet=$db->ig2_want('sets','id='.$thisCard['sets']);
		$format=$db->ig2_want('formats','id='.$list['format']);
		$match='';
		if($list['dmatch']){
			$match=$db->ig2_want('matchs','id='.$list['dmatch']);
			$game=$db->ig2_want('games','id='.$match['game']);
		}else{
			$uPlayer=$db->ig2_want('volunteer','id='.$list['uid']);
		}
		$dpn=(preg_match('/temp/i',$list['name']) && $vo['rights']!=1)?'none':'';//如果名称中含有temp，且登陆用户不是管理员，则不显示此套牌
		?>
        <li style="display:<?php echo $dpn;?>">
            <div class="blogface"><a href="deck_view.php?did=<?php echo $list['id']?>" target="_blank"><img src="file/<?php echo $thisSet['abbr'].'.e/'.$thisCard['serial'].$side.'.jpg'?>" /></a></div>
            <div class="blogtit"><?php echo '[ <strong>'.$format['code'].'</strong> ] <a href="deck_view.php?did='.$list['id'].'">'.$list['name'].'</a>'?></div>
            <div class="blogsubtit"><?php echo $list['ename']?></div>
            <div class="blogintro"><?php echo $match?('<a href="match.php?id='.$match['id'].'" target="_blank">'.$match['city'].' '.$game['abbr'].' '.date('Y',strtotime($match['mdate'])).'</a><br>'.$list['player']):('网站录入<br>'.$uPlayer['voname'])?></div>
            <?php if($list['format']==7){?>
            <div class="blogintro">
			    <?php 
				foreach(explode(',',$list['t2_format']) as $block){
					$thisSets=$db->ig2_want('sets','id='.$block);
					?>
                    <a href="sets_<?php echo $thisSets['abbr']?>.html" target="_blank"><?php echo $thisSets['abbr']?></a> 
                    <?php
				}
				?>
            </div>
            <?php }?>
        </li>
        <?php 
		$dpn='';
	}
	?>
    </div>
    <div id="deckPageMore" data-cPage="1" data-cId="<?php echo $_GET['id']?>" data-cDeckName="<?php echo $_GET['dn']?>"></div>
    <div class="deckGetMore" onClick="deckGetMore($('#deckPageMore').attr('data-cPage'),$('#deckPageMore').attr('data-cId'),$('#deckPageMore').attr('data-cDeckName'),$('#whereStr').val(),'more')">加载更多</div>
    </ul>
</div>
<script>
function deckGetMore(page,id,name,otherWhere,act){
    $.post('ra_ajax.php',{
		action:'getDecklistMore',
		deckPage:act=='more'?page:0,
		formatId:id,
		otherWhere:otherWhere,
		searchName:name
	},function(res){
		if(res!=0){
			if(act=='more'){
				$("#deckPageMore").append(res);
				$("#deckPageMore").attr('data-cPage',parseInt(page)+1);
			}else{
				$("#decklist").html(res);
			}
		}else{
			if(act=='more'){
				$(".deckGetMore").html('没有了');
				$(".deckGetMore").click(null);
			}else{
				$("#decklist").html('');
			}
		}
	});
}
</script>
<?php include_once "down.php";?>