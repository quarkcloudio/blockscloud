// 初始化全局变量
var desktopVueModel = ''; // 定义desktopVueModel全局对象
var userInfo = []; // 定义用户信息全局对象
var appScriptPath = '';
// 定义seajs模块
define("vendor/blockscloud/core", function(require) {
		showTime();
		// 登录用户信息初始化
		userInfo = userInfoInit();
		// 注册事件
		registerEvent();

});

/**
 * 任务栏时间显示
 * @author tangtanglove
 */
function showTime(){ 
	var show_day	=	new Array('周一','周二','周三','周四','周五','周六','周日'); 
	var time		=	new Date(); 
	var year		=	time.getYear(); 
	var month		=	time.getMonth(); 
	var date		=	time.getDate(); 
	var day			=	time.getDay(); 
	var hour		=	time.getHours(); 
	var minutes		=	time.getMinutes(); 

	month<10?month='0'+month:month; 
	month=month+1; 
	hour<10?hour='0'+hour:hour; 
	minutes<10?minutes='0'+minutes:minutes; 

	if(hour<8||hour>18){//晚上
		var TA = '晚上';
	} else if (hour>=8&&hour<12) {//上午
		var TA = '上午';
	} else {//下午
		var TA = '下午';
	} 

	if(day==0) {
		var now_time='周日'+TA+hour+':'+minutes;
	} else {
		var now_time=show_day[day-1]+TA+hour+':'+minutes; 
	}

	document.getElementById('currentTime').innerHTML=now_time; 
	setTimeout("showTime();",1000); 
}

/**
 * 登录用户信息初始化
 * @author tangtanglove
 */
function userInfoInit() {
	var self;
	$.ajax({
		url:config.url.userInfo,
		type:'GET', // GET
		async:false, // 是否异步
		dataType:'json',
		success:function(data,textStatus,jqXHR){
			self = data;
		},
		error:function(xhr,textStatus){
			location.href = './login.html';
		}
	});
	return self;
}

/**
 * 注册事件
 * @author tangtanglove
 */
function registerEvent() {
	// 双击打开对应程序
	$(document).on("dblclick",'.appdblclick',function(event){
		exeApp($(this));
	})
	// 单击打开对应程序
	$(document).on("click",'.appclick',function(event){
		exeApp($(this));
	})
}

/**
 * 执行对应的桌面程序
 * @author tangtanglove
 */
function exeApp(appObject) {
	// 加载动态调用的js
	name = appObject.attr('app-name');
	// app路径赋值
	appScriptPath = "./js/app/"+name;

	// 当已经加载过js程序后就不再加载了，用cookie进行标记是否已经加载过
	app_list = $.cookie('app_list');
	if (app_list) {
		arr = new Array(); //定义一数组
		arr = app_list.split(","); //字符分割 
	} else {
		arr = [];
	}
	result = $.inArray(name, arr);
	if(result == -1) {
		// 加载程序入口文件
		seajs.use("app/"+name+"/controller/main",function() {
			$.cookie('app_list', app_list+','+name);
			exeCallback(eval(name),[appObject]);
		});
		// 加载事件文件
		seajs.use("app/"+name+"/event",function() {
			exeCallback(eval(name+'Event'),[appObject]);
		});
	} else {
		// 已经加载过了
		exeCallback(eval(name),[appObject]);
	}

}

/**
 * 定义执行回调函数方法
 * @author tangtanglove
 */
function exeCallback(fn,args)
{    
	fn.apply(this, args);
}

/**
 * 加载渲染模板
 * @author tangtanglove
 */
function render(templatePath) {
	var result;
	$.ajax({
		url: appScriptPath+"/view/"+templatePath,
		async: false,//改为同步方式
		type: "GET",
		success: function (html) {
			result = html;
		}
	});
	return result;
}