<?php
/**
 * 连接数据库的函数
 */
//连接MySQL数据库
function db_connect(){
    $result = new mysqli('localhost','root','','bookmarks');
    if(!$result) {
        throw new Exception('Could not connect to database server');
    }else{
        return $result;
    }
}
?>