<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\User;//数据库命名空间
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;//Input 类名空间（判断是否是post提交）
use Illuminate\Support\Facades\Crypt;//crypt加密服务命名空间
use App\Http\Requests;//路由命名空间

require_once 'resources/org/code/Code.class.php';
//后台登录控制器
class LoginController extends CommonController{

	//登录模块
	public function login(){
		//获取表单提交的所有数据
		$input=Input::all();
		//判断是否是post提交
		if($input){
			//判断表单提交的和session里面的验证码是否一致
			$code=new \Code;
			$_code=$code->get();//获得session里面的验证码
			if(strtoupper($input['code'])!=$_code){
				//验证码错误的时候返回错误信息
				//back()返回到上一页 with()把错误信息存放在session里面的msg下标里面
				return back()->with("msg","验证码错误啊");
			}

			//判断用户名和密码是否正确
			$user=User::first();

			if($user->user_name!=$input['user_name'] || Crypt::decrypt($user->user_pass)!=$input['user_pass']){

				return back()->with('msg','用户名或密码错误!');

			}
				//将登陆的信息放在session里面
				session(['user'=>$user]);
				return redirect('admin/index');

		}else{
			return view('admin.login');
		}
		
	}

	//验证码模块
	public function code(){
		$code=new \Code;
		$code->make();

	}

	//退出模块
	public function quit(){
		session(['user'=>null]);
		return redirect("admin/login");
	}


	//字符串加密服务
	public function crypt(){
		//crypt加密的字符串长度是小于250个以内的
		$str="123456";
		$deci="eyJpdiI6IktHMVFMeGRzZmRPRExSQ2RlQjgybVE9PSIsInZhbHVlIjoiZm5vZ3cyMkZzSHBLV2ZFdlhVQ3lKQT09IiwibWFjIjoiYTQ1MzJkNGUzMmUyMjJiYjM2NmMyZWFkZTI1ODAyZDc3NjNlOTdlNjlmNjA2NTAwZjc0ZWMyZDc1YTE5MmNkNiJ9";
		//字符串加密类
			//encrypt加密字符串
		echo Crypt::encrypt($str);
		echo "<br>";
			//decrypt解密字符串
		echo Crypt::decrypt($deci);
	}




}





