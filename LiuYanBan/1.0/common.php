<?php
/**
 * 公共配置资源
 */
mysql_connect("localhost","root","") or die("连接失败".mysql_error());
mysql_select_db("bbs");
$tb_msn = "message";
$tb_user = "muser";
$list_num = 5;
?>