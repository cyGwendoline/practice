<?php
/**
 * 管理员登陆页
 */
if($_POST["username"]) {
    require_once "conn.php";
    mysql_query("set names uft-8");
    $name = $_REQUEST['username'];
    $pass = $_REQUEST['password'];
//查询muser表
    $sql = "select * from $tb_user where name='$name'and pass='$pass'";
    $result = mysql_query($sql);
    if(@mysql_num_rows($result)!=0) {
        setcookie("admin","$name",time()+60*5);//cookie保存5分钟
        echo "<html><head><meta http-equiv='Content-Type' content='text/html;charset=utf-8' /><meta http-equiv='refresh' content='1;url=check.php'/></head><body>登陆成功，1秒后返回首页...</body></html>>";
    }else {
        echo "<center>用户名或密码错误</center>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录</title>
<!-- <link href="#" rel="stylesheet" type="text/css" /> -->
    <script language="JavaScript">
        function check() {
            var s=document.all;
            if(s.username.value=="") {
                alert("请输入用户名");
                s.username.focus();
                return false;
            }
            if(s.pass.value=="") {
                alert("请输入密码");
                s.pass.focus();
                return false;
            }
        }
    </script>
</head>
<body>
<h1>管理员登陆</h1>
<form action="<?php $_SERVER[PHP_SELF]?>" method="post" name="form1" id="form1" onsubmit="return check()">
    用户名:<input type="text" name="username" id="username" size="10"/><br/>
    密码：<input type="password" name="password" id="password" value="" size="10"/><br/>
    <input type="submit" name="submit" value="登录"/>
</form>
<hr/>
<p>版权信息</p>
</body>
</html>