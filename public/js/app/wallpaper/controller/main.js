function wallpaper(appObject) {

	// 打开对话框
	layer.open({
		type: 1 //此处以iframe举例
		,title: appObject.attr('title')
		,area: [appObject.attr('app-width')+'px', appObject.attr('app-height')+'px']
		,shade: 0
		,minButton: true
		,maxButton: true
		,taskbar:true
		,moveOut: true
		,content: '<div id="app-content"></div>'
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});

	// 渲染模板
	new Vue({
		el: '#app-content',
		template:render('index.html'),
		data:{
			items: []
		},
		methods: {
			setWallpaper: function (wallpaperID,coverPath) {
				$('body').css('background-image',"url('"+coverPath+"')");
				$.ajax({
					url:config.url.wallpaperSetting,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						id:wallpaperID
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
		},
		mounted: function () {
			// ajax请求后台数据
			var vueObject = this;
			$.ajax({
				url:config.url.wallpaperLists,
				type:'GET', // GET
				async:false, // 是否异步
				data:{
					path:path
				},
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if (data.status == 'success') {
						vueObject.items = data.data;
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