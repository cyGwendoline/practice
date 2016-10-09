<?php
/**
 * 管理员退出登录页面
 */
if(!$_COOKIE['admin']) {
    echo "<html><head><meta http-equiv='Content-Type' content='text/html;charset = utf8'/><meta http-equiv='refresh' content='1; url=main.php'/></head><body>无权限访问，1秒后返回首页...</body></html>";
}else {
    setcookie("admin",""); //撤销cookie
    echo "<html><head><meta http-equiv='Content-Type' content='text/html;charset = utf8'/><meta http-equiv='refresh' content='1; url=check.php'/></head><body>成功退出，1秒后返回首页...</body></html>";
}
?>
