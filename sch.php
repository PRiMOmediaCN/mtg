<?php include_once "top.php";
if(empty($_GET)) tellgoto('搜索条件不能为空。',$_SERVER['HTTP_REFERER']);
$where='1';

//牌名
if($_GET['n']){
	$n=str_replace("'",'&rsquo;',trim($_GET['n']));
	$en = preg_match("/^[^/x80-/xff]+$/", $n); //判断牌名是否是英文
	$cn = preg_replace("/[^一-龥]/u",'',$n);    //判断牌名是否是中文
	$where.=$cn?(" and name like '%".$n."%'"):(" and ename like '%".$n."%'");
}

//内文描述
if($_GET['in']){
	$m=str_replace("'",'&rsquo;',trim($_GET['in']));
	$enm = preg_match("/^[^/x80-/xff]+$/", $m); //判断牌名是否是英文
	$cnm = preg_replace("/[^一-龥]/u",'',$m);    //判断牌名是否是中文
	$where.=$cnm?(" and intext like '%".$m."%'"):(" and eintext like '%".$m."%'");
}

//背景描述
if($_GET['fv']){
	$mn=str_replace("'",'&rsquo;',trim($_GET['fv']));
	$enmn = preg_match("/^[^/x80-/xff]+$/", $mn); //判断牌名是否是英文
	$cnmn = preg_replace("/[^一-龥]/u",'',$mn);    //判断牌名是否是中文
	$where.=$cnmn?(" and flavor like '%".$mn."%'"):(" and eflavor like '%".$mn."%'");
}


//颜色
if($_GET['cr']){
    $cr=$_GET['cr'];
	//if($_GET['l'] && count($cr)<2) tellgoto('您输入的搜索条件有误','schfull.php');
	$where.=$_GET['h']?(" and color='".implode(',',$cr)."'"):(
	    $_GET['l']?(" and color REGEXP '".implode("' and color REGEXP '",$cr)."' "):(" and color='".implode(',',$cr)."'")
	);
}

//必须多色
if($_GET['l']){
    $where.=" and color like '%,%'";
}

//法术力
if($_GET['c']) $where.=" and cost='".$_GET['c']."'";

//总费用
if($_GET['cs']) $where.=" and costs=".$_GET['cs'];

//牌池
if($_GET['st']==1){
    $t2file = fopen("t2.txt","r") or die("Unable to open file!");
	$t2_format=fgets($t2file);
	fclose($t2file);
    $where.=" and find_in_set(`sets`,'".$t2_format."')";
}
if($_GET['st']==2){
    $t2file = fopen("mdn.txt","r") or die("Unable to open file!");
	$t2_format=fgets($t2file);
	fclose($t2file);
    $where.=" and find_in_set(`sets`,'".$t2_format."')";
}

//稀有度
if($_GET['r']){
	$r_arr=array();
	foreach($_GET['r'] as $r){
		$r_arr[]="rarity=".$r;
	}
	$where.=' and ('.implode(' or ',$r_arr).') ';
}

//类别
if($_GET['ct']) $where.=" and find_in_set(`cate`,'".implode(',',$_GET['ct'])."')";

//前缀
if($_GET['prefix']) $where.=" and prefix=".$_GET['prefix'];

//是否传奇
if($_GET['lg']) $where.=" and legendary=1";

//作者
if($_GET['p']) $where.=" and painter like '%".$_GET['p']."%'";

//指定版本
if($_GET['sets']) $where.=" and sets=".$_GET['sets'];

$where.=' order by serial';
$cards=$db->ig2_select_distinct('ename','cards',$where);

if($_GET['createImages']){
	$deck=array();
    foreach($cards as $list){
		$deck[]=array(
		    'id'=>'',
			'cnum'=>1,
			'cename'=>$list['ename'],
			'ismain'=>1,
			'cid'=>$list['id'],
			'side'=>$list['side'],
			'serial'=>$list['serial'],
			'sid'=>'',
			'abbr'=>''
		);
	}
	include_once "class/image_worker.class.php";

	$maker=new image_worker();
	$maker->id='';
	$maker->deck=$deck;
	$maker->name='';
	if(key_exists("sbwater",$_GET)&&$_GET['sbwater']==1){
		$maker->sbwater=true;
	}
	if($_GET['uhland']){
		$maker->uhland=true;
	}
	if($_GET['lang']){
		$maker->en=true;
	}
	if($_GET['doublesize']){
		$maker->doublesize=true;
	}
	$maker->makeIMG($db);
	
}

$count=count($cards);

