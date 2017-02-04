// 系统会自动加载本文件
function trashEvent(appObject) {
	$(document).on("mouseover",'.dialog-focus .trash-wrapper .app-box',function(event){
		$(this).addClass('hover');
	})

	$(document).on("mouseout",'.dialog-focus .trash-wrapper .app-box',function(event){
		$(this).removeClass('hover');
	})

	$(document).on("mousedown",'.dialog-focus .trash-wrapper .app-box',function(event){
		$(".dialog-focus .trash-wrapper .app-box").removeClass('active');
		$(this).addClass('active');
	})

	$(".dialog-focus .trash-wrapper .content").mousedown(function(){
		$(".dialog-focus .trash-wrapper .app-box").removeClass('active');
	});
	$(".dialog-focus .trash-wrapper .sidebar ul li a").mousedown(function(){
		$(".dialog-focus .trash-wrapper .sidebar ul li a").removeClass('on');
		$(this).addClass('on');
	});
}