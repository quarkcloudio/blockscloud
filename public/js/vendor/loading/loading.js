//获取浏览器页面可见高度和宽度
var _PageHeight = document.documentElement.clientHeight,
    _PageWidth = document.documentElement.clientWidth;
//计算loading框距离顶部和左部的距离（loading框的宽度为215px，高度为61px）
var _LoadingTop = _PageHeight > 61 ? (_PageHeight - 61) / 2 : 0,
    _LoadingLeft = _PageWidth > 215 ? (_PageWidth - 215) / 2 : 0;
//在页面未加载完毕之前显示的loading Html自定义内容
var _LoadingHtml = '<div id="loadingDiv" style="position:absolute;left:0;width:100%;height:' + _PageHeight + 'px;top:0;background-color:#000; opacity:0.3; filter:alpha(opacity=30);z-index:10000;"></div><div id="loadingContent" style="position: absolute; z-index:10001; cursor1: wait; left: ' + _LoadingLeft + 'px; top:' + _LoadingTop + 'px; width: auto; height: 57px; line-height: 57px; padding-left: 50px; padding-right: 10px; background: #fff url(./js/vendor/loading/loading.gif) no-repeat scroll 10px 10px; border: 1px solid #95B8E7; color: #696969; font-family:\'Microsoft YaHei\';">系统正在加载中...</div>';
//呈现loading效果
document.write(_LoadingHtml);

//监听加载状态改变
document.onreadystatechange = completeLoading;

//加载状态为complete时移除loading效果
function completeLoading() {
    if (document.readyState == "complete") {
        var loadingMask = document.getElementById('loadingDiv');
        var loadingContent = document.getElementById('loadingContent');
        loadingMask.parentNode.removeChild(loadingMask);
        loadingContent.parentNode.removeChild(loadingContent);
    }
}