<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $website['web_site_title'] }}</title>
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
            <a class="navbar-brand" href="{{ route('home/index/index') }}">云市场</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ route('home/index/index') }}">文章 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">视频</a></li>
                <li><a href="#">图片</a></li>
                <li><a href="#">种子</a></li>
                <li><a href="#">磁链</a></li>
                <li><a href="#">云盘</a></li>
                <li><a href="#">文档</a></li>
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
            <div class="row">
                <div class="col-md-3">
                    <div class="post-box">
                        <div class="post-img">
                            <a href="#"><img src="/images/1.png" width="100%" /></a>
                        </div>
                        <div class="post-title">
                            <a href="#">我的文章</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="post-box">
                        <div class="post-img">
                            <a href="#"><img src="/images/1.png" width="100%" /></a>
                        </div>
                        <div class="post-title">
                            <a href="#">我的文章</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="post-box">
                        <div class="post-img">
                            <a href="#"><img src="/images/1.png" width="100%" /></a>
                        </div>
                        <div class="post-title">
                            <a href="#">我的文章</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="post-box">
                        <div class="post-img">
                            <a href="#"><img src="/images/1.png" width="100%" /></a>
                        </div>
                        <div class="post-title">
                            <a href="#">我的文章</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="post-box">
                        <div class="post-img">
                            <a href="#"><img src="/images/1.png" width="100%" /></a>
                        </div>
                        <div class="post-title">
                            <a href="#">我的文章</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="post-box">
                        <div class="post-img">
                            <a href="#"><img src="/images/1.png" width="100%" /></a>
                        </div>
                        <div class="post-title">
                            <a href="#">我的文章</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="post-box">
                        <div class="post-img">
                            <a href="#"><img src="/images/1.png" width="100%" /></a>
                        </div>
                        <div class="post-title">
                            <a href="#">我的文章</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="post-box">
                        <div class="post-img">
                            <a href="#"><img src="/images/1.png" width="100%" /></a>
                        </div>
                        <div class="post-title">
                            <a href="#">我的文章</a>
                        </div>
                    </div>
                </div>
            </div>
            <nav aria-label="...">
            <ul class="pagination">
                <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
            </ul>
            </nav>
        </div>
    <!-- Scripts -->
    <script src="/js/vendor/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/vendor/bootstrap/bootstrap.min.js"></script>
    </body>
</html>
