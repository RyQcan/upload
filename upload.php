<?php

if(is_uploaded_file($_FILES["file"]["tmp_name"]))
{
    $upfile = $_FILES["file"];
    $type = $upfile["type"];
    if($type=='image/gif'||$type=='image/jpeg'||$type=='image/png'||$type=='image/bmp')
    {

        $name = $upfile["name"];
        $size = $upfile["size"];
        $tmp_name = $upfile["tmp_name"];
        echo "上传文件名:" . $name . "<br/>";
        echo "上传文件类型:" . $type . "<br/>";
        echo "上传文件大小:" . ($size / 1024) . "kb<br/>";


        $destination = "./uploadfile/" . $name;
        move_uploaded_file($tmp_name, $destination);
        echo"上传文件路径:".$destination."<br/>";
        echo "上传成功！";
        echo "<br>图片预览：<br/>";
        echo "<img src=" . $destination . ">";
    }
    else
    {
        echo"上传失败";
    }
}
else
{
    echo"上传失败";
}

?>