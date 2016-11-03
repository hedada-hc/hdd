<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Links;//分类表模型 空间
use Illuminate\Support\Facades\Input;//post空间
use Illuminate\Support\Facades\Validator;//自动验证空间
//友情链接控制器
class LinksController extends CommonController{

	//get admin/links 友情链接列表页
	public function index(){
		$data=Links::orderBy('link_order','DESC')->get();
		return view('admin.links.index',compact('data'));
	}

	//post admin/links/changeOrder 异步修改排序
	public function changeOrder(){
		$post=Input::except('_token');
		$re=Links::where('link_id',$post['link_id'])->update(['link_order'=>$post['link_order']]);
		if($re){
			$data=['msg'=>'排序更新成功!','code'=>1];
		}else{
			$data=['msg'=>'排序更新失败!'];

		}
		return $data;
	}

	//post admin/links/create 添加友链(其实只是用来分配模板的)
	public function create(){

		return view('admin/links/add');
		
	}

	//post admin/category 添加分类提交模块 正在添加的是用到它的
	public function store(){
		$post=Input::except("_token");
		if($post){
			//验证规则
			$rules=[
				'link_name'=>'required|max:20',
				'link_url'=>'required|max:100'
			];
			//规则错误信息
			$message=[
				'link_name.required'=>'友链名称必需填写',
				'link_url.required'=>'友链地址必需填写',
				'link_name.max'=>'友链名称小于20位',
				'link_url.max'=>'友链地址小于100位',
			];
			//数据验证
			$validator=Validator::make($post,$rules,$message);
			if($validator->passes()){
				$re=Links::create($post);
				if($re){
					return redirect('admin/links');
				}else{
					return back()->withErrors('errors','添加友链失败');
				}
			}else{
				return back()->withErrors($validator);
			}

		}
	}


	//get admin/links/{}/edit 编辑友链  返回旧数据
	public function edit($link_id){
		//返回旧数据
		$old=Links::find($link_id);
		//分配模板并且返回旧数据
		return view('admin.links.edit',compact('old'));
	}
	

	//put  admin/links/{}   编辑提交数据模块 
	public function update($link_id){
		$post=Input::except('_token','_method');
		//更新入库
		$re=Links::where('link_id',$link_id)->update($post);
		if($re){
			return redirect('admin/links');
		}else{
			return back()->withErrors('errors','更新失败！');
		}
	}


	//delete admin/links/{} 删除友链
	public function destroy($link_id){
		$re=Links::where('link_id',$link_id)->delete();
		if($re){
			$data=['msg'=>'删除成功！','code'=>1];
		}else{
			$data=['msg'=>'删除失败！'];
		}
		return  $data;
	}

	public function show(){

	}
}