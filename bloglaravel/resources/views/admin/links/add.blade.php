@extends('layouts.admin')

@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加友情链接
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>友链添加</h3>
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
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加友链</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部友链</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/links')}}" method="post">
        {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                     <tr>
                        <th style="width:120px;"><i class="require">*</i>友链名称：</th>
                        <td>
                            <input type="text" name="link_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>友链名称必需填写</span>
                        </td>
                    </tr>

                     <tr>
                        <th>友链URL：</th>
                        <td>
                            <input type="text" class="lg" name="link_url" value="http://">
                        </td>
                    </tr>

                    
                    <tr>
                        <th>友链标题：</th>
                        <td>
                            <input type="text" class="lg" name="link_title">
                            <p>标题可以写30个字</p>
                        </td>
                    </tr>

                    
                     <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="lg" name="link_order" value="1">
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
@endsection