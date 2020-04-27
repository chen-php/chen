<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(){
		
		return view('public/base');
    }
     public function welcome(){
     	return view('public/welcome');
     }
}