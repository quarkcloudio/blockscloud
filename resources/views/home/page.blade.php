<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page->title }} - {{ $website['web_site_title'] }}</title>

        <link rel="shortcut icon" href="/favicon.ico"/>
        <!-- Styles -->
        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/home.css" rel="stylesheet">
    </head>
    <body>
        @include('home/header')
        <div style="height:80px;"></div>

    <div class="container">
      <div class="page-header">
        <h1>{{ $page->title }}</h1>
      </div>
      <p class="lead">{!! $page->content !!}</p>
        <!--高速版-->
        <div id="SOHUCS" sid="{{ $page->id }}"></div>
        <script charset="utf-8" type="text/javascript" src="http://changyan.sohu.com/upload/changyan.js" ></script>
        <script type="text/javascript">
        window.changyan.api.config({
        appid: 'cyt1wGQrK',
        conf: 'prod_7dfd9c381191f8e5bd9a20ff1e49abc9'
        });
        </script>
    </div> <!-- /container -->
    <!-- Scripts -->
    <script src="/js/vendor/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/vendor/bootstrap/bootstrap.min.js"></script>
    </body>
</html>
