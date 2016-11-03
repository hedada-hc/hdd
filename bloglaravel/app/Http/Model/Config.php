<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
//网站配置模型
class Config extends Model{
	protected $table="config";
	protected $primaryKey="conf_id";
	public $timestamps=false;
	protected $guarded=[];
}