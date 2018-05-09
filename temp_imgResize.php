<?php
//获取文件列表
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
if(key_exists("folder",$_GET)){
    $path="file/".$_GET['folder'];
}
if(is_dir($path)){
    if(!is_dir($path.".temp")){
        mkdir ($path.".temp",0777,true);
    }
    $files=getFile($path);
}
foreach ($files as $f){
    $source = imagecreatetruecolor(672, 936);
    $tempsource = @imagecreatefromjpeg($f[0]);
    $size = getimagesize($f[0]);
    imagecopyresized($source, $tempsource, 0, 0, 0, 0, 672, 936, $size[0], $size[1]);
    imagedestroy($tempsource);
    $im = imagecreatetruecolor(640, 902);
    imagecopy ($im, $source, 0, 0, 16, 17, 640, 902);
    imagejpeg($im,$f[1]);
    imagedestroy($im);
    imagedestroy($source);
}