<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Category;//分类表模型 空间
use Illuminate\Support\Facades\Input;//post空间
use Illuminate\Support\Facades\Validator;//自动验证空间
//文章分类控制器
class CategoryController extends CommonController{
	//get admin/category  全部分类列表
	public function index(){
		//获取所有分类
		$cate=(new Category)->tree();

		return view('admin.category.index')->with('data',$cate);
	}

	public function changeOrder(){
		$post=Input::all();
		$cate=Category::find($post['cate_id']);
		$cate->cate_order=$post['cate_order'];
		$re=$cate->update();
		if($re){
			$data=[
				'status'=>0,
				'msg'=>'分类排序更新成功！'
			];
		}else{
			$data=[
				'status'=>1,
				'msg'=>'分类排序更新失败，请检查！'
			];
		}
		return $data;
	}



	

	//get admin/category/create 添加分类模块
	public function create(){
		$data=Category::where('cate_pid',0)->get();
		return view('admin/category/add',compact('data'));
	}

	//post admin/category 添加分类提交模块
	public function store(){
		$post=Input::except('_token');

		if($post){
			//验证规则
			$rules=[
				'cate_name'=>'required|between:1,10',

			];

			//验证错误提示
			$message=[
				'cate_name.required'=>'分类名称不能为空!',
				'cate_name.between'=>'分类名称不得超过10位!',
			];

			//提交数据验证
			$validator=Validator::make($post,$rules,$message);

			//判断是否通过
			if($validator->passes()){
				$re=Category::create($post);
				//添加成功则跳转
				if($re){
					return redirect('admin/category');
				}else{
					return back()->with('errors','分类添加失败！');
				}
				
			}else{
				return back()->withErrors($validator);
			}
		}	
	}

	//get admin/category{category}/edit  编辑分类
	public function edit($cate_id){
		//返回旧数据
		$field=Category::find($cate_id);

		//获得分类i
		$data=Category::where('cate_pid',0)->get();
		return view('admin.category.edit',compact('field','data'));
	}


		//put admin/category{category} 更新分类
	public function update($cate_id){
		//排除不用的字段
		$post=Input::except('_token','_method');
		//更新
		$re=Category::where('cate_id',$cate_id)->update($post);
		if($re){
			return redirect("admin/category");
		}else{
			return back()->with('errors',"分类更新失败");
		}
	}


	//get admin/category{category} 显示单个分类信息
	public function show(){

	}

	//delete admin/category{category} 删除单个分类
	public function destroy($cate_id){

		//删除分类
		$re=Category::where('cate_id',$cate_id)->delete();
		Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
		if($re){
			$data=[
				'code'=>0,
				'msg'=>'分类删除成功！'
			];
		}else{
			$data=[
				'code'=>1,
				'msg'=>'分类删除失败！'
			];
		}
		return $data;
	}


}