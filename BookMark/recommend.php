<?php
/**
 * 基于用户以前的操作，推荐用户可能感兴趣的书签
 */
require_once ('bookmark_fns.php');
session_start();
do_html_header('Recommending URLs');
try{
    check_valid_user();
    $urls=recommend_urls($_SESSION['valid_user']);
    display_recommend_urls($urls);
}
catch (Exception $e){
    echo $e->getMessage();
}
display_user_menu();
do_html_footer();
?>