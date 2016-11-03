@extends('layouts.admin')

@section('content')

    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加配置项链接
    </div>
    <!--面包屑配置项 结束-->

    <!--结果集标题与配置项组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>配置项添加</h3>
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
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
    </div>
    <!--结果集标题与配置项组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/config').'/'.$old->conf_id}}" method="post">
        {{csrf_field()}}
        {{method_field('PUT')}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th style="width:120px;"><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="conf_title" value="{{$old->conf_title}}">
                        </td>
                    </tr>

                    <tr>
                        <th style="width:120px;"><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="conf_name" value="{{$old->conf_name}}">
                        </td>
                    </tr>

                    <tr>
                        <th>字段类型：</th>
                        <td>
                            
                            <input type="radio" name="field_type" value="input" @if($old->field_type=='input') checked="checked" @endif onclick="showTr()" >input 　

                            <input type="radio" name="field_type" value="textarea" @if($old->field_type=='textarea') checked="checked" @endif  onclick="showTr()">textarea 　
                            <input type="radio" name="field_type" value="radio" @if($old->field_type=='radio') checked="checked" @endif onclick="showTr()">radio 　
                        </td>
                    </tr>

                    <tr class="field_value">
                        <th>类型值：</th>
                        <td>
                            <input type="text" class="lg" name="field_value" value="{{$old->field_value}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>类型值只有在radio的时候才会用 1|开启,0|关闭 逗号隔开</span>

                        </td>
                    </tr>
                    
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="lg" name="conf_order" value="{{$old->conf_order}}">
                        </td>
                    </tr>
                   
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="conf_tips">{{$old->conf_tips}}</textarea>
                        </td>
                    </tr>
                   
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script type="text/javascript">

        function showTr(){
            var type=$('input[name=field_type]:checked').val();
            if(type=='radio'){
                $('.field_value').show();
            }else{
                $('.field_value').hide();
            }
        }
        showTr();
    </script>
@endsection