/*print_r($_SERVER);
exit();
//获得当前搜索条件
$q_arr=array();
foreach($_GET as $k=>$v){
	if($k!='dis') $q_arr[]=$k.'='.$v;
}
$q_str=implode('&',$q_arr);*/
?>
<script>
function traggleCardstyle(id){
    if(id=='dis_imag'){
	    $('#dis_imag').attr('src','images/dis_imag_hov.gif');
		$('#dis_line').attr('src','images/dis_line.gif');
		$('#cards_2').show();
		$('#cards_1').hide();
	}else{
	    $('#dis_line').attr('src','images/dis_line_hov.gif');
		$('#dis_imag').attr('src','images/dis_imag.gif');
		$('#cards_1').show();
		$('#cards_2').hide();
	}
}
</script>
<div class="setlist">
    <h1>搜索结果 
        <span class="fr" style="margin-top:10px;">
            <div style=" float:left;font-size:14px; margin:10px 20px 10px 0;">
            <?php if($vo['rights']==1){?>
            <a href="?<?php echo $_SERVER['QUERY_STRING'];?>&createImages=1">生成图</a>
            <?php }?>
            共<?php echo $count ?>张卡牌
            
            </div>
            <img id="dis_line" src="images/dis_line_hov.gif" onClick="traggleCardstyle(this.id)" />
            <img id="dis_imag" src="images/dis_imag.gif" onClick="traggleCardstyle(this.id)" />
        </span>
    </h1>
    
    <ul id="cards_1"><?php if($count>0){?>
        <li style="background:#f4f4f4"><strong>
            <label style="width:50px;">#</label>
            <label style="width:180px;">中文名称</label>
            <label style="width:230px;">英文名称</label>
            <label style="width:180px;">类别</label>
            <label style="width:80px;">攻防</label>
            <label>费用</label>
            <label style="width:40px; text-align:center;">稀有</label>
            </strong>
        </li>
        <?php 
        foreach($cards as $card){
            $list=$db->ig2_want('cards',"ename='".$card['ename']."'");
            $sets=$db->ig2_want('sets','id='.$list['sets']);
            ?>
            <li><label style="width:50px;">#<?php echo $list['serial'].($list['side']=='0'?'':($list['side']==1?'a':'b')) ?></label>
                <label style="width:180px;"><a href="card.php?id=<?php echo $list['id'] ?>" target="_blank"><?php echo $list['name'] ?></a></label>
                <label style="width:230px;"><?php echo $list['ename'] ?></label>
                <label style="width:180px;">
                <?php 
                echo $list['legendary']?"传奇":'';
                if($list['prefix']){
                    $prefix=$db->ig2_want('cates','id='.$list['prefix']);
                    echo $prefix['name'];
                }
                foreach(explode(',',$list['cate']) as $cate){
                    $catename=$db->ig2_want('cates','id='.$cate);
                    echo $catename['name'];
                }
                if($list['subcate']){
                    $subcate=$db->ig2_want('cates','id='.$list['subcate']);
                    echo '～'.$subcate['name'];
                }
                if(in_array('4',explode(',',$list['cate']))){
                    $crtcatename=array();
                    foreach(explode(',',$list['crtcate']) as $crt){
                        $crtcate=$db->ig2_want('crtcates','id='.$crt);
                        $crtcatename[]=$crtcate['name'];
                    }
                    echo '～'.implode('&nbsp;/&nbsp;',$crtcatename);
                }		
                echo $list['cate']==5?('('.$list['loyalty'].')'):''; 
                ?></label>
                <label style="width:80px;"><?php echo in_array('4',explode(',',$list['cate']))?($list['power'].'/'.$list['toughness']):'&nbsp;';?></label>
                <label><?php echo trim($list['cost'])?(getCost($list['cost']).'(<strong>'.$list['costs'].'</strong>)'):'-'?></label>
        <label style="width:40px; text-align:center;"><img src="images/rarity/<?php echo $sets['abbr'] ?>_<?php echo $list['rarity'] ?>.png" height="27" /></label>
            </li>
            <?php 
		    }
		}else{
			?>
			<li>没有符合条件的结果 <span class="gray">No Records</span></li>
			<?php
		}
		?>
    </ul>
    <ul id="cards_2" style="display:none;"><?php 
	    if($count>0){
		    foreach($cards as $cardImg){
				$list=$db->ig2_want('cards',"ename='".$cardImg['ename']."'");
				$sets=$db->ig2_want('sets','id='.$list['sets']);
				$side=$list['side']?($list['side']==1?'a':'b'):'';
				$imgSrc=is_file("file/".$sets['abbr']."/".$list['serial'].$side.".jpg")?("file/".$sets['abbr']."/".$list['serial'].$side.".jpg"):("file/".$sets['abbr'].".e/".$list['serial'].".jpg");
			?>
            <a href="card.php?id=<?php echo $list['id'] ?>" target="_blank"><img src="<?php echo $imgSrc;?>" width="270" height="385" alt="<?php echo $list['name']?>" style="margin:5px 0 -2px 2px;" /></a>
        	<?php 
			}
		}else{
			?>
			<li>没有符合条件的结果 <span class="gray">No Records</span></li>
			<?php
		}
		?>
    </ul>
</div>
<?php include_once "down.php";?>