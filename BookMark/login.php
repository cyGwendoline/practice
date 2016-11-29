<?php
/**
 * 包含系统登录表单的页面
 */
require_once ('bookmark_fns.php');
do_html_header('');

display_site_info();
display_login_form();

do_html_footer();
?>