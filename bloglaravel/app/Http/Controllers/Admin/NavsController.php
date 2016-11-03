<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\Input;//post空间
use Illuminate\Support\Facades\Validator;//自动验证空间
//自定义导航控制器
class NavsController extends CommonController{

	//get admin/navs 导航列表
	public function index(){
		$data=Navs::orderBy('nav_order','DESC')->get();

		return view('admin.navs.index',compact('data'));
	}

	//post admin/create   添加导航
	public function create(){
		return view('admin.navs.add');
	}

	public function store(){
		$post=Input::except('_token');

		//验证规则
		$rule=[
			'nav_name'=>'max:20|required',
			'nav_alias'=>'max:20|required',
			'nav_url'=>'required'
		];
		//验证错误信息
		$message=[
			'nav_name.required'=>'标题不能为空',
			'nav_name.max'=>'标题不能超过20个字符',
			'nav_alias.required'=>'描述不能为空',
			'nav_alias.max'=>'描述不能超过20个字符',
			'nav_url.required'=>'连接不能为空',
		];
		//开始验证
		$va=Validator::make($post,$rule,$message);
		//判断是否通过验证
		if($va->passes()){
			$re=Navs::create($post);
			if($re){
				return redirect('admin/navs');
			}else{
				return back()->withErrors('errors','添加失败!');
			}
		}else{
			return back()->withErrors($va);
		}
		
	}

	//异步排序
	public function changeOrder(){
		$post=Input::except('_token');
		//更新排序
		$re=Navs::where('nav_id',$post['nva_order'])->update();
		if($re){
			$data=['code'=>1,'msg'=>'更新成功！'];
		}else{
			$data=['msg'=>'更新失败！'];
		}
		return $data;
	}

	//delete admin/navs/{}  删除导航
	public function destroy($nav_id){
		
		$re=Navs::where('nav_id',$nav_id)->delete();
		if($re){
			$data=['code'=>1,'msg'=>'删除成功！'];
		}else{
			$data=['msg'=>'删除失败！'];
		}
		return $data;
	}

	//get admin/navs/{}/edit  编辑导航
	public function edit($nav_id){
		//返回旧数据
		$old=Navs::find($nav_id);
		return view('admin.navs.edit',compact('old'));
	}

	//put  admin/navs/{}  提交编辑数据 入库数据库
	public function update($nav_id){
		$db=Input::except('_token','_method');
		//数据验证
		//验证规则
		$rule=[
			'nav_name'=>'max:20|required',
			'nav_alias'=>'max:20|required',
			'nav_url'=>'required'
		];
		//验证错误信息
		$message=[
			'nav_name.required'=>'标题不能为空',
			'nav_name.max'=>'标题不能超过20个字符',
			'nav_alias.required'=>'描述不能为空',
			'nav_alias.max'=>'描述不能超过20个字符',
			'nav_url.required'=>'连接不能为空',
		];
		//va验证
		$va=Validator::make($db,$rule,$message);
		if($va->passes()){
			$re=Navs::where('nav_id',$nav_id)->update($db);
			if($re){
				return redirect('admin/navs');
			}else{
				return back()->withErrors('errors',"更新失败");
			}
		}else{
			return back()->withErrors($va);
		}
	}
}