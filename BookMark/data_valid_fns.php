<?php
/**
 * 确认用户输入数据有效的函数
 */
//检查表单是否完全填写
function filled_out($form_vars) {
    //test that each variable has a value
    foreach ($form_vars as $key=>$value) {
        if((!isset($key))||($value=='')) {
            return false;
        }
    }
    return true;
}

//检查邮件地址是否有效
function valid_email($address) {
    //check an email address is possibly valid
    $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    if(preg_match($pattern,$address)){
        return true;
    }else{
        return false;
    }
}
?>