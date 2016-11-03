<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;
use App\Http\Model\Article;//文章模型
class CommonController extends Controller{

	public function __construct(){
		//点击率最高的6篇文章
		$view=Article::orderBy('art_view','DESC')->take(6)->get();
		//最新发布的8篇文章
		$new=Article::orderBy('art_time','DESC')->take(8)->get();
		//点击前5篇
		$click=Article::orderBy('art_view','DESC')->take(5)->get();
		$db=Navs::all();
		//share 这个函数用来传递 参数的
		View::share('db',$db);
		View::share('view',$view);
		View::share('new',$new);
		View::share('click',$click);
	}
}