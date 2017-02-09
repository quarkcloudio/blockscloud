function help(appObject) {

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
	var appContent = new Vue({
		el: '#app-content',
		template:render('index.html'),
		data: {
			about : ''
		},
		created: function () {// 创建时调用
			// 动态更新数据
			this.about = '帮助';
		}
	});

}