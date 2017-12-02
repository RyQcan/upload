<?php
if(!is_uploaded_file($_FILES["file"]["tmp_name"]))
{
    echo"上传失败！";
    return;
}
$upfile = $_FILES["file"];
$choice=$_POST["choices"];
if($choice='mime')
    mime($upfile);
else if($choice='blacklist')
    blacklist($upfile);
else if($choice='whitelist')
    whitelist($upfile);
else if($choice='rename')
    renames($upfile);
else if($choice='fileheader')
    fileheader($upfile);
else if($choice='render')
    render($upfile);
function success_upload($upfile)
{
    echo "上传文件名:" . $upfile["name"] . "<br/>";
    echo "上传文件类型:" . $upfile["type"] . "<br/>";
    echo "上传文件大小:" . ($upfile["size"] / 1024) . "kb<br/>";
    $destination = "./uploadfile/" . $upfile["name"];
    move_uploaded_file($upfile["tmp_name"], $destination);
    echo"上传文件路径:".$destination."<br/>";
    echo "上传成功！";
    echo "<br>图片预览：<br/>";
    echo "<img src=" . $destination . ">";
}
function mime($upfile)
{
    if($upfile["type"]=='image/gif'||$upfile["type"]=='image/jpeg'||$upfile["type"]=='image/png'||$upfile["type"]=='image/bmp')
        success_upload($upfile);
    else
        echo"上传失败";
}
function blacklist($upfile)
{
    $deny_ext=array('.asp','.php','.aspx','.jsp');//黑名单
    $file_ext=strrchr($upfile['name'],'.');
    if(in_array($file_ext,$deny_ext))
        echo"上传失败!";
  else
      success_upload($upfile);

}
function whitelist($upfile)
{
    $deny_ext=array('.jpg','.gif','.png','.bmp');//黑名单
    $file_ext=strrchr($upfile['name'],'.');
    if(!in_array($file_ext,$deny_ext))
        echo"上传失败!";
  else
      success_upload($upfile);
}
function renames($upfile)
{
    $fileArr=explode('.',$upfile['name']);
    $newfile=md5(uniqid(microtime()).'.'.$fileArr[1]);
    echo "上传文件名:" . $newfile . "<br/>";
    echo "上传文件类型:" . $upfile["type"] . "<br/>";
    echo "上传文件大小:" . ($upfile["size"] / 1024) . "kb<br/>";
    $destination = "./uploadfile/" . $newfile;
    move_uploaded_file($upfile["tmp_name"], $destination);
    echo"上传文件路径:".$destination."<br/>";
    echo "上传成功！";
    echo "<br>图片预览：<br/>";
    echo "<img src=" . $destination . ">";

}
function fileheader($upfile)
{

}
function render($upfile)
{

}
?>