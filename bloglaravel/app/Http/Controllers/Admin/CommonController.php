<?php
namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;//Input 类名空间（判断是否是post提交）
use Illuminate\Support\Facades\Crypt;//crypt加密服务命名空间
//后台公共控制器
class CommonController extends Controller{
	//图片上传
	public function upload(){
		$file=Input::file('Filedata');
		//判断图片是否上传成功
		if($file->isValid()){
			//获取上传文件的后缀
			$extension=$file->getClientOriginalExtension();
			//重新定义文件名称
			$pic_name=date('YmdShi',time()).mt_rand(000,999).".".$extension;
			//判断上传目录是否存在不存在则创建
			if(!is_dir('upload')){
				$files=mkdir('upload',0777,true);
			}
			//移动上传文件到目录 base_path获取根目录
			$path=$file->move(base_path().'/upload',$pic_name);
			
			if($path){
				//返回图片路径和反馈消息
				$arr=['/upload/'.$pic_name,'上传成功！'];
				return '/upload/'.$pic_name;

			}else{
				return json_encode('上传失败啦！');

			}
		}

	}
}