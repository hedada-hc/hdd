<?php
namespace App\Http\Controllers\Home;
use App\Http\Model\Article;//文章模型
use App\Http\Model\Links;//友情链接模型
use App\Http\Model\Category;//友情链接模型
//首页控制器
class IndexController extends CommonController{
	//首页模板
	public function index(){

		//图文列表(5)篇
		$data=Article::orderBy('art_time','DESC')->paginate(5);

		

		

		//友情链接
		$link=Links::orderBy('link_order','DESC')->get();
		return view('home.index',compact('data','link'));
	}

	//文章列表
	public function cate($cate_id){
		//分类
		$filed=Category::find($cate_id);

		//分类列表
		$data=Article::where('cate_id',$cate_id)->orderBy('art_time','DESC')->paginate(4);

		//获取顶级分类的子分类
		$son_cate=Category::where('cate_pid',$cate_id)->get();
		return view('home.list',compact('filed','data','son_cate'));
	}

	//文章内容
	public function article($art_id){
		$file=Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
		
		//获取上一篇文章
		$top=Article::where('art_id','<',$art_id)->orderBy('art_id','DESC')->first();
		
		//获取下一篇文章
		$next=Article::where('art_id','>',$art_id)->orderBy('art_id','ASC')->first();

		return view('home.article',compact('file','top','next')); 
	}
}
