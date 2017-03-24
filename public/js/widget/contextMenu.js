define("widget/contextMenu", [ "context", "appsort" ], function(require) {
    // 右击menu菜单
	context.init({preventDoubleContext: false});
	context.settings({compress: true});
	// 桌面右击menu菜单
	context.attach('.desktop', [
		{header: ''},
		{text: lang.view, subMenu: [
			{text: lang.autoAlign, action: function(e){
				// 重排图标
				appsort.init();
				e.preventDefault();
			}}
		]},
		{text: lang.refresh, action: function(e){
			// 刷新
			window.location.reload();
		}},
		{divider: true},
		{text: lang.create, subMenu: [
			{text: lang.folder, action: function(e){
				path = context.appObject.attr('current-path');
				// 新建文件夹
				newFolder('.desktop .app-list',path,'appdblclick');
				e.preventDefault();
			}},
			{text: lang.textFile, action: function(e){
				path = context.appObject.attr('current-path');
				// ajax请求后台数据
				newFile('.desktop .app-list',path,lang.newTextFile,'txt','appdblclick');
				e.preventDefault();
			}}
		]},
		{text: lang.paste, action: function(e){
			// 粘贴
			pastePath('.desktop .app-list',context.appObject,'appdblclick');
		}},
		{text: lang.upload, action: function(e){
			// 上传
			upload('.desktop .app-list',context.appObject,'appdblclick');
		}},
		// {divider: true},
		// {text: lang.wallpaperSetting, action: function(e){
		// 	e.preventDefault();
		// }}
	]);

	// 资源管理器右击menu菜单
	context.attach('.dialog-focus .finder-wrapper .content', [
		{header: ''},
		{text: lang.view, subMenu: [
			{text: lang.autoAlign, action: function(e){
				appsort.init();
				e.preventDefault();
			}}
		]},
		{text: lang.refresh, href: '#'},
		{divider: true},
		{text: lang.create, subMenu: [
			{text: lang.folder, action: function(e){
				path = context.appObject.attr('current-path');
				// ajax请求后台数据
				newFolder('.dialog-focus .finder-wrapper .app-list',path,'appdblclick');
				e.preventDefault();
			}},
			{text: lang.textFile, action: function(e){
				path = context.appObject.attr('current-path');
				// ajax请求后台数据
				newFile('.dialog-focus .finder-wrapper .app-list',path,lang.newTextFile,'txt','appdblclick');
				e.preventDefault();
			}}
		]},
		{text: lang.paste, action: function(e){
			// 粘贴
			pastePath('.dialog-focus .finder-wrapper .app-list',context.appObject,'appdblclick');
		}},
		{text: lang.upload, action: function(e){
			// 上传
			upload('.dialog-focus .finder-wrapper .app-list',context.appObject,'appdblclick');
		}},
		// {divider: true},
		// {text: lang.wallpaperSetting, action: function(e){
		// 	e.preventDefault();
		// }}
	]);

	// 资源管理器程序右击menu菜单
	context.attach('.finder', [
		{header: ''},
		{text: lang.open, action: function(e){
			// 打开app
			context.exeApp();
			e.preventDefault();
		}},
		{divider: true},
		{text: lang.cut, action: function(e){
			// 剪切
			$.cookie('pastePath','1:'+context.appObject.attr('app-path'));
			e.preventDefault();
		}}
		,
		{text: lang.copy, action: function(e){
			// 复制
			$.cookie('pastePath','2:'+context.appObject.attr('app-path'));
			e.preventDefault();
		}},
		{divider: true},
		{text: lang.delete, action: function(e){
			// 删除路径
			deletePath(context.appObject);
			e.preventDefault();
		}},
		{text: lang.rename, action: function(e){
			// 重命名路径
			renamePath(context.appObject)
			e.preventDefault();
		}},
		{divider: true},
		{text: lang.attribute, action: function(e){
			e.preventDefault();
		}}
	]);

	// file文件右击menu菜单
	context.attach('.file', [
		{header: ''},
		{text: lang.open, action: function(e){
			// 打开app
			context.exeApp();
			e.preventDefault();
		}},
		{divider: true},
		{text: lang.cut, action: function(e){
			// 剪切
			$.cookie('pastePath','1:'+context.appObject.attr('app-path'));
			e.preventDefault();
		}}
		,
		{text: lang.copy, action: function(e){
			// 复制
			$.cookie('pastePath','2:'+context.appObject.attr('app-path'));
			e.preventDefault();
		}}
		,
		{divider: true},
		{text: lang.delete, action: function(e){
			// 删除路径
			deletePath(context.appObject);
			e.preventDefault();
		}},
		{text: lang.rename, action: function(e){
			// 重命名路径
			renamePath(context.appObject)
			e.preventDefault();
		}},
		{text: lang.download, action: function(e){
			// 下载
			download(context.appObject);
		}},
		{divider: true},
		{text: lang.attribute, action: function(e){
			e.preventDefault();
		}}
	]);

	context.attach('.computer', [
		{header: ''},
		{text: lang.open, action: function(e){
			// 打开app
			context.exeApp();
			e.preventDefault();
		}}
	]);

	context.attach('.trash', [
		{header: ''},
		{text: lang.open, action: function(e){
			// 打开app
			context.exeApp();
			e.preventDefault();
		}},
		{divider: true},
		{text: lang.emptyTrash, action: function(e){
			emptyTrash(context.appObject)
			e.preventDefault();
		}}
	]);

	context.attach('.trash-wrapper .content', [
		{header: ''},
		{text: lang.emptyTrash, action: function(e){
			emptyTrash(context.appObject)
			$('.trash-wrapper .content .app-list').html('');
			e.preventDefault();
		}}
	]);

});

