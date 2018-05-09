<?php 
include_once "ra_global.php";
if($_POST['action']){
	switch($_POST['action']){
		case 'getDecklistMore':
			$where=1;
			if($_POST['formatId'] && $_POST['formatId']!='undefine') $where.=' and format='.$_POST['formatId'];
			if($_POST['searchName'] && $_POST['searchName']!='undefine') $where.=' and name like "%'.$_POST['searchName'].'%"';
			$where.=' order by id desc limit '.(12*$_POST['deckPage']).',12';
			/*echo $where;
			break;
			default:*/
			$getMoreDeckThese=$db->ig2_select('decks',$where);
			if($getMoreDeckThese){
				foreach($getMoreDeckThese as $list){
					$firstCard=$db->ig2_want('deck_list','did='.$list['id'].' order by rand() limit 1');
					$thisCard=$db->ig2_want('cards','id='.$firstCard['cid']);
					$side=$thisCard['side']?($thisCard['side']==1?'a':'b'):'';
					$thisSet=$db->ig2_want('sets','id='.$thisCard['sets']);
					$format=$db->ig2_want('formats','id='.$list['format']);
					$match='';
					if($list['dmatch']){
						$match=$db->ig2_want('matchs','id='.$list['dmatch']);
						$game=$db->ig2_want('games','id='.$match['game']);
					}
					$card_cover=$db->ig2_want('deck_list','did='.$list['id'].' order by rand()');
					$cover=$db->ig2_want('cards','ename="'.$card_cover['cename'].'"');
					$card_set=$db->ig2_want('sets','id='.$cover['sets']);
					$cover_url='../file/'.$card_set['abbr'].'.e/'.$cover['serial'].'.jpg';
					$cover_url=file_exists($cover_url)?$cover_url:('../file/'.$card_set['abbr'].'.e/'.$cover['serial'].'a.jpg');
					?>
					<li class="Deck_li_pl" onClick="location.href='view_deck.php?did=<?php echo $list['id']?>'">
						<div class="fl Deck_face_img"><img src="<?php echo $cover_url;?>" class="posit2 card_cover" /></div>
						<div class="fl Deck_content_bar">
							<div class="fl width_100">
								<label class="fl">[<font class="gray_font Deck_content_lab"><?php echo $format['code']?></font>]</label>
								<label class="green_font fl Deck_Environment_name"><?php echo $list['name']?>
								<div class="flr clist_color_box"><?php echo getCost(str_replace(',','',$list['colors']));?></div>
								</label>
							</div>
							<label class="gray_font fl Deck_Environment_allwritten"><?php echo $list['ename']?></label>
							<label class="black_font fl Deck_lab">来自</label>
							<label class="green_font fl Deck_subtitle"><?php echo $match['id']?($match['country'].$match['city'].$game['abbr'].' - <font color="#ccc">'.date('Y.m',strtotime($match['mdate'])).'</font>'):'System'?></label>
							
						</div>	
					</li>
					<?php 
				}
				?>
				<script>getWidthList();</script>
				<?php
			}else{
				echo 0;
			}
		break;
		case 'deckViewGetImg':
			foreach($db->ig2_select('deck_list','did='.$_POST['did']) as $list){
				$thisfile='';
				foreach($db->ig2_select('cards','ename="'.$list['cename'].'"') as $card){
					$sets=$db->ig2_want('sets','id='.$card['sets']);
					$file='../file/'.$sets['abbr'].'/'.$card['serial'].($card['side']?'a':'').'.jpg';
					if(file_exists($file)) $thisfile=$file;
				}
				if($thisfile==''){
					$card=$db->ig2_want('cards','ename="'.$list['cename'].'"');
					$sets=$db->ig2_want('sets','id='.$card['sets']);
					$thisfile='../file/'.$sets['abbr'].'.e/'.$card['serial'].($card['side']?'a':'').'.jpg';
				}
				?>
				<img class="fl img_mode_img width_100" src="<?php echo $thisfile?>" />
				<?php
			}
		break;
		case 'schGetMore':
		    $where=$_POST['where'];
		    $where.=' order by ename limit '.($_POST['page']*20).',20';
			$cards=$db->ig2_select_distinct('ename','cards',$where);
			$count=count($cards);
			if($count){
			$k=$_POST['page']*20+1;
            foreach($cards as $list){
                $card=$db->ig2_want('cards','ename="'.$list['ename'].'" order by rand() limit 1');
                $this_set=$db->ig2_want('sets','id='.$card['sets']);
                ?>
                <div id="clist_box_<?php echo $card['id']?>" class="fl width_100 clist_box" data-req="<?php echo $k?>" onClick="openImgBar(<?php echo $k?>)">
                    <label class="fl clist_bar_lab1 black_font tac">
                        <img class="clist_sets_img" src="../images/rarity/<?php echo $this_set['abbr']?>_<?php echo $card['rarity']?>.png" />
                    </label>
                    <div class="clist_box_dot fl">    
                        <label class="green_font clist_bar_lab2"><?php echo $card['name']?></label>
                        <label class="black_font clist_bar_lab3">-</label>
                        <label class="gray_font clist_bar_lab4"><?php echo $card['ename']?></label>
                    </div>
                    <div class="clist_color_box tac fl"><?php getCost($card['cost']);?></div>
                </div>
                <script>
                <?php 
				$img_src=is_file('../file/'.$this_set['abbr'].'/'.$card['serial'].'.jpg')?
				                ('../file/'.$this_set['abbr'].'/'.$card['serial'].'.jpg'):
								('../file/'.$this_set['abbr'].'.e/'.$card['serial'].'.jpg')?>
$('#img_enlarge_img_bar').append('<img class="posit2 img_enlarge_img" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
$('#img_mode').append('<img class="fl width_100" src="<?php echo $img_src;?>" onclick="location.href=\'card.php?id=<?php echo $card['id']?>\'">');
				img_number+=20;
                </script>
                <?php 
                $k++;
            }
			?>
            <script>getWidth();</script>
            <?php
			}else{
				echo 0;
			}
		break;
		case 'getSchSetname':
		    if($_POST['setname']){
				$setname=$db->ig2_want('sets','name like "%'.$_POST['setname'].'%"');
				if($setname['id']) echo $setname['id'];
				else echo 'no';
			}else{
			    echo 'null';
			}
		break;
	}
}
?>