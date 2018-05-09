<?php
function getFile($dir) {
    $fileArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while ( false !== ($file = readdir ( $handle )) ) {
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".."&&strpos($file,".")) {
                $fileArray[$i][0]=$dir."/".$file;
                $fileArray[$i][1]=$dir.".temp/".$file;
                if($i==100){
                    break;
                }
                $i++;
            }
        }
        //关闭句柄
        closedir ( $handle );
    }
    return $fileArray;
}
$folder=$_GET['f'];
$films=getFile('file_u/'.$folder.'/');
//echo 0%2;
//print_r($films);

        
while (sizeof($films)%9){
	$films[] =array("file/fillimg/0.jpg",0,1);
}
$page=sizeof($films)/9;
$deckpath="tempdeck/".$folder."_".time()."_".rand(10000,99999);
mkdir($deckpath);

for($p=0;$p<$page;$p++){
	$im = @imagecreatetruecolor(2480, 3508)
	or die('Cannot Initialize new GD image stream');
	$white=imagecolorallocate($im, 255, 255, 255);
	$black=imagecolorallocate($im, 0, 0, 0);
	imagefill($im, 0, 0, $white);

	$y=27;
	for($i=0;$i<3;$i++){
		
		$y+=59;
		$x=33;
		for($j=0;$j<3;$j++) {
			$x+=47;
			$filename=$films[$p*9+$i*3+$j][0];
			$size=getimagesize($filename);
			$source= imagecreatefromjpeg($filename);
			imagecopyresized($im, $source, $x, $y, 0, 0, 741, 1032, $size[0], $size[1]);
			$x+=741;
		}
		$y+=1032;
	}
	imagejpeg($im,$deckpath."/".$p.".jpg");
    imagedestroy($im);
}

echo '<a href="'.$deckpath.'">'.$deckpath.'</a>';
echo '<a href="add_create.php">返回</a>';
?>