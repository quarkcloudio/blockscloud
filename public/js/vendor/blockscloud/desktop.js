define("vendor/blockscloud/desktop", ["appsort","nicescroll","cookie","element-ui","jplayer","playlist"], function(require) {

		// 清空cookie
		$.cookie('app_list',null);
		// 初始化桌面文件路径
		path = 'public/user/'+userInfo.name+'/home/desktop/';
		$('.desktop').attr('current-path',path);

		// 初始化壁纸
		getWallpaperInfo();

		// 查看是否锁屏
		lockStatus();

		// 获取文件文件夹列表
		openPath('.desktop .app-list',path)

		// 重新调整高度并重新排列桌面图标
		desktopResize();

		// 任务栏程序
		taskbar();

		// app鼠标移动上去的动态效果
		appHover();

});

/**
 * 获取文件文件夹列表
 * @author tangtanglove
 */
function openPath(selecter,path) {
	$.ajax({
		url:config.url.openPath,
		type:'GET', // GET
		async:false, // 是否异步
		data:{
			path:path
		},
		dataType:'json',
		success:function(data){
			if (data.status == 'success') {
				html = '';
				if(data.data) {
					$.each(data.data,function(key, value) {
						if(typeof(value.path)=="undefined") {
							value.path = '';
						}
						html = html + "<div class='app-box middle appdblclick "+value.context+"' title='"+value.title+"' app-path='"+value.path+"' app-name='"+value.name+"' app-width="+value.width+" app-height="+value.height+">\
						<span class='app-icon'><img class='img-rounded' src='"+value.icon+"' alt='"+value.title+"' app-path='"+value.path+"' app-width="+value.width+" app-height="+value.height+"></span>\
						<span class='app-name'>"+value.title+"</span>\
						<div class='clear'></div>\
						</div>";
					});
				}
				$(selecter).html(html);
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
 * 桌面尺寸变化时，调整高度并排列桌面图标
 * @author tangtanglove
 */
function desktopResize() {
	$(".desktop").height($(window).height()-50);
	//初始化高度  
	$(".desktop").height($(window).height()-50);  
	//当文档窗口发生改变时 触发  
	$(window).resize(function(){
		$(".desktop").height($(window).height()-50);
		appsort.init();
	});
}

/**
 * 任务栏程序隐藏、显示
 * @author tangtanglove
 */
function taskbar() {
	$(".taskbar-nav").on("click",'li', function() {
		id = $(this).attr('id');
		display = $('#layui-layer'+id).css('display');
		if(display != 'none'){
			$('#layui-layer'+id).hide();
		} else {
			$('#layui-layer'+id).show();
		}
	})
}

/**
 * 桌面app图标鼠标移动上去的动态效果
 * @author tangtanglove
 */
function appHover() {

	$('.app-list').on("mouseover mouseout",'.app-box',function(event){
		if(event.type == "mouseover") {
			$(this).addClass('hover');
		} else if(event.type == "mouseout"){
			$(this).removeClass('hover');
		}
	})

	$('.app-list').on("click",'.app-box',function(event){
		$(".app-box").removeClass('active');
		$(this).addClass('active');
	})

	$('.desktop').on("mousedown",function(){
		$(".app-box").removeClass('active');
	})

}

/**
 * 退出登录
 * @author tangtanglove
 */
function logout() {
	$.ajax({
		url:config.url.logout,
		type:'GET', // GET
		async:false, // 是否异步
		dataType:'json',
		success:function(data){
			if (data.status == 'success') {
				layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
				setTimeout(function () {
					location.href = data.url;
				}, 1000);
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
 * 锁屏状态
 * @author tangtanglove
 */
function lockStatus() {

	$.ajax({
		url:config.url.lockStatus,
		type:'GET',
		dataType:'json',
		success:function(data){
			if (data.data==1) {
				openLockDialog();
			}
		},
		error:function(xhr,textStatus){
		console.log('错误')
		}
	});

};

/**
 * 锁屏
 * @author tangtanglove
 */
function lockScreen() {

	$.ajax({
		url:config.url.lock,
		type:'GET', // GET
		dataType:'json',
		error:function(xhr,textStatus){
			console.log('错误')
		}
	});

	// 打开对话框
	openLockDialog();
}

/**
 * 打开锁屏对话框
 * @author tangtanglove
 */
function openLockDialog() {

	// 打开对话框
	lock = layer.open({
		type: 1
		,title: '输入密码解锁' //不显示标题栏
		,closeBtn: false
		,area: '300px;'
		,shade: 0.8
		,resize: false
		,btn: ['解锁']
		,btnAlign: 'r'
		,moveType: 1 //拖拽模式，0或者1
		,content: '<div style="padding: 30px; line-height: 30px; background-color: #393D49; font-weight: 300;"><input name="password" id="password" style="width:100%;font-size:18px;padding:0px 5px;" type="password" /></div>'
		,yes: function(){
			$.ajax({
				url:config.url.unlock,
				type:'POST',
				data:{
					password:$('#password').val(),
					username:userInfo.name
				},
				dataType:'json',
				success:function(data){
					if (data.status == 'success') {
						layer.close(lock);
					} else {
						layer.msg(data.msg, {icon: 2,zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}}, function(){
						//do something
						});
					}
				},
				error:function(xhr,textStatus){
				console.log('错误')
				}
			});
		}
		,zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}
	});
}

function getWallpaperInfo() {
	
	$.ajax({
		url:config.url.wallpaperInfo,
		type:'GET',
		dataType:'json',
		success:function(data){
			if (data.status == 'success') {
				$('body').css('background-image',"url('"+data.data+"')");
			} else {
				layer.msg(data.msg, {icon: 2,zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}}, function(){
				});
			}
		},
		error:function(xhr,textStatus){
		console.log('错误')
		}
	});
}