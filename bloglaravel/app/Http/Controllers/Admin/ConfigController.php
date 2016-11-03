<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Config;//分类表模型 空间
use Illuminate\Support\Facades\Input;//post空间
use Illuminate\Support\Facades\Validator;//自动验证空间
//网站配置控制器
class ConfigController extends CommonController{

	//get admin/config 配置列表
	public function index(){
		$data=Config::orderBy('conf_order','DESC')->get();
		//判断配置类型
		foreach ($data as $k => $v) {
			switch($v->field_type){
				case 'input':
					$data[$k]->_html='<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
					break;
				case 'textarea':
					$data[$k]->_html='<textarea name="conf_content[]">'.$v->conf_content.'</textarea>';
					break;
				case 'radio':	
					$arr=explode(',',$v->field_value);
					$str='';
					foreach ($arr as $z => $r) {
						$m=explode('|',$r);
						$c=$v->conf_content==$m[0]?'checked':'';
			
						$str .='<input type="radio" '.$c.' name="conf_content[]" value="'.$m[0].'">'.$m[1];	

					}
					$data[$k]->_html=$str;
					break;	
			}
		}
		return view('admin.config.index',compact('data'));
	}

	
	public function changeOrder(){
		$db=Input::except('_token');
		$re=Config::where('conf_id',$db['conf_id'])->update(['conf_order'=>$db['conf_order']]);
		if($re){
			return $data=['msg'=>'更新成功！','code'=>1];
		}else{
			return $data=['msg'=>'更新失败！'];

		}
	}

	//get admin/config/create  添加配置项
	public function create(){
		return view('admin.config.add');
	}

	//post admin/config/  添加配置项  提交数据模块
	public function store(){
		$db=Input::except('_token');
		//验证规则
		$rule=[
			'conf_title'=>'required|max:20',
			'conf_name'=>'required',
			'field_type'=>'required',
			'conf_order'=>'digits_between:0,200'
		];
		//验证错误信息
		$message=[
			'conf_title.required'=>'配置项标题不能为空',
			'conf_title.max'=>'配置项标题不得大于20个字符',
			'conf_name.required'=>'配置项名称不能为空',
			'field_type.required'=>'配置项类型不能为空',
			'conf_order.digits_between'=>'排序只能填写数字',
		];
		//va 验证
		$va=Validator::make($db,$rule,$message);
		if($va->passes()){
			$re=Config::create($db);
			if($re){
				return redirect('admin/config');
			}else{
				return back()->withErrors('errors','提交失败');
			}
		}else{
			return back()->withErrors($va);
		}
	}

	//写入配置项到文件
	public function putfile(){
		//获取配置项值
		$db=Config::pluck('conf_content','conf_name')->all();
		//数组转化成字符串
		
		//组合配置文件路径
		$path=base_path().'\config\web.php';
		$str="<?php \n return ".var_export($db,true).";";
		file_put_contents($path,$str);
	}


	//修改内容
	public function content(){
		$db=Input::except('_token');
		//更新入库
		foreach ($db['conf_id'] as $k => $v) {
			
				$re=Config::where('conf_id',$v)->update(['conf_content'=>$db['conf_content'][$k]]);
			
		}
		$this->putfile();
		return back()->with('errors','更新成功');
		
	}

	

	//delete 删除
	public function destroy($conf_id){
		$re=Config::where('conf_id',$conf_id)->delete();
		if($re){
			$this->putfile();

			$data=['msg'=>'删除成功！','code'=>1];
		}else{
			$data=['msg'=>'删除失败！'];

		}
		return $data;
	}

	//get admin/config/{}/edit 修改
	public function edit($conf_id){
		//返回旧数据
		$old=Config::find($conf_id);
		return view('admin.config.edit',compact('old'));
	}

	//put admin/config/{}提交编辑数据
	public function update($conf_id){
		$db=Input::except('_token','_method');
		//验证规则
		$rule=[
			'conf_title'=>'required|max:20',
			'conf_name'=>'required',
			'field_type'=>'required',
			'conf_order'=>'digits_between:0,200'
		];
		//验证错误信息
		$message=[
			'conf_title.required'=>'配置项标题不能为空',
			'conf_title.max'=>'配置项标题不得大于20个字符',
			'conf_name.required'=>'配置项名称不能为空',
			'field_type.required'=>'配置项类型不能为空',
			'conf_order.digits_between'=>'排序只能填写数字',
		];
		//开始验证
		$va=Validator::make($db,$rule,$message);
		if($va->passes()){
			$re=Config::where('conf_id',$conf_id)->update($db);
			if($re){
				$this->putfile();

				return redirect('admin/config');
			}else{
				return back()->withErrors('errors','更新数据失败');
			}
		}else{
			return back()->withErrors($va);
		}
	}

	//get admin/config{category} 显示单个分类信息
	public function show($a){
		echo $a."dsasadsad";
	}

	
	
}