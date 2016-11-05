<?php
require_once ("dir.func.php");//存放所有与目录相关的操作
require_once ("file.func.php");//存放对文件的操作
require_once ("common.func.php");//存放公共操作
$path="file";//文件、目录路径
$i='';
if(isset($_REQUEST['path'])){
	$path=$_REQUEST['path']?$_REQUEST['path']:$path;
}
$info=readDirectory("$path");//dir.func.php，遍历目录函数
if(!$info){
	echo "<script type=text/javascript>alert(\"没有内容\");</script>";
	//echo "<script type=text/javascript>alert(\"没有内容\");location.href='index.php';</script>";//跳回首页则无法新增文件
}
$act="";
if(isset($_REQUEST['act'])){
	$act=$_REQUEST['act'];//操作名
}
if(isset($_REQUEST['filename'])){
	$filename=$_REQUEST['filename'];//新建文件名
}
if(isset($_REQUEST['dirname'])){
	$dirname=$_REQUEST['dirname'];//新建文件名
}
$redirect="index.php?path={$path}";//新url,{$path}将$path视为整体，避免歧义
if($act == "创建文件"){ //创建文件
	$fullname=$path."/".$filename;
	$mes=createFile($filename,$fullname);
	alertMes($mes,$redirect); 
}elseif($act == "showContent"){
	$content=file_get_contents($filename);//查看文件内容
	//echo "<textarea readonly='readonly'>{$content}</textarea>";
	//高亮显示PHP代码
	//highlight_string($content);//高亮显示字符串中的PHP代码
	//highlight_file($content);//高亮显示文件中的PHP代码
	if(strlen($content)){
		$newContent=highlight_string($content,true);//highlight_string()第二个参数默认为false,设置为true时以字符串形式返回文件中的内容
		$str=<<<EOF
		<table width='100%' bgcolor='pink' cellpadding='5' cellspacing="0" >
			<tr>
				<td>{$newContent}</td>
			</tr>
		</table>
EOF;
		echo $str;
	}else{
		alertMes("文件没有内容，请编辑再查看！",$redirect);
	}
}elseif($act=="editContent"){
	//编辑文件内容
	$content=file_get_contents($filename);
	$str=<<<EOF
	<form action='index.php?act=doEdit' method='post'> 
		<textarea name='content' cols='190' rows='10'>{$content}</textarea><br/>
		<input type='hidden' name='filename' value='{$filename}'/>
		<input type="hidden" name="path" value="{$path}" />
		<input type="submit" value="修改文件内容"/>
	</form>
EOF;
	echo $str;
}elseif($act=='doEdit'){
	//修改文件内容的操作
	$content=$_REQUEST['content'];
	if(file_put_contents($filename,$content)){
		$mes="文件修改成功";
	}else{
		$mes="文件修改失败";
	}
	alertMes($mes,$redirect);
}elseif($act=='renameFile'){
	//重命名
	$str=<<<EOF
	<form action="index.php?act=doRename" method="post"> 
	请填写新文件名:<input type="text" name="newname" placeholder="重命名"/>
	<input type='hidden' name='filename' value='{$filename}' />
	<input type="submit" value="重命名"/>
	</form>
EOF;
echo $str;
}elseif($act=='doRename'){
	//实现重命名的操作
	$newname=$_REQUEST['newname'];
	$mes=renameFile($filename,$newname);
	alertMes($mes,$redirect);
}elseif($act=='delFile'){
	//删除文件
	$mes=delFile($filename);
	alertMes($mes,$redirect);
}elseif($act=='downFile'){
	//下载文件
	$mes=downFile($filename);
}elseif($act=="创建文件夹"){
	$mes=createFolder($path."/".$dirname);
	alertMes($mes,$redirect);
}elseif($act=="renameFolder"){
	$str=<<<EOF
			<form action="index.php?act=doRenameFolder" method="post"> 
	请填写新文件夹名称:<input type="text" name="newname" placeholder="重命名"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='dirname' value='{$dirname}' />
	<input type="submit" value="重命名"/>
	</form>
EOF;
echo $str;
}elseif($act=="doRenameFolder"){
	$newname=$_REQUEST['newname'];
	//echo $newname,"-",$dirname,"-",$path;
	$mes=renameFolder($dirname,$path."/".$newname);
	alertMes($mes,$redirect);
}elseif($act=="copyFolder"){
		$str=<<<EOF
	<form action="index.php?act=doCopyFolder" method="post"> 
	将文件夹复制到：<input type="text" name="dstname" placeholder="将文件夹复制到"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='dirname' value='{$dirname}' />
	<input type="submit" value="复制文件夹"/>
	</form>
EOF;
echo $str;
}elseif($act=="doCopyFolder"){
	$dstname=$_REQUEST['dstname'];
	$mes=copyFolder($dirname,$path."/".$dstname."/".basename($dirname));
	alertMes($mes,$redirect);
}elseif($act=="cutFolder"){
			$str=<<<EOF
	<form action="index.php?act=doCutFolder" method="post"> 
	将文件夹剪切到：<input type="text" name="dstname" placeholder="将文件剪切到"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='dirname' value='{$dirname}' />
	<input type="submit" value="剪切文件夹"/>
	</form>
EOF;
echo $str;
}elseif($act=="doCutFolder"){
	//echo "文件夹被剪切了";
	$dstname=$_REQUEST['dstname'];
	$mes=cutFolder($dirname,$path."/".$dstname);
	alertMes($mes,$redirect);
}elseif($act=="delFolder"){
	//完成删除文件夹的操作
	//echo $dirname."文件夹被删除了";
	$mes=delFolder($dirname);
	alertMes($mes,$redirect);
}elseif($act=="copyFile"){
	$str=<<<EOF
	<form action="index.php?act=doCopyFile" method="post"> 
	将文件复制到：<input type="text" name="dstname" placeholder="将文件复制到"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='filename' value='{$filename}' />
	<input type="submit" value="复制文件"/>
	</form>
EOF;
echo $str;
}elseif($act=="doCopyFile"){
	//复制文件
	$dstname=$_REQUEST['dstname'];
	$mes=copyFile($filename,$path."/".$dstname);
	alertMes($mes,$redirect);
}elseif($act=="cutFile"){
	//剪切文件
	$str=<<<EOF
	<form action="index.php?act=doCutFile" method="post"> 
	将文件剪切到：<input type="text" name="dstname" placeholder="将文件剪切到"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='filename' value='{$filename}' />
	<input type="submit" value="剪切文件"/>
	</form>
EOF;
echo $str;
}elseif($act=="doCutFile"){
	$dstname=$_REQUEST['dstname'];
	$mes=cutFile($filename,$path."/".$dstname);
	alertMes($mes,$redirect);
}elseif($act=="上传文件"){
	//print_r($_FILES);
	$fileInfo=$_FILES['myFile'];
	$mes=uploadFile($fileInfo,$path);
	alertMes($mes, $redirect);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>在线文件管理器</title>
    <link rel="stylesheet" href="cikonss.css" />
    <script src="jquery-ui/js/jquery-1.10.2.js"></script>
    <script src="jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <link rel="stylesheet" href="jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css"  type="text/css"/>
    <script type="text/javascript" src="js/index.js"></script>
	<link rel="stylesheet" href="css/index.css"  type="text/css"/>
</head>

<body>
<div id="showDetail"><img src="" id="showImg" alt=""/></div>
<h1>慕课网-在线文件管理器</h1>
<div id="top">
    <ul id="navi">
        <li><a href="index.php" title="主目录"><span class="icon icon-small icon-square"><span class="icon-home"></span></span></a></li>
        <li><a href="#"  onclick="show('createFile')" title="新建文件" ><span class="icon icon-small icon-square"><span class="icon-file"></span></span></a></li>
        <li><a href="#"  onclick="show('createFolder')" title="新建文件夹"><span class="icon icon-small icon-square"><span class="icon-folder"></span></span></a></li>
        <li><a href="#" onclick="show('uploadFile')"title="上传文件"><span class="icon icon-small icon-square"><span class="icon-upload"></span></span></a></li>
		<?php 
		$back=($path=="file")?"file":dirname($path);
		?>
        <li><a href="#" title="返回上级目录" onclick="goBack('<?php echo $back;?>')"><span class="icon icon-small icon-square"><span class="icon-arrowLeft"></span></span></a></li>
    </ul>
</div>
<form action="index.php" method="post" enctype="multipart/form-data">
	<table width="100%" border="1" cellpadding="5" cellspacing="0" bgcolor="#ABCDEF" align="center">
		<tr id="createFolder">
			<td>请输入文件夹名称</td>
			<td >
				<input type="text" name="dirname" />
				<input type="hidden" name="path"  value="<?php echo $path;?>"/>
				<input type="submit"  name="act"  value="创建文件夹"/>
			</td>
		</tr>
		<tr id="createFile">
			<td>请输入文件名称</td>
			<td >
				<input type="text"  name="filename" />
				<input type="hidden" name="path" value="<?php echo $path;?>"/>
				<input type="submit"  name="act" value="创建文件" />	
			</td>
		</tr>
		<tr id="uploadFile">
			<td >请选择要上传的文件</td>
			<td ><input type="file" name="myFile" />
				<input type="submit" name="act" value="上传文件" />	
			</td>
		</tr>
		<tr>
			<td>编号</td>
			<td>名称</td>
			<td>类型</td>
			<td>大小</td>
			<td>可读</td>
			<td>可写</td>
			<td>可执行</td>
			<td>创建时间</td>
			<td>修改时间</td>
			<td>访问时间</td>
			<td>操作</td>
		</tr>
	<!-- 遍历输出文件信息 -->
	<?php
	if($info['file']){
		$i=1;
		foreach ($info['file'] as $val){
			$add=$path."/".$val;
	?>
		<tr>
			<td><?php echo $i;?></td><!--文件编号-->
			<td><?php echo iconv("GBK","utf-8",$val);?></td><!--文件名-->
			<td><?php $src=filetype($add)=="file"?"file_ico.png":"folder_ico.png";?><img src="images/<?php echo $src?>" alt="" title="文件"/></td><!--文件类型-->
			<td><?php echo transByte(filesize($add));?></td><!--文件大小-->
			<td><?php $src=is_readable($add)?"correct.png":"error.png";?><img src="images/<?php echo $src?>" alt="" title="文件可读性" width="30" height="30"/></td><!--可读-->
			<td><?php $src=is_writable($add)?"correct.png":"error.png";?><img src="images/<?php echo $src?>" alt="" title="文件可写性" width="30" height="30"/></td><!--可写-->
			<td><?php $src=is_executable($add)?"correct.png":"error.png";?><img src="images/<?php echo $src?>" alt="" title="文件可操作性" width="30" height="30"/></td><!--可执行-->
			<td><?php echo date("Y-m-d H:i:s",filectime($add));?></td><!--文件创建时间-->
			<td><?php echo date("Y-m-d H:i:s",filemtime($add));?></td><!--文件修改时间-->
			<td><?php echo date("Y-m-d H:i:s",fileatime($add));?></td><!--文件访问时间-->
			<td><!--对文件的操作-->
<?php 
//得到文件扩展名,如果是图片就直接利用jQuryUI显示图片
	$arr=explode(".",$val);
	$ext=strtolower(end($arr));
	$imageExt=array("gif","jpg","jpeg","png");
	if(in_array($ext,$imageExt)){
?>
				<a href="#" onclick="showDetail('<?php echo iconv("GBK","utf-8",$val);?>','<?php echo iconv("GBK","utf-8",$add);?>')"><img class="small" src="images/show.png"  alt="" title="查看"/></a>|
				<a href=""><img class="small" src="images/edit.png"  alt="" title="修改"/></a>|
				
<?php
	}else{
?>
				<a href="index.php?act=showContent&path=<?php echo $path;?>&filename=<?php echo iconv("GBK","utf-8",$add);?> " ><img class="small" src="images/show.png"  alt="" title="查看"/></a>|
				<a href="index.php?act=editContent&path=<?php echo $path;?>&filename=<?php echo iconv("GBK","utf-8",$add);?> "><img class="small" src="images/edit.png"  alt="" title="修改"/></a>|
<?php
	}
?>								
				<a href="index.php?act=renameFile&path=<?php echo $path;?>&filename=<?php echo iconv("GBK","utf-8",$add);?>"><img class="small" src="images/rename.png"  alt="" title="重命名"/></a>|
				<a href="index.php?act=copyFile&path=<?php echo $path;?>&filename=<?php echo iconv("GBK","utf-8",$add);?>"><img class="small" src="images/copy.png"  alt="" title="复制"/></a>|
				<a href="index.php?act=cutFile&path=<?php echo $path;?>&filename=<?php echo iconv("GBK","utf-8",$add);?>"><img class="small" src="images/cut.png"  alt="" title="剪切"/></a>|
				<a href="#"  onclick="delFile('<?php echo iconv("GBK","utf-8",$add);?>','<?php echo $path;?>')"><img class="small" src="images/delete.png"  alt="" title="删除"/></a>|
				<a href="index.php?act=downFile&path=<?php echo $path;?>&filename=<?php echo iconv("GBK","utf-8",$add);?>"><img class="small"  src="images/download.png"  alt="" title="下载"/></a>
			</td>
		</tr>
	 <?php
			$i++;
		}
	}
	?>
<!-- 文件夹操作 -->	
	<?php
	if($info['dir']){
		$i=$i==null?1:$i;
		foreach ($info['dir'] as $val){
			$add=$path."/".$val;
	?>
		<tr>
			<td><?php echo $i;?></td><!--文件编号-->
			<td><?php echo iconv("GBK","utf-8",$val);?></td><!--文件名-->
			<td><?php $src=filetype($add)=="file"?"file_ico.png":"folder_ico.png";?><img src="images/<?php echo $src?>" alt="" title="文件"/></td><!--文件类型-->
			<td><?php $sum=0;echo transByte(dirSize($add));?></td><!--文件大小-->
			<td><?php $src=is_readable($add)?"correct.png":"error.png";?><img src="images/<?php echo $src?>" alt="" title="文件可读性" width="30" height="30"/></td><!--可读-->
			<td><?php $src=is_writable($add)?"correct.png":"error.png";?><img src="images/<?php echo $src?>" alt="" title="文件可写性" width="30" height="30"/></td><!--可写-->
			<td><?php $src=is_executable($add)?"correct.png":"error.png";?><img src="images/<?php echo $src?>" alt="" title="文件可操作性" width="30" height="30"/></td><!--可执行-->
			<td><?php echo date("Y-m-d H:i:s",filectime($add));?></td><!--文件创建时间-->
			<td><?php echo date("Y-m-d H:i:s",filemtime($add));?></td><!--文件修改时间-->
			<td><?php echo date("Y-m-d H:i:s",fileatime($add));?></td><!--文件访问时间-->
			<td><!--对文件夹的操作-->
				<a href="index.php?path=<?php echo $add;?>"><img class="small" src="images/show.png"  alt="" title="查看"/></a>|
				<a href="index.php?act=renameFolder&path=<?php echo $path;?>&dirname=<?php echo iconv("GBK","utf-8",$add);?>"><img class="small" src="images/rename.png"  alt="" title="重命名"/></a>|
				<a href="index.php?act=copyFolder&path=<?php echo $path;?>&dirname=<?php echo iconv("GBK","utf-8",$add);?>"><img class="small" src="images/copy.png"  alt="" title="复制"/></a>|
				<a href="index.php?act=cutFolder&path=<?php echo $path;?>&dirname=<?php echo iconv("GBK","utf-8",$add);?>"><img class="small" src="images/cut.png"  alt="" title="剪切"/></a>|
				<a href="#"  onclick="delFolder('<?php echo iconv("GBK","utf-8",$add);?>','<?php echo $path;?>')"><img class="small" src="images/delete.png"  alt="" title="删除"/></a>
			</td>
		</tr>
	 <?php
			$i++;
		}
	}
	?>
	</table>
</form>
</body>
</html>