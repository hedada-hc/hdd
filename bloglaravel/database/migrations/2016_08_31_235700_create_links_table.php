<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//友情链接数据迁移
class CreateLinksTable extends Migration{

	//创建表  默认生成的是inno DB 引擎的数据表
	public function up(){
		//Schema::create  创建一个links表
		Schema::create('links',function(Blueprint $table){
			//设置数据库引擎 MyIsam
			$table->engine='MyISAM';
			$table->increments('link_id');//主键id字段
			//name字段 string 代表创建出来的类型是varchar  default默认值  comment注释
			$table->string('link_name')->default('')->comment("//友链名称");
			$table->string('link_title')->default('')->comment('//友链标题');
			$table->string('link_url')->default('')->comment('//友链连接');

			//link_order字段 integer 代表int类型
			$table->integer('link_order')->default(0)->comment('//排序');
		});
	}

	//删除表
	public function down(){

		Schema::drop('links');
	}
}