/**
 * 新建文件夹
 * @author tangtanglove
 */
function newFolder(selecter,path,eventClass) {
	context.ajax({
		url:config.url.finderMakeDir,
		type:'GET', // GET
		async:false, // 是否异步
		data:{
			path:path+lang.newFolder
		},
		dataType:'json',
		success:function(data,textStatus,jqXHR){
			if (data.status == 'success') {
				html = "<div class='app-box middle "+eventClass+" finder' title='"+lang.newFolder+"' app-path='"+path+lang.newFolder+"/' app-name='finder' app-width=800 app-height=450>\
				<span class='app-icon'><img class='img-rounded' src='.\/images\/apps\/GenericFolderIcon.png' alt='"+lang.newFolder+"' app-path='"+path+lang.newFolder+"' app-width=800 app-height=450></span>\
				<span class='app-name'>"+lang.newFolder+"</span>\
				<div class='clear'></div>\
				</div>";
				$(selecter).append(html);
				// 重排图标
				appsort.init();
			} else {
				layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
			}
		},
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});
}

/**
 * 路径重命名
 * @author tangtanglove
 */
function renamePath(appObject) {

	// 获取路径
	path = appObject.attr('app-path');
	// 获取标题
	title = appObject.find('.app-name').html();
	// 插入input
	appObject.find('.app-name').html("<input class='rename' value='"+title+"' />");
	// 全选所有文字
	$('.rename').select();
	// 绑定mousedown事件
	$(document).mousedown(function(){
		newTitle = appObject.find('.rename').val();
		if (newTitle) {
			// ajax请求后台数据
			context.ajax({
				url:config.url.finderRenamePath,
				type:'GET', // GET
				data:{
					path:path,
					newTitle:newTitle,
					oldTitle:title
				},
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if (data.status == 'success') {
						appObject.find('.app-name').html(newTitle);
						appObject.attr('app-path',data.data);
						appObject.attr('title',newTitle);
					} else {
						layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
					}
				},
				error:function(xhr,textStatus){
					console.log('错误')
				}
			});
		}
	});
}

/**
 * 路径删除
 * @author tangtanglove
 */
function deletePath(appObject) {
	path = appObject.attr('app-path');
	// ajax请求后台数据
	context.ajax({
		url:config.url.finderDeletePath,
		type:'GET', // GET
		async:false, // 是否异步
		data:{
			path:path
		},
		dataType:'json',
		success:function(data,textStatus,jqXHR){
			if (data.status == 'success') {
				appObject.remove();
				$('.trash').find('.img-rounded').attr('src','./images/apps/FullTrashIcon.png');
			} else {
				layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
			}
		},
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});
}

/**
 * 路径粘贴
 * @author tangtanglove
 */
