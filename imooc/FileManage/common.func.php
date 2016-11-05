<?php
/**
 * 提示操作信息的，并且跳转
 * @param string $mes
 * @param string $url
 */
function alertMes($mes,$url){
	echo "<script type='text/javascript'>alert('{$mes}');location.href='{$url}';</script>";
}

/**
 * 提取文件扩展名
 * @param int $length
 * @return string
 */
function getExt($filename){
	return strtolower(pathinfo($filename,PATHINFO_EXTENSION));
}

/**
 * 生成唯一文件名
 * @param string $filename
 * @return string
 */
function getUniqidName($length=10){	
	return substr(md5(uniqid(microtime(true),true)),0,$length);
}
?>