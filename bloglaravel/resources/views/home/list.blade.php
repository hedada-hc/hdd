@extends('layouts.home')
@section('info')
<title>{{$filed->cate_name}}-{{Config::get('web.WEB_TITLE')}}</title>
<meta name="keywords" content="个人博客模板,博客模板" />
<meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" />
@endsection
@section('content')
<article class="blogs">
<h1 class="t_nav"><span>{{$filed->cate_title}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$filed->cate_id)}}" class="n2">{{$filed->cate_name}}</a></h1>
<div class="newblog left">
  @foreach($data as $v)
   <h2>{{$v->art_title}}</h2>
   <p class="dateview"><span>发布时间：{{date('Y-m-d',$v->art_time)}}</span><span>作者：{{$v->art_editor}}</span><span>分类：[<a href="{{url('cate/'.$filed->cate_id)}}">{{$filed->cate_name}}</a>]</span></p>
    <figure><img src="{{url($v->art_thumb)}}"></figure>
    <ul class="nlist">
      <p>{{$v->art_description}}...</p>
      <a title="/" href="{{url('article/'.$v->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>
  @endforeach  
    <div class="blank"></div>
    <div class="page">
        {{$data->links()}}
    </div>
</div>
<aside class="right">
@if($son_cate)
   <div class="rnav">
      <ul>
      @foreach($son_cate as $k=> $v)
       <li class="rnav{{$k+1}}"><a href="{{url('cate/'.$v->cate_id)}}" target="_blank">{{$v->cate_name}}</a></li>
      @endforeach
     </ul>      
    </div>
@endif    
  <div class="news">
      @parent
  </div>
    
     <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
    <script type="text/javascript" id="bdshell_js"></script> 
    <script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script> 
    <!-- Baidu Button END -->   
</aside>
</article>
@endsection