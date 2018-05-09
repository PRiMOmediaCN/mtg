<?php
class image_worker{
    public $id=0;
    public $deck=array();
    public $name="未知";
    public $sbwater=false;
    public $en=false;
    public $uhland=false;
    public $doublesize=false;
    public $fillimg="0";
    public $oldcard=true;
    public $treasure=false;
    public $belong3=false;
    public function makeIMG($db)
    {
        $films=array();
        $backfilms=array();
        $lang=$this->en?'.e':'';
        $treasure=array();
        if($this->treasure){
            foreach ($db->ig2_select("cards",'sets=104 or sets=107 or sets=108') as $t){
                switch ($t["sets"]){
                    case 104:
                        $abbr="mpskld";
                        break;
                    case 107:
                        $abbr="mpsakh";
                        break;
                    case 108:
                        $abbr="exp";
                        break;
                }
                $treasure[$t["ename"]]=array(
                    "abbr"=>$abbr,
                    "serial"=>$t['serial']
                );
            }
        }
        foreach ($this->deck as $d){
            $path="file/".$d['abbr'].$lang;
            if($lang=="") {
                $path = "file/" . $d['abbr'].".s";
            }
            $seri=$d['serial'];
            if($this->uhland){
                switch ($d['cename']){
                    case "Plains":
                        $path="file/uh".$lang;
                        $seri=136;
                        $d['sid']=117;
                        break;
                    case "Island":
                        $path="file/uh".$lang;
                        $seri=137;
                        $d['sid']=117;
                        break;
                    case "Swamp":
                        $path="file/uh".$lang;
                        $seri=138;
                        $d['sid']=117;
                        break;
                    case "Mountain":
                        $path="file/uh".$lang;
                        $seri=139;
                        $d['sid']=117;
                        break;
                    case "Forest":
                        $path="file/uh".$lang;
                        $seri=140;
                        $d['sid']=117;
                        break;
                }
            }
            if($this->treasure&&key_exists($d["cename"],$treasure)){
                $path="file/".$treasure[$d["cename"]]["abbr"].".e";
                $seri=$treasure[$d["cename"]]["serial"];
            }
            if(!is_readable($path."/".$seri.".jpg")&&!is_readable($path."/".$seri."a.jpg")&&!is_readable($path."/".$seri."b.jpg")){
                $sql="select c.*,s.abbr from cards c,sets s WHERE c.sets=s.id and c.ename='".$d['cename']."'";
                if(!$this->treasure){
                    $sql.=" and s.id<>104 and s.id<>107 and s.id<>108";
                }
                $sql.=" order by s.belong";
                if($this->belong3){
                    $sql.=" desc";
                }else{
                    $sql.=" asc";
                }
                $sql.=",s.pub";
                if($this->oldcard){
                    $sql.=" asc";
                }else{
                    $sql.=" desc";
                }
                $tempabbs=$db->ig2_select_query($sql);
                foreach($tempabbs as $abb){
//                    $sets=$db->ig2_want('sets','id='.$abb['sets']);
                    $path = "file/" . $abb['abbr'].$lang;
                    if($lang=="") {
                        $path = "file/" . $abb['abbr'].".s";
                    }
                    $seri=$abb['serial'];
                    if(is_readable($path."/".$seri.".jpg")||is_readable($path."/".$seri."a.jpg")||is_readable($path."/".$seri."b.jpg")){
                        $d['sid']=$abb['sets'];
                        break;
                    }
                }
                if(!is_readable($path."/".$seri.".jpg")&&!is_readable($path."/".$seri."a.jpg")&&!is_readable($path."/".$seri."b.jpg")){
                    foreach ($tempabbs as $abb) {
//                    $sets=$db->ig2_want('sets','id='.$abb['sets']);
                        $path = "file/" . $abb['abbr'] . $lang;
                        $seri = $abb['serial'];
                        if (is_readable($path . "/" . $seri . ".jpg") || is_readable($path . "/" . $seri . "a.jpg") || is_readable($path . "/" . $seri . "b.jpg")) {
                            $d['sid'] = $abb['sets'];
                            break;
                        }
                    }
                }
            }
            if(!is_readable($path."/".$seri.".jpg")&&!is_readable($path."/".$seri."a.jpg")&&!is_readable($path."/".$seri."b.jpg")){
                if($this->en){
                    $templang='';
                }else{
                    $templang='.e';
                }
                $path="file/".$d['abbr'].$templang;
                $seri=$d['serial'];
                if(!is_readable($path."/".$seri.".jpg")&&!is_readable($path."/".$seri."a.jpg")&&!is_readable($path."/".$seri."b.jpg")){
                    $sql="select c.*,s.abbr from cards c,sets s WHERE c.sets=s.id and c.ename='".$d['cename']."'";
                    if(!$this->treasure){
                        $sql.=" and s.id<>104 and s.id<>107 and s.id<>108";
                    }
                    $sql.=" order by s.belong";
                    if($this->belong3){
                        $sql.=" desc";
                    }else{
                        $sql.=" asc";
                    }
                    $sql.=",s.pub";
                    if($this->oldcard){
                        $sql.=" asc";
                    }else{
                        $sql.=" desc";
                    }
                    foreach($db->ig2_select_query($sql) as $abb){
//                    $sets=$db->ig2_want('sets','id='.$abb['sets']);
                        $path="file/".$abb['abbr'].$templang;
                        if($templang=="") {
                            $path = "file/" . $abb['abbr'].".s";
                        }
                        $seri=$abb['serial'];
                        if(is_readable($path."/".$seri.".jpg")||is_readable($path."/".$seri."a.jpg")||is_readable($path."/".$seri."b.jpg")){
                            $d['sid']=$abb['sets'];
                            break;
                        }
                    }
                    if(!is_readable($path."/".$seri.".jpg")&&!is_readable($path."/".$seri."a.jpg")&&!is_readable($path."/".$seri."b.jpg")){
                        foreach ($tempabbs as $abb) {
//                    $sets=$db->ig2_want('sets','id='.$abb['sets']);
                            $path = "file/" . $abb['abbr'] . $templang;
                            $seri = $abb['serial'];
                            if (is_readable($path . "/" . $seri . ".jpg") || is_readable($path . "/" . $seri . "a.jpg") || is_readable($path . "/" . $seri . "b.jpg")) {
                                $d['sid'] = $abb['sets'];
                                break;
                            }
                        }
                    }
                }
            }
            $path.="/";
            if(($d['sid']>=71&&$d['sid']<=78)||$d['sid']==113||$d['sid']==112){
                $background=0;//0白1黑
            }else{
                $background=1;
            }
            if($d['side']==1){
                $other=$db->ig2_want("cards","side<>1 and sets=".$d['sid']." and serial=".$d['serial']);
                $d['side']=$other['side'];
            }
            for($i=0;$i<$d["cnum"];$i++) {
                switch ($d['side']){
                    case 0:
                        $films[] =[$path.$seri.".jpg",$background,$d['ismain']];
                        if($this->doublesize){
                            $backfilms[] = false;
                        }
                        break;
                    case 4:
                        $films[] =[$path.$seri."a.jpg",$background,$d['ismain']];
                        if($this->doublesize){
                            $backfilms[] = [$path . $seri . "b.jpg", $background, $d['ismain']];
                        }else {
                            $films[] = [$path . $seri . "b.jpg", $background, $d['ismain']];
                        }
                        break;
                    default:
                        $films[] =[$path.$seri."a.jpg",$background,$d['ismain']];
                        if($this->doublesize){
                            $backfilms[] = false;
                        }
                        break;
                }
            }
        }
        while (sizeof($films)%9){
            $films[] =["file/fillimg/".$this->fillimg.".jpg",$this->fillimg%2,1];
        }
        $page=sizeof($films)/9;
        $deckpath="tempdeck/".$this->id."_".time()."_".rand(10000,99999);
        mkdir($deckpath);

        if($this->sbwater){
            $sbwater=imagecreatefrompng("file/sbwater.png");
        }

        for($p=0;$p<$page;$p++){
            $im = @imagecreatetruecolor(2480, 3508)
            or die('Cannot Initialize new GD image stream');
            $white=imagecolorallocate($im, 255, 255, 255);
            $black=imagecolorallocate($im, 0, 0, 0);
            imagefill($im, 0, 0, $white);

            $y=-4;
            for($i=0;$i<3;$i++){
                $y+=114;
                $x=12;
                for($j=0;$j<3;$j++) {
                    $x+=91;
                    $filename=$films[$p*9+$i*3+$j][0];
                    $size=getimagesize($filename);
                    $source= imagecreatefromjpeg($filename);
                    if($films[$p*9+$i*3+$j][1]){
                        imagefilledrectangle($im, $x-42, $y-53, $x+697+42, $y+980+53, $black);
                    }
                    imagecopyresized($im, $source, $x, $y, 0, 0, 697, 980, $size[0], $size[1]);
                    if($this->sbwater&&$films[$p*9+$i*3+$j][2]==0){
                        imagecopyresized($im, $sbwater, $x+200, $y+910, 0, 0, 35, 35, 200, 200);
                    }
                    $x+=697;
                }
                $y+=980;
            }
            imagettftext ( $im ,20 ,0 ,2200 ,3400 ,$black,"file/msyh.ttc" ,$this->id);
            imagettftext ( $im ,20 ,0 ,2150 ,3450 ,$black,"file/msyh.ttc" ,$this->name);
            imagejpeg($im,$deckpath."/".$p.".jpg");
            imagedestroy($im);

            if(!$this->doublesize) continue;
            $im = @imagecreatetruecolor(2480, 3508)
            or die('Cannot Initialize new GD image stream');
            $rgba=imagecolorexactalpha ( $im ,255,0 , 0 , 127 );
            imagealphablending($im , false);
            imagefill($im, 0, 0, $rgba);
            $y=-4;
            for($i=0;$i<3;$i++){
                $y+=114;
                $x=12;
                for($j=2;$j>=0;$j--) {
                    $x+=91;
                    if($backfilms[$p*9+$i*3+$j]) {
                        $filename = $backfilms[$p * 9 + $i * 3 + $j][0];
                        $size = getimagesize($filename);
                        $source = imagecreatefromjpeg($filename);
                        if ($backfilms[$p * 9 + $i * 3 + $j][1]) {
                            imagefilledrectangle($im, $x - 42, $y - 53, $x + 697 + 42, $y + 980 + 53, $black);
                        }
                        imagecopyresized($im, $source, $x, $y, 0, 0, 697, 980, $size[0], $size[1]);
                    }
                    $x+=697;
                }
                $y+=980;
            }
            imagesavealpha($im , true);
            imagepng($im,$deckpath."/".$p."_b.png");
            imagedestroy($im);
        }
    }
}