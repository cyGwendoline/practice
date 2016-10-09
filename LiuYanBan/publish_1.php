
<?php
/**
 * 表单处理
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加留言</title>
</head>
<body>
<?php
require_once ('common.php');
mysql_query("set names utf8");
if($_POST['title']) {
    $name = $_REQUEST['username'];
    $title = $_REQUEST['title'];
    $img = "image/" . $_REQUEST['image'] . ".jpg";
    $content = nl2br($_REQUEST['content']);
    $n_time = $_REQUEST['n_time'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql2 = "insert into $tb_msn(author,title,image,content,ip) VALUES ('$name','$title','$img','$content','$ip')";
    if(mysql_query($sql2)) {
        echo "<html><head><meta http-equiv='content-type' content='text/html;charset=utf-8'/>";
        if($_COOKIE['admin']) {
            echo "<meta http-equiv='refresh' content='1;url=check.php'/>";
        }else {
            echo "<meta http-equiv='refresh' content='1;url=main.php'/>";
        }
        echo "</head><body>留言成功，1秒后返回首页...</body></html>";
    }else {
        echo "留言未添加成功，请重试";
    }
}else {
    echo "请添加留言";
}
?>
</body>
</html>
