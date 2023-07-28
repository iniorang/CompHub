<?php

namespace App\Http\Controllers;

use App\Models\kompetisi;
use App\Models\tim;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comp = kompetisi::latest()->paginate(4);
        $tim = tim::latest()->paginate(4);
        return view('home',compact('comp','tim'));
    }

    public function allkomp(){
        $comp = kompetisi::orderBy("nama","asc")->get();
        return view('allKomp', compact('comp'));
    }

    public function alltim(){
        $tim = tim::orderBy("nama","asc")->get();
        return view('allTim', compact('tim'));
    }
}
