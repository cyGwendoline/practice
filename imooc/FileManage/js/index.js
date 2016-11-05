function show(dis){
            document.getElementById(dis).style.display="block";
        }
        function delFile(filename,path){
            if(window.confirm("您确定要删除嘛?删除之后无法恢复哟!!!")){
                location.href="index.php?act=delFile&filename="+filename+"&path="+path;
            }
        }
        function delFolder(dirname,path){
            if(window.confirm("您确定要删除嘛?删除之后无法恢复哟!!!")){
                location.href="index.php?act=delFolder&dirname="+dirname+"&path="+path;
            }
        }
		//弹出对话框,显示图片
        function showDetail(t,filename){
            $("#showImg").attr("src",filename);
            $("#showDetail").dialog({
                height:"auto",
                width: "auto",
                position: {my: "center", at: "center",  collision:"fit"},//对话框的位置
                modal:false,//是否模式对话框
                draggable:true,//是否允许拖拽
                resizable:true,//是否允许拖动
                title:t,//对话框标题
                show:"slide",
                hide:"explode"
            });
        }
		//返回上级目录
        function goBack($back){ 
            location.href="index.php?path="+$back;
        }