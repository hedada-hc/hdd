<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;//数据库空间
//文章分类模型
class Category extends Model{
	//设置表名称
	protected $table="category";
	//设置主键
	protected $primaryKey="cate_id";
	//关闭默认记录更新时间
	public $timestamps=false;
	//设置保护字段可提交  guarded排除那些字段 给个[]空数组就可以了
	protected $guarded=[];



	public function tree(){
		//获取所有分类
		$cate=$this->orderBy('cate_order','ASC')->get();

		//调用树状结构
		return $this->getTree($cate,'cate_name','cate_id','cate_pid');
	}

		//获取子分类树状结构
	public function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0){

		$arr=[];
			foreach ($data as $k => $v) {
				//找到PID等于0的
				if($v->$field_pid==$pid){
					$data[$k]['_'.$field_name]=$data[$k][$field_name];
					//等于0的压到数组里面去
					$arr[]=$data[$k];
					//再次循环
					foreach ($data as $m => $n) {
						//把pid等于cate_id的压入数组里面去
						if($n->$field_pid==$v->$field_id){
							//处理树状结构
							$data[$m]['_'.$field_name]='|┈┈ '.$data[$m][$field_name];
							$arr[]=$data[$m];
						}
					}
				}
			}
			//返回处理好的数据
			return $arr;
	}
}