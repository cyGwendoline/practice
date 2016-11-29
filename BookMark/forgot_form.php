<?php
/**
 * 用户忘记密码后需要填写的表单
 */
require_once ('bookmark_fns.php');
do_html_header('Forgot password');

display_forgot_form();

do_html_footer();
?>