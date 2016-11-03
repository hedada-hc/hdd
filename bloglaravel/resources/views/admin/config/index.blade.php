@extends('layouts.admin')

@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接管理
    </div>
    <!--面包屑配置项 结束-->

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
    
        <div class="result_wrap">
        <div class="result_title">
            <h3>配置项列表</h3>
            @if(count($errors)>0)
            <div class="mark">
            @if(is_object($errors))
                @foreach($errors->all() as $v)
                    <p>{{$v}}</p>
                @endforeach  
            @else
                    <p>{{$errors}}</p>
                @endif    
            </div>
            @endif  
        </div>    
            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
            <form action="{{url('admin/config/content')}}" method="post">
            {{csrf_field()}}
                <table class="list_tab">
                    <tr>

                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>标题</th>
                        <th>名称</th>
                        <th></th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v->conf_id}})" value="{{$v->conf_order}}">
                        </td>
                        <td class="tc">{{$v->conf_id}}</td>
                        <td>
                            <a href="#">{{$v->conf_title}}</a>
                        </td>
                        <td>{{$v->conf_name}}</td>
                        <td>
                        <input type="hidden" name="conf_id[]" value="{{$v->conf_id}}">
                        {!! $v->_html !!}
                        </td>
                        <td>
                            <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delConf({{$v->conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                   

                    
                </table>
                 <div class="btn_group">
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                </div>
                </form>

            </div>
            
        </div>

    <!--搜索结果页面 列表 结束-->

<script type="text/javascript">
    
        function changeOrder(obj,conf_id){
            var conf_order=$(obj).val();

            $.post("{{url('admin/config/changeOrder')}}",{'_token':'{{csrf_token()}}','conf_id':conf_id,'conf_order':conf_order},function(data){
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
        function delConf(conf_id){
            //询问框
            layer.confirm('你确定要删除分类吗?', {
              btn: ['确定','取消'] //按钮
            }, function(){

                $.post("{{url('admin/config/')}}/"+conf_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(db){
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