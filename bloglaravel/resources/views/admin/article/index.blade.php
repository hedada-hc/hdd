@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="#">文章列表</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        
        <form action="" method="get">

        {{csrf_field()}}
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select  name="id">
                            <option value="">全部</option>
                            @foreach($cate as $v)
                            <option value="{{$v->cate_id}}">{{$v->_cate_name}}</option>
                            @endforeach    
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
        <div class="result_title">
            <h3>文章列表</h3>
        </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>点击</th>
                        <th>编辑</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>

                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->art_id}}</td>
                        <td>
                            <a href="#">{{$v->art_title}}</a>
                        </td>
                        <td>{{$v->art_view}}</td>
                        <td>{{$v->art_editor}}</td>
                        <td>{{date('Y-m-d H:i:s',$v->art_time)}}</td>
                        <td>
                            <a href="{{url('admin/article/'.$v->art_id.'/edit')}}">修改</a>
                            <a onclick="delArticle({{$v->art_id}})" href="javascript:;">删除</a>
                        </td>
                    </tr>   
                    @endforeach    
                   
                    
                </table>






                <div class="page_list">
                   
                        {{$data->links()}}
                    
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <style type="text/css">
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>
    <script type="text/javascript">
        function delArticle(id){
            layer.confirm('你确定要删除此文章吗？', {
              btn: ['删除','取消'] }, function(){
                //发送异步删除文章
               $.ajax({
                type:'post',
                url:"{{url('admin/article/')}}/"+id,
                data:{'_method':'delete','_token':"{{csrf_token()}}"},
                dataType:'json',
                success:function(db){
                    if(db.code==1){
                        location.href=location.href;
                        layer.msg(db.msg, {icon: 6});

                    }else{
                        layer.msg(db.msg, {icon: 5});

                    }
               }
           }) 

              

            }, function(){
              

            });
        }
    </script>
@endsection