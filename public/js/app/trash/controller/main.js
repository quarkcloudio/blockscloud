function trash(appObject) {
	// 打开对话框
	layer.open({
		type: 1 
		,title: appObject.attr('title')
		,area: [appObject.attr('app-width')+'px', appObject.attr('app-height')+'px']
		,shade: 0
		,minButton: false
		,maxButton: false
		,taskbar:true
		,moveOut: true
		,content: render('index.html')
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});

	path = 'public/user/'+userInfo.name+'/recycle/';

	$('.dialog-focus .trash-wrapper .content').attr('current-path',path);

	trashOpenApp(name,path);

	// ajax请求sidebar数据
	$.ajax({
		url:config.url.finderSidebar,
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
					<a onclick=\"trashOpenApp('"+value.name+"','"+value.path+"')\" class='' href='#'>\
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
					<a onclick=\"trashOpenApp('"+value.name+"','"+value.path+"')\" class='' href='#'>\
						<span class='"+value.icon+"'></span>\
						<span class='name'>"+value.title+"</span>\
					</a>\
				</li>";
			});
            devicesFooterHtml = "</ul>";
			devicesHtml = devicesHeaderHtml+devicesBodyHtml+devicesFooterHtml;
			
			otherHeaderHtml = "<ul><li class='title'>其它</li>";
			otherBodyHtml	=
				"<li>\
					<a onclick=\"trashOpenApp('trash','public/user/"+userInfo.name+"/recycle/')\" class='on' href='#'>\
						<span class='trash-icon'></span>\
						<span class='name'>回收站</span>\
					</a>\
				</li>";
            otherFooterHtml = "</ul>";
			otherHtml = otherHeaderHtml+otherBodyHtml+otherFooterHtml;

			$(".dialog-focus .trash-wrapper .sidebar").html(favoritesHtml+delimiter+devicesHtml+delimiter+otherHtml);

		},
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});

	// scroll
	$(".sidebar").niceScroll({cursorcolor:"#bebebe"});
}

/**
 * 打开app，trash专用
 * @author tangtanglove
 */
function trashOpenApp(name,path) {

		// ajax请求后台数据
		$.ajax({
			url:config.url.finderOpenPath,
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
							html = html + "<div class='app-box middle trash-file' title='"+value.title+"' app-name='"+value.name+"' app-path='"+value.path+"' app-width="+value.width+" app-height="+value.height+">\
							<span class='app-icon'><img class='img-rounded' src='"+value.icon+"' alt='"+value.title+"' app-path='"+value.path+"' app-width="+value.width+" app-height="+value.height+"></span>\
							<span class='app-name'>"+value.title+"</span>\
							<div class='clear'></div>\
							</div>";
						});
					}
					$('.dialog-focus .trash-wrapper .app-list').html(html);

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
 * 下一级
 * @author tangtanglove
 */
function next () {

}

/**
 * 上一级
 * @author tangtanglove
 */
function prev () {

}