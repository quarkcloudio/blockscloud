function finder(appObject) {

	finderCount = $('.finder-wrapper').length;
	// 计算窗口偏移量
	leftOffsets = String(50+(finderCount)*3)+'%';
	topOffsets = String(50+(finderCount)*10)+'%';
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

	// dialog.position(Math.random(),Math.random());
	// 根据jquery选择器获取当前打开的文件路径
	path = appObject.attr('app-path');
	if(path) {
		$('.dialog-focus .finder-wrapper .pathHistory').val(path);
		$('.dialog-focus .finder-wrapper .content').attr(path);
	} else {
		$('.dialog-focus .finder-wrapper .content').attr('current-path','public/user/'+userInfo.name+'/home/');
	}

	finderOpenApp(name,path,appObject);

	// ajax请求sidebar数据
	$.ajax({
		url:config.url.sidebar,
		type:'GET', // GET
		async:false, // 是否异步
		dataType:'json',
		success:function(data,textStatus,jqXHR){
			// 变量赋值
			favoritesTitle 	= data.data.favoritesTitle;
			favorites 		= data.data.favorites;
			devicesTitle	= data.data.devicesTitle;
			devices			= data.data.devices;
			delimiter 		= "<div style='height:10px;clear:both'></div>";

			favoritesHeaderHtml = "<ul><li class='title'>"+favoritesTitle+"</li>";
			favoritesBodyHtml	= '';
			$.each(favorites,function(key, value) {
				favoritesBodyHtml = favoritesBodyHtml + 
				"<li>\
					<a onclick=\"finderOpenApp('"+value.name+"','"+value.path+"')\" class='"+value.active+"' href='#'>\
						<span class='"+value.icon+"'></span>\
						<span class='name'>"+value.title+"</span>\
					</a>\
				</li>";
			});
            favoritesFooterHtml = "</ul>";
			favoritesHtml = favoritesHeaderHtml+favoritesBodyHtml+favoritesFooterHtml;

			devicesHeaderHtml = "<ul><li class='title'>"+devicesTitle+"</li>";
			devicesBodyHtml	= '';
			$.each(devices,function(key, value) {
				devicesBodyHtml = devicesBodyHtml + 
				"<li>\
					<a onclick=\"finderOpenApp('"+value.name+"','"+value.path+"')\" class='"+value.active+"' href='#'>\
						<span class='"+value.icon+"'></span>\
						<span class='name'>"+value.title+"</span>\
					</a>\
				</li>";
			});
            devicesFooterHtml = "</ul>";
			devicesHtml = devicesHeaderHtml+devicesBodyHtml+devicesFooterHtml;

			$(".dialog-focus .finder-wrapper .sidebar").html(favoritesHtml+delimiter+devicesHtml);

		},
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});
	// scroll
	$(".sidebar").niceScroll({cursorcolor:"#bebebe"});
}

/**
 * 打开app，finder专用
 * @author tangtanglove
 */
function finderOpenApp(name,path,appObject) {

	if(name != 'finder') {
		// 如果不是调用资源管理器，则跳出执行其他程序
		exeApp(appObject);
	} else {
		// 保存历史记录
		pathHistory = $('.dialog-focus .finder-wrapper .pathHistory').val();
		pathArray = new Array(); //定义一数组
		pathArray = pathHistory.split("|"); //字符分割 
		key = $.inArray(path, pathArray);

		if(key ==-1) {
			if(path) {
				lastPath = pathArray[pathArray.length-1];
				if(lastPath != 'root') {
					if(path.indexOf(lastPath) > -1) {
						pathHistory = pathHistory+'|'+path;
						$('.dialog-focus .finder-wrapper .pathHistory').val(pathHistory);
						$('.dialog-focus .finder-wrapper .currentPath').val(path);
						$('.dialog-focus .finder-wrapper .content').attr('current-path',path);
					} else {
						// 将历史路径的最后一个路径替换新的路径
						pathHistory = pathHistory.replace(lastPath,path);
						// pathHistory = pathHistory+'|'+path;
						$('.dialog-focus .finder-wrapper .pathHistory').val(pathHistory);
						$('.dialog-focus .finder-wrapper .currentPath').val(path);
						$('.dialog-focus .finder-wrapper .content').attr('current-path',path);
					}
				} else {
					pathHistory = pathHistory+'|'+path;
					$('.dialog-focus .finder-wrapper .pathHistory').val(pathHistory);
					$('.dialog-focus .finder-wrapper .currentPath').val(path);
					$('.dialog-focus .finder-wrapper .content').attr('current-path',path);
				}
			}
		} else {
			$('.dialog-focus .finder-wrapper .currentPath').val(path);
			$('.dialog-focus .finder-wrapper .content').attr('current-path',path);
		}


		// ajax请求后台数据
		$.ajax({
			url:config.url.openPath,
			type:'GET', // GET
			async:false, // 是否异步
			data:{
				path:path
			},
			dataType:'json',
			success:function(data,textStatus,jqXHR){
				if (data.status == 'success') {
					html = '';
					if(data.data) {
						$.each(data.data,function(key, value) {
							if(typeof(value.path)=="undefined") {
								value.path = '';
							}
							html = html + "<div class='app-box middle "+value.context+"' title='"+value.title+"' app-name='"+value.name+"' app-path='"+value.path+"' app-width="+value.width+" app-height="+value.height+">\
							<span class='app-icon'><img class='img-rounded' src='"+value.icon+"' alt='"+value.title+"' app-path='"+value.path+"' app-width="+value.width+" app-height="+value.height+"></span>\
							<span class='app-name'>"+value.title+"</span>\
							<div class='clear'></div>\
							</div>";
						});
					}
					$('.dialog-focus .finder-wrapper .app-list').html(html);

				} else {
					layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
				}
			},
			error:function(xhr,textStatus){
				console.log('错误')
			}
		});
	}

}

/**
 * 下一级
 * @author tangtanglove
 */
function next () {
	pathHistory = $('.dialog-focus .finder-wrapper .pathHistory').val();
	currentPath = $('.dialog-focus .finder-wrapper .currentPath').val();
	pathArray = new Array(); //定义一数组
	pathArray = pathHistory.split("|"); //字符分割 
	key = $.inArray(currentPath, pathArray);
	path = pathArray[key+1];
	if(path) {
		finderOpenApp('finder',path);
		$('.dialog-focus .finder-wrapper .currentPath').val(path);
		$('.dialog-focus .finder-wrapper .content').attr('current-path',path);
	}
}

/**
 * 上一级
 * @author tangtanglove
 */
function prev () {
	pathHistory = $('.dialog-focus .finder-wrapper .pathHistory').val();
	currentPath = $('.dialog-focus .finder-wrapper .currentPath').val();
	pathArray = new Array(); //定义一数组
	pathArray = pathHistory.split("|"); //字符分割 
	key = $.inArray(currentPath, pathArray);
	path = pathArray[key-1];
	if(path) {
		if(path=='root') {
			finderOpenApp('finder','');
		} else {
			finderOpenApp('finder',path);
		}
		$('.dialog-focus .finder-wrapper .currentPath').val(path);
		$('.dialog-focus .finder-wrapper .content').attr('current-path',path);
	}
}
