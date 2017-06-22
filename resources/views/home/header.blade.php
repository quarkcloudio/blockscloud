        @inject('helper', 'App\Services\Helper')
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
            <a class="navbar-brand" href="{{ route('home/article/index') }}">积木云</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @foreach ($navigations as $key=>$navigation)
                <li class="{{ $helper::active($navigation->url)}}"><a href="{{ $navigation->url }}">{{ $navigation->title }}</a></li>
                @endforeach
            </ul>
            <form class="navbar-form navbar-right" action="{{ route('home/search/index') }}" method="get">
                <div class="form-group">
                <input type="hidden" name="module" class="form-control" value="article">
                <input type="text" name="query" class="form-control" value="@if(isset($query)){{ $query }}@endif" placeholder="请输入要搜索的内容">
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
        </nav>
        <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?35bab0a327a4624880126b5d99e0fe5a";
            var s = document.getElementsByTagName("script")[0]; 
            s.parentNode.insertBefore(hm, s);
        })();
        </script>