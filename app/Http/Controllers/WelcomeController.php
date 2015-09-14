<?php namespace App\Http\Controllers;

use DB;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('pages.home.welcome');
	}
	public function show_news_list(){
		$data['news'] = DB::table('news_beauty_tb')->where('domain', 'vnexpress.net')->get();
		return view('pages.home.news_list',$data);
	}
	public function show_news_detail(){
		return view('pages.home.news_detail');
	}
	
}