function pastePath(selecter,appObject,eventClass) {
	path = appObject.attr('current-path');
	getPastePath = $.cookie('pastePath');
	if(getPastePath) {
		arr = new Array(); //定义一数组
		arr = getPastePath.split(":"); //字符分割 
		if(arr[0] == 1) {
			// 剪切
			context.ajax({
				url:config.url.finderMovePath,
				type:'GET', // GET
				async:false, // 是否异步
				data:{
					oldPath:arr[1],
					newPath:path
				},
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if (data.status == 'success') {
						// 移除元素
						$("div[app-path='"+arr[1]+"']").remove();
						//创建新元素
						html = "<div class='app-box middle "+eventClass+" "+data.data.context+"' title='"+data.data.title+"' app-path='"+data.data.path+"' app-name='"+data.data.name+"' app-width="+data.data.width+" app-height="+data.data.height+">\
						<span class='app-icon'><img class='img-rounded' src='"+data.data.icon+"' alt='"+data.data.title+"' app-path='"+data.data.path+"' app-width="+data.data.width+" app-height="+data.data.height+"></span>\
						<span class='app-name'>"+data.data.title+"</span>\
						<div class='clear'></div>\
						</div>";
						$(selecter).append(html);
						// 重排图标
						appsort.init();
						$.cookie('pastePath',null);
					} else {
						layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
					}
				},
				error:function(xhr,textStatus){
					console.log('错误')
				}
			});
		} else if(arr[0] == 2) {
			// 复制
			context.ajax({
				url:config.url.finderCopyPath,
				type:'GET', // GET
				async:false, // 是否异步
				data:{
					oldPath:arr[1],
					newPath:path
				},
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if (data.status == 'success') {
						//创建新元素
						html = "<div class='app-box middle "+eventClass+" "+data.data.context+"' title='"+data.data.title+"' app-path='"+data.data.path+"' app-name='"+data.data.name+"' app-width="+data.data.width+" app-height="+data.data.height+">\
						<span class='app-icon'><img class='img-rounded' src='"+data.data.icon+"' alt='"+data.data.title+"' app-path='"+data.data.path+"' app-width="+data.data.width+" app-height="+data.data.height+"></span>\
						<span class='app-name'>"+data.data.title+"</span>\
						<div class='clear'></div>\
						</div>";
						$(selecter).append(html);
						// 重排图标
						appsort.init();
						$.cookie('pastePath',null);
					} else {
						layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
					}
				},
				error:function(xhr,textStatus){
					console.log('错误')
				}
			});
		}
	} else {
		layer.msg('剪切板为空！',{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
	}

}


/**
 * 下载文件
 * @author tangtanglove
 */
function download(appObject) {
	path = appObject.attr('app-path');
	window.open(config.url.finderUploadFile+'?path='+path);
}

/**
 * 新建文本文件
 * @author tangtanglove
 */
function newFile(selecter,path,fileName,fileExt,eventClass) {
	context.ajax({
		url:config.url.finderMakeFile,
		type:'GET', // GET
		async:false, // 是否异步
		data:{
			path:path,
			fileName:fileName,
			fileExt:fileExt
		},
		dataType:'json',
		success:function(data,textStatus,jqXHR){
			if (data.status == 'success') {
				html = "<div class='app-box middle "+eventClass+" "+data.data.context+"' title='"+data.data.title+"' app-path='"+data.data.path+"' app-name='"+data.data.name+"' app-width="+data.data.width+" app-height="+data.data.height+">\
				<span class='app-icon'><img class='img-rounded' src='"+data.data.icon+"' alt='"+data.data.title+"' app-path='"+data.data.path+"' app-width="+data.data.width+" app-height="+data.data.height+"></span>\
				<span class='app-name'>"+data.data.title+"</span>\
				<div class='clear'></div>\
				</div>";
				$(selecter).append(html);
				// 重排图标
				appsort.init();
			} else {
				layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
			}
		},
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});
}

/**
 * 清空回收站
 * @author tangtanglove
 */
function emptyTrash(appObject) {
	// 获取路径
	path = appObject.attr('app-path');
	context.ajax({
		url:config.url.finderEmptyTrash,
		type:'GET', // GET
		async:false, // 是否异步
		data:{
			path:path,
		},
		dataType:'json',
		success:function(data,textStatus,jqXHR){
			if (data.status == 'success') {
				$('.trash').find('.img-rounded').attr('src','./images/apps/TrashIcon.png');
			} else {
				layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
			}
		},
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});
}

/**
 * 上传
 * @author tangtanglove
 */
function upload(selecter,appObject,eventClass) {
	path = appObject.attr('current-path');
	html = "<div id='uploadapp' style='padding:10px;'><el-upload\
  action='"+config.url.finderUploadFile+"'\
  drag\
  :multiple='true'\
  :on-preview='handlePreview'\
  :on-remove='handleRemove'\
  :on-success='handleSuccess'\
  :on-error='handleError'\
  :file-list='fileList'\
>\
  <i class='el-icon-upload'></i>\
  <div class='el-dragger__text'>将文件拖到此处，或<em>点击上传</em></div>\
  <div class='el-upload__tip' slot='tip'>上传文件不能超过服务器上传限制</div>\
</el-upload></div>";

	//页面层
	layer.open({
		title:lang.upload,
		type: 1,
		shade: false,
		area: ['380px', '350px'], //宽高
		resize: false,
		content: html,
		zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});

	// 渲染模板
	new Vue({
		el: '#uploadapp',
		data : function() {
		return {
			fileList: []
		};
		},
		methods: {
			handleRemove : function (file, fileList) {
				console.log(file, fileList);
			},
			handlePreview : function (file) {
				console.log(file);
			},
			handleSuccess : function (file) {
				context.ajax({
					url:config.url.finderCallbackMovePath,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						newPath:path,
						oldPath:file.data.path,
						fileName:file.data.fileName
					},
					dataType:'json',
					success : function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							html = "<div class='app-box middle "+eventClass+" "+data.data.context+"' title='"+data.data.title+"' app-path='"+data.data.path+"' app-name='"+data.data.name+"' app-width="+data.data.width+" app-height="+data.data.height+">\
							<span class='app-icon'><img class='img-rounded' src='"+data.data.icon+"' alt='"+data.data.title+"' app-path='"+data.data.path+"' app-width="+data.data.width+" app-height="+data.data.height+"></span>\
							<span class='app-name'>"+data.data.title+"</span>\
							<div class='clear'></div>\
							</div>";
							if(eventClass) {
								// 桌面路径时直接添加
								$(selecter).append(html);
							} else {
								// 其他路径时添加到下一层对话框
								appObject.find('.app-list').append(html);
							}
							// 重排图标
							appsort.init();
						} else {
							layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
						}
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
				console.log(file);
			},
			handleError : function (file) {
				console.log(file);
			}
		}
	});

}