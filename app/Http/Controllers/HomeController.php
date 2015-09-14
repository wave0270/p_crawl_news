<?php namespace App\Http\Controllers;

use DB;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}
	
	public function crawlData(){
		return view('pages.dashboard.crawlData');
	}
	
	public function save_news(){
		foreach($_POST['arr'] as $k => $v){
			$params = [
				'domain'	=>	$_POST['domain'],
				'type'		=>	$_POST['type'],
				'title'		=>	$v['title'],
				'href'		=>	$v['href'],
				'image'		=>	$v['image'],
				'desc'		=>	$v['desc'],
			];
			DB::table('news_beauty_tb')->insert($params);
		}
		return 'save_news ok';
	}
}
