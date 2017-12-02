<?php
if(!is_uploaded_file($_FILES["file"]["tmp_name"]))
{
    echo"上传失败！";
    return;
}

$choice=$_POST["choices"];
$upfile = $_FILES["file"];
if($choice=='mime')
    mime($upfile);
else if($choice=='blacklist')
    blacklist($upfile);
else if($choice=='whitelist')
    whitelist($upfile);
else if($choice=='rename')
    renames($upfile);
else if($choice=='fileheader')
    fileheader($upfile);
else if($choice=='render')
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
    $wish_ext=array('.jpg','.gif','.png','.bmp');//白名单
    $file_ext=strrchr($upfile['name'],'.');
    if(!in_array($file_ext,$wish_ext))
        echo"上传失败!";
    else
        success_upload($upfile);
}

function renames($upfile)
{
    $fileArr=explode('.',$upfile['name']);
    $newfile=md5(uniqid(microtime())).'.'.$fileArr[1];//这里可以强制修改扩展名为jpg
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
    $typelist=array(
        array("FFD8FFE1","jpg"),
        array("89504E47","png"),
        array("47494638","gif"),
        array("49492A00","bmp")
    );
    $file=@fopen($upfile['tmp_name'],"rb");
    $bin=fread($file,5);
    fclose($file);
    foreach($typelist as $v)
    {
        $blen=strlen(pack("H*",$v[0]));
        $tbin=substr($bin,0,intval($blen));
        $a=@array_shift(unpack("H*",$tbin));
        if(strtolower($v[0])==strtolower($a))
        {
            success_upload($upfile);
            return;
        }
    }
    echo"上传失败";
}

function render($upfile)
{
    $destination = "./uploadfile/" . $upfile["name"];
    if(move_uploaded_file($upfile["tmp_name"], $destination))
    {
        //使用上传的图片生成新的图片
        $im = imagecreatefromjpeg($destination);

        //给新图片指定文件名
        srand(time());
        $newfilename = strval(rand()).".jpg";
        print "<pre>new file name $newfilename </pre>";
        $newimagepath ="./uploadfile/".$newfilename;
        imagejpeg($im,$newimagepath);
        //显示二次渲染后的图片（使用用户上传图片生成的新图片）
        echo "<img src=" .  $newimagepath . ">";
        unlink($destination);
    }
    else
    {
        echo"上传失败";
    }


}
?>