<?php
/**
 * 留言发表页
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>发表留言</title>
    <!-- <link href="#" rel="stylesheet" type="text/css" /> -->
    <style type="text/css">
        <!--
        .style1{font-size: 36px}
        -->
    </style>
    <script language="JavaScript">
        function check() {
            var s=document.all;
            if(s.username.value=="") {
                alert("请输入昵称");
                s.username.focus();
                return false;
            }
            if(s.title.value=="") {
                alert("请输入标题");
                s.title.focus();
                return false;
            }
            if(s.content.value=="") {
                alert("请输入留言内容");
                s.content.focus();
                return false;
            }
        }
    </script>
</head>
<body>
<div align="center">
    <p align="center" class="style1">留言本</p>
    <p align="center">
        <a href="publish.php">发表留言</a>
        <a href="login.php">管理留言</a>
    </p>
</div>
<form action="publish_1.php" method="post" name="form1" id="form1" onsubmit="return check()">
    <table width="550" border="1" align="center">
        <tr>
            <td width="20%">昵称：</td>
            <td width="80%">
                <input type="text" name="username" id="username" value="<?php if($_COOKIE['admin']) echo $_COOKIE['admin'];?>" size="20"/>
            </td>
        </tr>
        <tr>
            <td width="20%">主题：</td>
            <td width="80%">
                <input name="title" type="text" id="title" value="" size="20"/>
            </td>
        </tr>
        <tr>
            <td>头像：</td>
            <td>
                <input type="radio" name="image" value="1" checked="checked" />
                <img src="image/1.jpg" width="50" height="50" />
                <input type="radio" name="image" value="2"/>
                <img src="image/2.jpg" width="50" height="50" />
            </td>
        </tr>
        <input type="hidden" name="n_time" value="<?php date()?>"/>
        <tr>
            <td width="20%">留言内容：</td>
            <td width="80%">
                <textarea rows="10" cols="40" name="content" id="content"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="submit" value="添加"/>&nbsp;&nbsp;
                <input type="reset" name="reset" value="重置"/>
            </td>
        </tr>
    </table>
</form>
</body>
</html>