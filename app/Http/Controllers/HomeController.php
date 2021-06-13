<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\{Category, Product, User};

class HomeController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $category = Category::where('status', 'ACTIVE')->count();
        $product = Product::where('status', 'ACTIVE')->count();
        $customer = User::where('id','<>', Auth::user()->id)->count();

        return view('home', compact('category', 'product', 'customer'));
    }
}
