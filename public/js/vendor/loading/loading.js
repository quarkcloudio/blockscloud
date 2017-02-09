//获取浏览器页面可见高度和宽度
var _PageHeight = document.documentElement.clientHeight,
    _PageWidth = document.documentElement.clientWidth;
//计算loading框距离顶部和左部的距离（loading框的宽度为215px，高度为61px）
var _LoadingTop = _PageHeight > 64 ? (_PageHeight - 64) / 2 : 0,
    _LoadingLeft = _PageWidth > 64 ? (_PageWidth - 64) / 2 : 0;
//在页面未加载完毕之前显示的loading Html自定义内容
var _LoadingHtml = '<div id="loadingDiv" style="position:absolute;left:0;width:100%;height:' + _PageHeight + 'px;top:0;background-color:#000; opacity:0.8; filter:alpha(opacity=80);z-index:10000;"><div id="loadingContent" style="position: absolute;left: ' + _LoadingLeft + 'px; top:' + _LoadingTop + 'px;"><img src="./js/vendor/loading/loading.gif" /></div></div>';
//呈现loading效果
document.write(_LoadingHtml);

//监听加载状态改变
document.onreadystatechange = completeLoading;

//加载状态为complete时移除loading效果
function completeLoading() {
    if (document.readyState == "complete") {
        $("#loadingDiv").fadeOut("slow");
    }
}