<?php
/**
 * 管理员回复留言页面
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>留言回复页</title>
</head>
<body>
<?php
require_once ("common.php");
mysql_query("set names utf8");
$rid = $_GET['rid'];
$reply = nl2br($_POST['rcontent']);
if($reply) {
    $sql = "update to $tb_msn set rcontent ='$reply' WHERE id = 'rid'";
    if(mysql_query($sql)) {
        echo "回复成功！";
        echo "<html><head><meta http-equiv='Content-Type' content='text/html;charset = utf8'/><meta http-equiv='refresh' content='1; url=check.php'/></head><body>留言删除成功，1秒后返回管理员首页...</body></html>";
    }else {
        echo "回复失败";
    }
}
?>