<?php
namespace App\Http\Controllers\Admin;
use Mail;
use Illuminate\Support\Facades\Input;
class MailController extends CommonController{
	protected $con;
	protected $name;
	public function index(){

		return view('admin.mail');
	}
	//邮件处理
	public function mail(){
		$db=Input::except('_token');

		// $re=Mail::send('admin.mail',['user' =>$db],function($m) use ($db){

		// 	$m->from('183844707@qq.com','测试啊from');

		// 	$m->to($db['mail_name'],'测试啊from')->subject($db['mail_content']);
		// });


		$data = ['email'=>$db['mail_name'], 'name'=>$db['mail_title'], 'uid'=>6, 'activationcode'=>'5555sss'];
		Mail::send('admin.mail', $data, function($message) use($data)
		{
		    $message->to($data['email'], $data['name'])->subject('欢迎注册我们的网站，请激活您的账号！');
		});


		// if($re){
		// 	echo '发送成功！';
		// }else{
		// 	echo '发送失败！';
		// }

	}



// public function hasManyPays()

//   {

//     return $this->hasMany('Pay', 'user_id', 'id');

//   }


//   $accounts = User::find(10)->hasManyPays()->get();




// 多对多关系和之前的关系完全不一样，因为多对多关系可能出现很多冗余数据，用之前自带的表存不下了。

// 我们定义两个模型：Article 和 Tag，分别表示文章和标签，他们是多对多的关系。表结构应该是这样的：

//  	public function belongsToManyArticle()

//   {

//     return $this->belongsToMany('Article', 'article_tag', 'tag_id', 'article_id');

//   }
// 需要注意的是，第三个参数是本类的 id，第四个参数是第一个参数那个类的 id。

// 使用跟 hasMany 一样：


//  $tagsWithArticles = Tag::take(10)->get()->belongsToManyArticle()->get();





	// public function sendEmailReminder(Request $request, $id){
 //        $user = User::findOrFail($id);

 //        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
 //            $m->from('hello@app.com', 'Your Application');$m->to($user->email, $user->name)->subject('Your Reminder!');
 //        });
 //    }





}