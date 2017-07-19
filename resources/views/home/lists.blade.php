<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $postCate->name }} - {{ $website['web_site_title'] }}</title>
        <meta name="description" content="{{ $website['web_site_description'] }}">
        <meta name="keywords" content="{{ $website['web_site_keyword'] }}">

        <link rel="shortcut icon" href="/favicon.ico"/>
        <!-- Styles -->
        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/home.css" rel="stylesheet">
    </head>
    <body>
        @include('home/header')
        <div style="height:80px;"></div>
        <div class="container">
        @if(isset($articles))
            @foreach ($articles as $key=>$article)
                @if ($key == 0)
                <div class="row">
                @endif
                @if ($key == 4)
                <div class="row">
                @endif
                    <div class="col-md-3">
                        <div class="post-box">
                            <div class="post-img">
                                <a href="{{ route('home/article/detail',['id'=>$article->id,'category'=>$postCate->id]) }}"><img src="@if(!empty($article->cover_path)){{ route('home/base/getFile',['path'=>$article->cover_path]) }}@else /images/icons/default.jpg @endif" width="100%" height="150" /></a>
                            </div>
                            <div class="post-title">
                                <a href="{{ route('home/article/detail',['id'=>$article->id,'category'=>$postCate->id]) }}">{{ $article->title }}</a>
                            </div>
                        </div>
                    </div>
                @if ($key == 3)
                </div>
                @endif
                @if ($key == 7)
                </div>
                @endif
                
            @endforeach
            <nav aria-label="...">
            <ul class="pagination">
            {{ $articles->appends(['id'=>$postCate->id])->links() }}
            </ul>
            </nav>
        @endif
        </div>
    <!-- Scripts -->
    <script src="/js/vendor/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/vendor/bootstrap/bootstrap.min.js"></script>
    </body>
</html>
