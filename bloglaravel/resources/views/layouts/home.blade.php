<!doctype html>
<html>
<head>
<meta charset="utf-8">
@yield('info')
<link href="{{asset('resources/views/home/css/base.css') }}" rel="stylesheet">
<link href="{{asset('resources/views/home/css/index.css') }}" rel="stylesheet">
<link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
<link href="{{asset('resources/views/home/css/style.css') }}" rel="stylesheet">


<!--[if lt IE 9]>
<script src="js/modernizr.js"></script>
<![endif]-->
</head>
<body>
<header>
  <div id="logo"><a href="{{url('/')}}"></a></div>
  <nav class="topnav" id="topnav">
  @foreach($db as $v)
    <a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>
  @endforeach 
  </nav>
</header>

@section('content')

<div class="news">
    <h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
    @foreach($new as $v)
      <li><a href="{{url('article/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
    @endforeach  
    </ul>
    <h3 class="ph">
      <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
    @foreach($click as $v)
      <li><a href="{{url('article/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
    @endforeach  
    </ul>

@show
<footer>
  <p>Design by 后盾网 <a href="http://www.miitbeian.gov.cn/" target="_blank">http://www.houdunwang.com</a> <a href="/">网站统计</a></p>
</footer>
<script src="{{asset('resources/views/home/js/silder.js')}}"></script>

</body>
</html>
