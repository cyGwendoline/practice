<?php
/**
 * 管理员查看留言页面
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理员查看留言</title>
    <style type="text/css">
        <!--
        .style1{font-size: 36px}
        -->
    </style>
</head>
<body>
<p>
<?php
if(!$_COOKIE['admin']) {
    echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><meta http-equiv='refresh' content='1;url=main.php'/></head>";
    echo "<body>无权限查看该页，1秒后返回首页...</body>";
    echo "</html>";
}else {
    require_once ('common.php');
    $type = $_GET["type"];
    $id = $_GET["id"];
    //分页
    if(!$_REQUEST['page']) {
        $page = 1;
    }else {
        $page = $_REQUEST['page'];
    }
    //显示留言本标题及导航项
    echo "<p align=\"center\" class=\"style1\">留言本</p>";
    echo "<p align=\"center\"><a href=\"publish.php\">发表留言</a><a href=\"exit.php\">退出登录</a> </p>";
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
            if($type=="reply" && $row['id']==$id) { //回复表单
                echo "<form action='reply.php?rid=$row[id]' method='post'>";
                echo "<tr><td colspan='5' align='center'>";
                echo "<textarea name='rcontent' cols='10' rows='5'></textarea><br/>";
                echo "<input type='submit' value='回复’/>";
                echo "</td></tr></form>";
            }
            echo "<tr align='center'><td colspan='6'> ";
            echo "本留言由".$row['author']."于".$row['n_time']."发表&nbsp;|&nbsp;";
            echo "发表人来自".$row['ip'];
            echo "</td></tr>";
            echo "<tr><td colspan='5' align='center'>";
            echo $_COOKIE['admin'].",你好";
            echo "<a href=\"delete.php?id=$row[id]\">删除</a>";
            echo "<a href=\"check.php?id = $row[id]&&type=reply\">删除</a>";
            echo "</td></tr>";
        }
        echo "</table><br/>";
        //分页
        $prev_page = $page-1;
        $next_page = $page+1;
        echo "<p align=\"center\">";
        echo "目前共有".$num."条记录&nbsp;|&nbsp;";
        $p_count = ceil($num/$list_num);
        echo "共分".$p_count."页显示&nbsp;|&nbsp;";
        echo "当前显示第".$page."页";
        echo "<p align='center'>";
        if($page<=1) {
            echo "第一页 |";
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
}
?>
</p>
</body>
</html>
