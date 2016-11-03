<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
class Article extends Model{
	protected $table = "article";
	protected $primaryKey="art_id";
	public $timestamps=false;
	//设置保护字段可提交  guarded排除那些字段 给个[]空数组就可以了
	protected $guarded=[];
}