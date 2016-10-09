<?php
/**
 * 留言浏览页
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言查看页</title>
<!-- <link href="#" rel="stylesheet" type="text/css" /> -->
    <style type="text/css">
        <!--
        .style1{font-size: 36px}
        -->
    </style>
</head>
<body>
<p align="center" class="style1">留言本</p>
<p align="center"><a href="publish.php">发表留言</a><a href="login.php">管理留言</a> </p>
<p align="center">
    <?php
    require_once ("common.php");
    //分页
    if(!$_REQUEST['page']) {
        $page = 1;
    }else {
        $page = $_REQUEST['page'];
    }
    $sql = "select id from $tb_msn order by id desc";
    $result = mysql_query($sql);
    $num = @$mysql_num_rows($result);
    mysql_query("set names utf8");
    $tem = ($page-1)*$list_num;
    $sql1 = "select * from $tb_msn order by id DESC limit $tem,$list_num";
    $result1 = mysql_query($sql1);
    if(@$mysql_num_rows($result1)!=0) {
        $i = $num - $tem + 1;
        echo "<table width='600' border='1' align='center'>";
        while($row = mysql_fetch_array($result1)) {
            $i--;
            echo "<tr align='left'><td width='300'> ";
            echo "第".$i."条留言";
            echo "</td><td width='60%'><strong> ";
            echo $row['title'];
            echo "</strong></td><td width='50' height='50'>";
            if($row['image']) {
                echo "<img src=".$row['image'].">";
            }
            echo "</td></tr>";
            echo "<tr align='left'><td colspan='5'>";
            echo "留言内容<br/>&nbsp;&nbsp;&nbsp;&nbsp;".$row['content'];
            echo "</td></tr>";
            if($row['rcontent']) {
                echo "<tr><td colspan='5' align='left'><font color='red'>";
                echo "管理员回复:<br/>&nbsp;&nbsp;&nbsp;&nbsp;".$row['rcontent'];
                echo "</font></td></tr>";
            }
            echo "<tr align='right'><td colspan='6'> ";
            echo "本留言由".$row['author']."发表&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td></tr>";
        }
        echo "</table><br/>";
        $prev_page = $page-1;
        $next_page = $page+1;
        echo "<p align=\"center\">";
        echo "目前共有".$num."条记录&nbsp;|&nbsp;";
        $p_count = ceil($num/$list_num);
        echo "共分".$p_count."页显示&nbsp;|&nbsp;";
        echo "当前显示第".$page."页";
        echo "<p align='center'>";
        if($page<=1) {
            echo "第一页";
        }else {
            echo "<a href='$_SERVER[PHP_SELF]?page=1'>第一页</a> |";
        }
        if($prev_page>=1) {
            echo "<a href='$_SERVER[PHP_SELF]?page=$prev_page'>上一页</a> |";
        }
        if($next_page<=$p_count) {
            echo "<a href='$_SERVER[PHP_SELF]?page=$next_page'>下一页</a> |";
        }
        if($page>=$p_count) {
            echo "<a href='$_SERVER[PHP_SELF]?page=$p_count'>最后一页</a></p>\n";
        }
    }else{
        echo "还没有人留言呢";
    }
    echo "</p>";
    ?>
</body>
</html>