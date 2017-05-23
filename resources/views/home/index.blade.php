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
        @include('home/header')
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
