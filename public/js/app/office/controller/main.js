function office(appObject) {
	path = appObject.attr('app-path');
	filePath = "http://dcsapi.com/?k=66668775&url=http://"+document.domain+"/"+config.url.openFileWithBrowser+"?path="+path;
	// 打开对话框
	layer.open({
		type: 2 //此处以iframe举例
		,title: appObject.attr('title')
		,area: [appObject.attr('app-width')+'px', appObject.attr('app-height')+'px']
		,shade: 0
		,minButton: true
		,maxButton: true
		,taskbar:true
		,moveOut: true
		,content: filePath
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});
}