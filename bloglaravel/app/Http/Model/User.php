<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;//数据库命名空间
//用户表模型
class User extends Model{
	//指定表名称
	protected $table = "user";
	//指定自增id字段
	protected $primaryKey= "user_id";
	//禁止添加修改后的记录
	public $timestamps=false;
}