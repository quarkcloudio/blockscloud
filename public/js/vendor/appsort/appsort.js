var appsort = appsort || (function () {
	function init() {
		appHeight = $(".desktop .app-list .app-box").outerHeight(true);
		desktopHeight = $(window).height()-100;
		width = 10;
		height = 10;
		$(".desktop .app-list .app-box").each(function(){
			if(appHeight>desktopHeight){
				width = $(this).outerWidth(true) +width+10;
				// 重置总高度和图标相对高度
				appHeight = $(".desktop .app-list .app-box").outerHeight(true);
				height = 10;
			}
			appHeight = appHeight+$(this).outerHeight(true);
			$(this).css('left',width+'px');
			$(this).css('top',height+'px');
			height = $(this).outerHeight(true) +height+10;
		});
	}
	return {
		init: init,
	};
})();