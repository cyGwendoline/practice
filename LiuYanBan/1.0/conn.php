<?php
/**
 * 创建数据库及相册系统
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>留言板安装</title>
</head>
<body>
<?php
$host = "localhost";
$user = "root";
$pass = "";
$link = mysql_connect($host,$user,$pass);
$sql = "create detabase bbs";//创建数据库
if(mysql_query($sql,$link)) {
    echo "数据库安装成功<br/>";
    $sql = "create table message(id int(5) not NULL PRIMARY key auto_increment,title varchar(50) not NULL ,n_time VARCHAR(15) not NULL,author varchar(30) not NULL,image VARCHAR(50),content text(250) not NULL ,ip VARCHAR(30) ,rcontent text(250))";
    if(mysql_query($sql)) {
        echo "message表创建成功<br/>";
    }else {
        echo "message表创建失败<br/>";
    }
    $sql2 = "create table muser(id int(2) not NULL PRIMARY KEY auto_increment,name VARCHAR(20) NOT NULL ,pass VARCHAR(20) NOT NULL)";
    if(mysql_query($sql2)) {
        echo "muser表创建成功<br/>";
    }else {
        echo "muser表创建失败<br/>";
    }
    echo "<br/>";
    $sql3 = "insert into muser(name,pass) VALUES ('admin','admin')";
    if(mysql_query($sql3)) {
        echo "添加管理员成功<br/>";
    }else {
        echo "管理员添加失败<br/>";
    }
}else {
    echo "数据库安装不成功<br/>";
}
?>
</body>
</html>