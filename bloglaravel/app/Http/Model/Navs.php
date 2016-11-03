<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
//导航模型
class Navs extends Model{
	protected $table = "navs";
	protected $primaryKey="nav_id";
	public $timestamps=false;
	protected $guarded=[];
}