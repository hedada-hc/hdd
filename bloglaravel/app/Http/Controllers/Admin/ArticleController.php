<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Article;//文章模型
use App\Http\Model\Category;//分类模型
use Illuminate\Support\Facades\Input;//提交空间
use Illuminate\Support\Facades\Validator;//自动验证
class ArticleController extends CommonController{

	//gte admin/article  全部文章列表
	public function index(){
		$data=Article::orderBy('art_id','DESC')->paginate(5);
	
		//分类
		$cate=(new Category)->tree();

		
		return view('admin.article.index',compact('data','cate'));

	}

	//写入配置项到文件
	public function files(){
		echo 'dsasdasda';
	}

	//get admin/article/create 添加文章
	public function create(){
		$cate=(new Category)->tree();
		$data=$cate;
		return view('admin.article.add',compact('data'));
	}

	//post admin/article 添加文章提交模块
	public function store(){

		//获取文章提交的所有数据 except排除掉 _tokens 值
		$post=Input::except('_tokens');
		//插入文章发布时间
		$post['art_time']=time();

		//validator 自动验证
		//验证规则
		$rules=[
			'art_title'=>'required|max:100',
			'art_content'=>'required|max:20000'
		];
		//验证提示错误信息
		$message=[
			'art_title.required'=>'标题不能为空！',
			'art_title.max'=>'标题不得超过100个字符！',
			'art_content.required'=>'内容不能为空请填写',
			'art_content.max'=>'内容不能超过2万个字符'
		];
		//validator 自动验证
		$validator=Validator::make($post,$rules,$message);
		//判断是否验证通过
		if($validator->passes()){
			//入库文章
			$re=Article::create($post);
			if($re){
				return redirect('admin/article');
			}else{
				return back()->withErrors('errors','文章添加失败');
			}
		}else{
			//失败返回验证的错误信息
			return back()->withErrors($validator);
		}
		
		
	}

	//get admin/article/{}/edit  文章编辑模块
	public function edit($art_id){
		//获得分类数据
		$data=Category::where('cate_pid',0)->get();
		$data=(new Category)->tree();
		//返回旧数据
		$old_data=Article::find($art_id);
		return view('admin.article.edit',compact('old_data','data'));
	}

	//put admin/article/{}  //文章修改
	public function update($art_id){
		$post=Input::except('_token','_method');
		//更新文章
		$re=Article::where('art_id',$art_id)->update($post);
		if($re){
			return redirect('admin/article');
		}else{
			return back()->withErrors('errors','文章更新失败');
		}
	}


	//delete admin/article/{category} //删除单个文章
	public function destroy($art_id){
		
		//删除完文章后再删除图片
			//判断文件是否存在 存在则删除
		$thumb=Article::find($art_id);
		if(file_exists(".".$thumb['art_thumb'])){
			$un=unlink(".".$thumb['art_thumb']);
			if(!$un){
				return '删除失败';
			}
		}else{
			return '删除失败';
		}
		//接收di删除
		$re=Article::where('art_id',$art_id)->delete();
		//判断是否删除成功 然后返回

		if($re){
			return json_encode(['msg'=>'删除成功！','code'=>1]);
		}else{
			return json_encode(['msg'=>'删除失败啦！','code'=>0]);
		}
	}

}