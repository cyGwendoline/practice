<?php
/**
 * 管理员删除留言页面
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>留言删除页</title>
</head>
<body>
<?php
require_once ("common.php");
$id = $_GET['id'];
$del = "delete from $tb_msn where id = $id";
if(mysql_query($del)) {
    echo "<html><head><meta http-equiv='Content-Type' content='text/html;charset = utf8'/><meta http-equiv='refresh' content='1; url=check.php'/></head>";
    echo "<body>留言删除成功，1秒后返回管理员首页...</body></html>";
}else {
    echo "删除出错了";
}
?>
</body>
</html>
