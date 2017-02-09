function audio(appObject) {
	// 打开对话框
	layer.open({
		type: 1 //此处以iframe举例
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

	path = appObject.attr('app-path');

	new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
	}, [
		{
			title:appObject.attr('title'),
			mp3:config.url.openFileWithBrowser+"?path="+path
		}
	], {
		swfPath: "js/vendor/jPlayer/dist/jplayer",
		supplied: "mp3",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: true,
		smoothPlayBar: true,
		keyEnabled: true
	}).option("autoPlay", true);
}