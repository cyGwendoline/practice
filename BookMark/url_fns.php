<?php
/**
 * 添加和删除书签的函数
 */
require_once ('bookmark_fns.php');
session_start();

//create short variable name
$new_url=$_POST['new_url'];
do_html_header('Adding bookmarks');
try{
    check_valid_user();
    if(!filled_out($_POST)){
        throw new Exception('Form not completely filled out.');
    }
    //check URL is valid
    if(!(@fopen($new_url,'r'))){
        throw new Exception('Not a valid URL');
    }
    //try to add bm
    //add_bm 将用户提交的新书签添加到数据库中
    add_bm($new_url);
    echo "Bookmark added.";

    //get the bookmarks this user has saved
    if($new_url=get_user_urls($_SESSION['valid_user'])){
        display_user_urls($url_array);
    }
}
catch (Exception $e){
    echo $e->getMessage();
}
display_user_menu();
do_html_footer();

//从数据库中取回用户书签
function get_user_urls($username){
    //extract from database all the URLs this user has stored
    $conn=db_connect();
    $result=$conn->query("select bm_URL from bookmark WHERE username='".$username."'");
    if(!$result){
        return false;
    }
    //create an array of the URLs
    $url_array=array();
    for($count=0;$row=$result->fetch_row();++$count){
        $url_array[$count]=$row[0];
    }
    return $url_array;
}

//从用户的书签列表中删除一个书签
function delete_bm($user,$url){
    //delete one URL from the database
    $conn=db_connect();

    //delete the bookmark
    if(!$conn->query("delete from bookmark where username='".$user."' and bm_url='".$url."'")) {
        throw new Exception('Bookmark could not be deleted');
    }
    return true;
}

//推荐书签URLs
function recommend_urls($valid_urls,$popularity=1){
    //we will provide semi intelligent recommendations to people
    //if they have an URL in common with other users,they may like
    //other URLs that these people like
    $conn=db_connect();

    //find other matching users with an URL the same as you as a simple way of excluding people's
    //private pages,and increasing the chance of recommending appealing URLs,we specify a minimum popularity level
    //if $popularity=1,then more than one perseon must have an URL before we will recommend it
    $query="select bm_URL from bookmark where username in (select DISTINCT (b2.username) from bookmark b1,bookmark b2 WHERE b1.username='".$valid_urls."' and b1.username!=b2.username and b1.bm_URL=b2.bm_URL) and bm_URL not in (select bm_URL from bookmark where username='".$valid_urls."')group by bm_url having count(bm_url)>".$popularity;
    if(!($result=$conn->query($query))){
        throw new Exception('Could not find any bookmark to recommend.');
    }
    if($result->num_rows==0){
        throw new Exception('Could not find andy bookmarks to recommend.');
    }

    $urls=array();
    //build an array of the relevant urls
    for($count=0;$row=$result->fetch_object();$count++){
        $urls[$count]=$row->bm_URL;
    }
    return $urls;
}
?>
