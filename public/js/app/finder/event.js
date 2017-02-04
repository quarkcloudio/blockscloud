// 系统会自动加载本文件
function finderEvent(appObject) {
    $(document).on("dblclick",'.dialog-focus .finder-wrapper .app-box',function(event){
        finderOpenApp($(this).attr('app-name'),$(this).attr('app-path'),$(this));
    });
	$(document).on("mouseover",'.dialog-focus .finder-wrapper .app-box',function(event){
		$(this).addClass('hover');
	})
	$(document).on("mouseout",'.dialog-focus .finder-wrapper .app-box',function(event){
		$(this).removeClass('hover');
	});
	$(document).on("mousedown",'.dialog-focus .finder-wrapper .app-box',function(event){
		$(".dialog-focus .finder-wrapper .app-box").removeClass('active');
		$(this).addClass('active');
		return false;
	});
	$(document).on("mousedown",'.dialog-focus .finder-wrapper .content',function(event){
		$(".dialog-focus .finder-wrapper .app-box").removeClass('active');
	})
	$(document).on("mousedown",'.dialog-focus .finder-wrapper .sidebar ul li a',function(event){
		$(".dialog-focus .finder-wrapper .sidebar ul li a").removeClass('on');
		$(this).addClass('on');
	})
}