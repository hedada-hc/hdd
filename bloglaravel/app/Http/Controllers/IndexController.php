<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class IndexController extends Controller{
	public function index(){
		$db=DB::connection()->getPdo();

		
	}
}