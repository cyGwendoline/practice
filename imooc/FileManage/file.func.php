<?php
/**
 * Byte(B)/KB/MB/GB/TB/EB
 * 文件大小单位转换
 * @param number $size
 * @return number
 */
function transByte($size){
    $arr = array("B","KB","MB","GB","TB","EB");
    $i=0;//默认单位为B
    while ($size>=1024) {
        $size/=1024;
        $i++;
    }
    return round($size,2).$arr[$i]; //精度为小数点后两位，$arr[$i]表示单位
}

/**
 * 创建文件
 * @param string $filename
 * @return string
 */
function createFile($filename,$fullname){
	//验证文件名的合法性，是否包含/,*,<>,?,|等特殊字符
	$pattern="/[\/,\*,\",\:,<>,\?,\|]/";
//	if(!preg_match($pattern,basename($filename))){ basename从文件路径中获取文件名，会自动过滤\,/，无法达到过滤特殊字符的需求
	if(!preg_match($pattern,$filename)){
		//检测当前目录下是否存在同名文件
		if(!file_exists($fullname)){
			//通过touch($filename)函数来创建
			if(touch(iconv("utf-8","GBK",$fullname))){
				return "文件创建成功";
			}else{
				return "文件创建失败";
			}
		}else{
			return "文件已存在，请重新命名";
		}
	}else{
		return "非法文件名";
	}
}

/**
 * 重命名文件
 * @param string $oldname
 * @param string $newname
 * @return string
 */
function renameFile($oldname,$newname){
	if(checkFilename($newname)){//验证合法性
		//检测当前目录下是否存在同名文件		
		$path=dirname($oldname);		
		if(!file_exists($newname)){
			//进行重命名		
			if(rename(iconv("utf-8","GBK",$oldname),$path."/".iconv("utf-8","GBK",$newname))){
				return "重命名成功";
			}else{
				return "重命名失败";
			} 
		}else{
			return "存在同名文件，请重新命名";
		}
	}else{
		return "存在非法字符";
	}
}

/**
 *检测文件名是否合法
 * @param string $filename
 * @return boolean
 */
function checkFilename($filename){
	$pattern="/[\/,\*,\",\:,<>,\?,\|]/";
	if(preg_match($pattern,$filename)){
		return false;
	}else{
		return true;
	}
}

/**
 * 删除文件
 * @param string $filename
 * @return string
 */
function delFile($filename){
	if(unlink($filename)){
		$mes="文件删除成功";
	}else{
		$mes="文件删除失败";
	}
	return $mes;
}

/**
 * 下载文件操作
 * @param string $filename
 */
function downFile($filename){
	header("content-disposition:attachment;filename=".basename($filename));
	header("content-length:".filesize($filename));
	readfile($filename);
}

/**
 * 复制文件
 * @param string $filename
 * @param string $dstname
 * @return string
 */
function copyFile($filename,$dstname){
	if(file_exists($dstname)){
		if(!file_exists($dstname."/".basename($filename))){
			if(copy($filename,$dstname."/".basename($filename))){
				$mes="文件复制成功";
			}else{
				$mes="文件复制失败";
			}
		}else{
			$mes="存在同名文件";
		}
	}else{
		$mes="目标目录不存在";
	}
	return $mes;
}

/**
 * 剪切文件
 * @param string $filename
 * @param string $dstname
 * @return string
 */
function cutFile($filename,$dstname){
	if(file_exists($dstname)){
		if(!file_exists($dstname."/".basename($filename))){
			if(rename($filename,$dstname."/".basename($filename))){
				$mes="文件剪切成功";
			}else{
				$mes="文件剪切失败";
			}
		}else{
			$mes="存在同名文件";
		}
	}else{
		$mes="目标目录不存在";
	}
	return $mes;
}

/**
 * 上传文件
 * @param unknow $fileInfo
 * @param string $path
 * @return string
 */
 function uploadFile($fileInfo,$path){
	 //判断错误号
	 if($fileInfo['error']==UPLOAD_ERR_OK){
		 //文件是否是通过HTTP POST方式上传的
		 if(is_uploaded_file($fileInfo['tmp_name'])){
			 //上传文件的文件名，只允许上传jpeg|jpg|png|gif|txt的文件
			 $allowExt=array("jpeg","jpg","png","gif","txt");
			 $ext=getExt($fileInfo['name']);
			 $maxSize=10485760;
			 $uniqid=getUniqidName();
		 $destination=$path."/".pathinfo($fileInfo['name'],PATHINFO_FILENAME)."_".$uniqid.".".$ext;
			 if(in_array($ext,$allowExt)){
				 if($fileInfo['size']<=$maxSize){
					 if(move_uploaded_file($fileInfo['tmp_name'],$destination)){
						 $mes="上传文件成功";
					 }else{
						 $mes="上传文件失败";
					 }
				 }else{
					 $mes="文件过大";
				 }
			 }else{
				 $mes="非法文件类型";
			 }			 
		 }else{
			 $mes="文件不是通过HTTP POST方式上传的";
		 }
	 }else{
		 switch($fileInfo['error']){
			 case 1:
				$mes="超过了配置文件的大小";
				break;
			 case 2:
				$mes="超过了表单允许接收的大小";
				break;
			 case 3:
				$mes="文件部分被上传";
				break;
			 case 4:
				$mes="没有文件上传";
				break;
		 }
	 }
	 return $mes;
 }