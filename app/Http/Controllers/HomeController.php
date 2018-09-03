<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\History;
use App\Balance;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 1;
        $user = Auth::user()->id;
        $saldo = Balance::where('user_id', $user)->get();
        if($saldo->count() == 0) {
            return view('home', $data);
        } else {
            return redirect()->route('history.index');   
        }
        
    }

    public function initialBalance(request $request){
        $request['month'] = date('m');
        $request['user_id'] = Auth::user()->id;

        $validate = $request->validate([
            'amount' => 'required|integer'
        ]);

        if($validate){
            Balance::create($request->toArray());
            $request->session()->flash('success', 'Add initial balance success!');
            return redirect()->route('history.index');
        }
        
    }
}
