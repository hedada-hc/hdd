@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<!-- <div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div> -->
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
        <div class="result_title">
            <h3>友情链接列表</h3>
        </div>    
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加友链</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部友链</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>

                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>友链名称</th>
                        <th>友链标题</th>
                        <th>地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v->link_id}})" value="{{$v->link_order}}">
                        </td>
                        <td class="tc">{{$v->link_id}}</td>
                        <td>
                            <a href="#">{{$v->link_name}}</a>
                        </td>
                        <td>{{$v->link_title}}</td>
                        <td><a target="_black" href="{{$v->link_url}}">{{$v->link_url}}</a></td>
                        <td>
                            <a href="{{url('admin/links/'.$v->link_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delLink({{$v->link_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                   

                    
                </table>



            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

<script type="text/javascript">
    
        function changeOrder(obj,link_id){
            var link_order=$(obj).val();

            $.post("{{url('admin/links/changeOrder')}}",{'_token':'{{csrf_token()}}','link_id':link_id,'link_order':link_order},function(data){
                    //信息框-例1
                   if(data.code==1){
                    location.href=location.href;
                        layer.msg(data.msg, {icon: 6});
                   }else{
                        layer.msg(data.msg, {icon: 5});
                   }
                    

            });
        }


        //删除分类
        function delLink(link_id){
            //询问框
            layer.confirm('你确定要删除分类吗?', {
              btn: ['确定','取消'] //按钮
            }, function(){

                $.post("{{url('admin/links/')}}/"+link_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(db){
                    if(db.code==1){
                        //删除成功刷新当前页面
                        location.href=location.href
                        layer.msg(db.msg, {icon: 6});
                    }else{
                        layer.msg(db.msg, {icon: 5});
                    }
                    
                });
              
            }, function(){

            }); 
        }
        
   
</script>



@endsection
