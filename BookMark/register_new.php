<?php
/**
 * 处理新注册信息的脚本
 */
require_once ('bookmark_fns.php');/*引入函数*/

//create short variable names
$email=$_POST['email'];
$username=$_POST['username'];
$password=$_POST['passwd'];
$password2=$_POST['passwd2'];
//start session which may be needed later
//start it now because it must go before headers
session_start();
try{
    //check forms filled in
    if(!filled_out($_POST)) {
        throw new Exception('You have not filled the form out correctly,please go back and try again.');
    }
    //emain address not valid
    if(!valid_email($email)) {
        throw new Exception('That is not a valid email address.please go back and try again.');
    }
    //password not the same
    if($password!=$password2) {
        throw new Exception('The passwords you entered do not match.please go back and try again.');
    }
    //check password length is ok
    //ok if username truncates,but passwords will get munged if they are too long.
    if((strlen($password)<6)||(strlen($username)>16)) {
        throw new Exception('Your password must be between 6 and 16 characters.please go back and try again.');
    }
    //attempt to register
    //this function can also throw an exception
    register($username,$email,$password);
    //register session variable
    $_SESSION['valid_user']=$username;
    //provide link to members page
    do_html_header('Registration successful');
    echo 'Your registration was successful.Go to the members page to start setting up your bookmarks!';
    do_html_url('member.php','Go to members page');//该函数尚未编写
    //end page;
    do_html_footer();
}
catch (Exception $e){
    do_html_header('Problem:');
    echo $e->getMessage();
    do_html_footer();
    exit;
}

?>