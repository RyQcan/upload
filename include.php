<?php
/**
 * Created by PhpStorm.
 * User: zrq
 * Date: 2018/1/11
 * Time: 11:12
 */
header("Content-type: text/html; charset=utf-8");

$filename=$_GET['text'];
$method=$_GET['choices'];

if($method=='rename'){
    $fileArr=explode('.',$filename);
    $filename=$fileArr[0].'.jpg';//强制重命名为xxx.jpg
}

$filename= "./uploadfile/" . $filename;//添加路径
include($filename);

?>