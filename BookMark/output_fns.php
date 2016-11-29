<?php
/**
 * 以HTML形式格式化输出的函数
 * 包括函数 do_html_header(),
 * display_site_info(),添加一些关于网站的文本
 * display_login_form(),添加表单
 * do_html_footer() 为页面添加一个标准的HTML页脚
 * 等
 */
function do_html_header($title) {
    //print an HTML header
echo "<!DOCTYPE html>
<html>
<head>
    <title>".$title."</title>
    <style>
        body {font-family:\"Microsoft JhengHei\";font-size: 13px;}
        li,td{font-family:\"Microsoft JhengHei\";font-size: 13px;}
        hr{color: #3333cc;width: 300px;text-align: left;}
        a{color: #000000;}
    </style>
</head>
<body>
<img src=\"bookmark.jpg\" alt=\"BookMark logo\" border=\"0\" align=\"left\" height=\"50\" width=\"50\">
<h1>BookMark</h1>
<hr/>";
    if($title) {
        do_html_heading($title);
    }
}
function do_html_heading($title){}

function display_site_info() {
    echo "<h3>Welcome to my bookmark</h3>";
}
function display_login_form() {
    echo "
    <div class=\"login\">
        <form action=\"login.php\" method=\"post\" class=\"login-form\">
            <label>
                <input type=\"text\" name=\"username\" value=\"用户名\"/>
                <input type=\"password\" name=\"passed\" id=\"passed\"/>
            <input type=\"submit\" value=\"login\" id=\"submit\" name=\"submit\">
            </label>
        </form>
    </div><!--login end-->";
}
function do_html_footer() {
    echo "</body>
    </html>";
}

function display_reg_stration_form() {
    echo "
    <div class=\"login\">
        <form action=\"login.php\" method=\"post\" class=\"login-form\">
            <label>
                <input type=\"text\" name=\"username\" value=\"用户名\"/>
                <input type=\"password\" name=\"passwd\" id=\"passwd\"/>
                <input type=\"password\" name=\"passwd2\" id=\"passwd2\"/>
                <input type=\"text\" name=\"email\" value=\"邮箱地址\"/>
            <input type=\"submit\" value=\"login\" id=\"submit\" name=\"submit\">
            </label>
        </form>
    </div><!--login end-->";
}

function display_change_form() {
    echo "
    <div class=\"change_form\">
        <form action=\"change_passwd.php\" method=\"post\" class=\"login-form\">
            <label>
                <input type=\"password\" name=\"old_passwd\" id=\"old_passwd\"/>
                <input type=\"password\" name=\"new_passwd\" id=\"new_passwd\"/>
                <input type=\"password\" name=\"new_passwd2\" id=\"new_passwd2\"/>
            <input type=\"submit\" value=\"Change password\" id=\"submit\" name=\"submit\"/>
            </label>
        </form>
    </div><!--login end-->";
}

function display_forgot_form(){
    echo "
    <div class=\"forgot_form\">
        <form action=\"forgot_passwd.php\" method=\"post\" class=\"login-form\">
            <label>
            <h3>Please enter your username</h3>
                <input type=\"text\" name=\"username\" id=\"username\"/>
            <input type=\"submit\" value=\"Change password\" id=\"submit\" name=\"submit\"/>
            </label>
        </form>
    </div><!--forgot_form end-->";
}

function display_add_form(){
    echo "
    <div class=\"add_form\">
        <form action=\"add_bms.php\" method=\"post\" class=\"login-form\">
            <label>
            <h3>New BM</h3>
                <input type=\"text\" name=\"username\" id=\"username\" value='http://'/>
            <input type=\"submit\" value=\"Change password\" id=\"submit\" name=\"submit\"/>
            </label>
        </form>
    </div><!--add_form end-->";
}

function do_html_url($phpurl,$name){}

function display_user_urls(){}
?>

