<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $postCatesInfo->name }} - {{ $website['web_site_title'] }}</title>
        <meta name="description" content="{{ $website['web_site_description'] }}">
        <meta name="keywords" content="{{ $website['web_site_keyword'] }}">
        <!-- Styles -->
        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/home.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">云市场</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li @if ($postCatesInfo->id == 1)class="active"@endif><a href="{{ route('home/article/lists',['id'=>1]) }}">文章 <span class="sr-only">(current)</span></a></li>
                <li @if ($postCatesInfo->id == 2)class="active"@endif><a href="{{ route('home/article/lists',['id'=>2]) }}">视频</a></li>
                <li @if ($postCatesInfo->id == 3)class="active"@endif><a href="{{ route('home/article/lists',['id'=>3]) }}">图片</a></li>
                <li @if ($postCatesInfo->id == 4)class="active"@endif><a href="{{ route('home/article/lists',['id'=>4]) }}">种子</a></li>
                <li @if ($postCatesInfo->id == 5)class="active"@endif><a href="{{ route('home/article/lists',['id'=>5]) }}">磁链</a></li>
                <li @if ($postCatesInfo->id == 6)class="active"@endif><a href="{{ route('home/article/lists',['id'=>6]) }}">云盘</a></li>
                <li @if ($postCatesInfo->id == 7)class="active"@endif><a href="{{ route('home/article/lists',['id'=>7]) }}">文档</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <div class="form-group">
                <input type="text" class="form-control" placeholder="请输入要搜索的内容">
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
        </nav>
        <div style="height:80px;"></div>
        <div class="container">
            @foreach ($lists as $key=>$list)
                @if ($key == 0)
                <div class="row">
                @endif
                @if ($key == 4)
                <div class="row">
                @endif
                    <div class="col-md-3">
                        <div class="post-box">
                            <div class="post-img">
                                <a href="{{ route('home/article/detail',['id'=>$list->id,'category'=>$postCatesInfo->id]) }}"><img src="{{ route('home/base/getFile',['path'=>$list->cover_path]) }}" width="100%" height="150" /></a>
                            </div>
                            <div class="post-title">
                                <a href="{{ route('home/article/detail',['id'=>$list->id,'category'=>$postCatesInfo->id]) }}">{{ $list->title }}</a>
                            </div>
                        </div>
                    </div>
                @if ($key == 3)
                <div>
                @endif
                @if ($key == 5)
                <div>
                @endif
            @endforeach
            <nav aria-label="...">
            <ul class="pagination">
            {{ $lists->links() }}
            </ul>
            </nav>
        </div>

    <!-- Scripts -->
    <script src="/js/vendor/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/vendor/bootstrap/bootstrap.min.js"></script>
    </body>
</html>
