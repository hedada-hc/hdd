<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;//post表单空间名
use Illuminate\Support\Facades\Validator;//自动验证空间
use App\Http\Model\User;//用户表模型
use Illuminate\Support\Facades\Crypt;//Crypt加密服务

//后台欢迎首页
class IndexController extends CommonController{

	//欢迎模块
	public function index(){
		return view('admin.index');
	}	

	//后台配置
	public function info(){

		return view("admin.info");
	}

	//修改管理员密码模块
	public function pass(){

		//如果有post提交过来就处理
		if($post=Input::all()){
			//错误信息 表单字段名用 ’.‘ 来连接验证规则 required
			$message=[
				'password.required'=>'新密码不能为空！',
				'password.between'=>'新密码不得小于6位大于20位！',
				'password.confirmed'=>'两次密码输入不一致',
			];
			//验证规则 confirmed两次密码必需相同
			$rules=[
				'password'=>'required|between:6,20|confirmed',
			];
			$validator=Validator::make($post,$rules,$message);
			
			//判断验证是否通过
			if($validator->passes()){
				//拿到数据
				$user=User::first();

				//用Crypt解密数据库原始密码
				$old_pass=Crypt::decrypt($user->user_pass);

				//判断输入的原始密码是否通过
				if($post['password_o']==$old_pass){
					//先用Crypt 加密 密码然后更新到数据库里面
					$user->user_pass=Crypt::encrypt($post['password']);
					//更新密码
					$user->update();
					//更新成功返回首页
					return back()->with("errors","密码更新成功！-----新密码为：".$post['password']);
				}else{
					//原始密码错误就往$errors里面压入一个错误信息
					return back()->with('errors','原始密码错误');
				}
			}else{
				//withErrors 专门传错误信息的
				return back()->withErrors($validator);
			}

		}else{
			//没有就证明是通过get方式请求的就给展示页面
			return view("admin.pass");
		}
		
	}
}