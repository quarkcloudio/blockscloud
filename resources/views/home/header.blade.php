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
            <a class="navbar-brand" href="#">云市场</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @foreach ($navigations as $key=>$navigation)
                <li class="{{ $helper::active($navigation->url)}}"><a href="{{ $navigation->url }}">{{ $navigation->title }}</a></li>
                @endforeach
                <li @if ($postCate->id == 1)class="active"@endif><a href="{{ route('home/article/lists',['id'=>1]) }}">文章 <span class="sr-only">(current)</span></a></li>
                <li @if ($postCate->id == 2)class="active"@endif><a href="{{ route('home/article/lists',['id'=>2]) }}">视频</a></li>
                <li @if ($postCate->id == 3)class="active"@endif><a href="{{ route('home/article/lists',['id'=>3]) }}">图片</a></li>
                <li @if ($postCate->id == 4)class="active"@endif><a href="{{ route('home/article/lists',['id'=>4]) }}">种子</a></li>
                <li @if ($postCate->id == 5)class="active"@endif><a href="{{ route('home/article/lists',['id'=>5]) }}">磁链</a></li>
                <li @if ($postCate->id == 6)class="active"@endif><a href="{{ route('home/article/lists',['id'=>6]) }}">云盘</a></li>
                <li @if ($postCate->id == 7)class="active"@endif><a href="{{ route('home/article/lists',['id'=>7]) }}">文档</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <div class="form-group">
                <input type="text" class="form-control" value="" placeholder="请输入要搜索的内容">
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
        </nav>