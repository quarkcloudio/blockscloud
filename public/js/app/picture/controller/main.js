function picture(appObject) {
	path = appObject.attr('app-path');
	json = {
			"title": appObject.attr('title'), //相册标题
			"id": 1, //相册id
			"start": 0, //初始显示的图片序号，默认0
			"data": [   //相册包含的图片，数组格式
				{
				"alt": appObject.attr('title'),
				"pid": 1, //图片id
				"src": config.url.baseOpenFileWithBrowser+"?path="+path, //原图地址
				"thumb": config.url.baseOpenFileWithBrowser+"?path="+path //缩略图地址
				}
			]
			}

	layer.photos({
		photos: json
		,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
		,shade: [0.3,'#000']
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});
}
