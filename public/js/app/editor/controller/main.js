function editor(appObject) {
	// 打开对话框
	layer.open({
		type: 1 //此处以iframe举例
		,title: appObject.attr('title')
		,area: [appObject.attr('app-width')+'px', appObject.attr('app-height')+'px']
		,shade: 0
		,minButton: true
		,maxButton: true
		,taskbar:true
		,content: render('index.html')
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});

	path = appObject.attr('app-path');
	$('.dialog-focus .editor-wrapper #file-path').val(path);

	$.ajax({
		url:config.url.openFile,
		type:'GET', // GET
		async:false, // 是否异步
		data:{
			path:path
		},
		dataType:'json',
		success:function(data,textStatus,jqXHR){
			if (data.status == 'success') {
				if(data.data) {
					$('.dialog-focus .editor-wrapper #editor').html(data.data);
				}
			} else {
				layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
			}
		},
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});
	var editor = ace.edit("editor");
    editor.setTheme("ace/theme/twilight");

}

function saveFile() {
	var editor = ace.edit("editor");
	filePath = $('.dialog-focus .editor-wrapper #file-path').val();
	$.ajax({
		url:config.url.saveFile,
		type:'POST', // GET
		async:false, // 是否异步
		data:{
			path:filePath,
			content:editor.getValue(),
		},
		dataType:'json',
		success:function(data,textStatus,jqXHR){
			if (data.status == 'success') {
				layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
			} else {
				layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
			}
		},
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});

}