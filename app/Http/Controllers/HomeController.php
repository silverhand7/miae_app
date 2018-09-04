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
        $request['last_saldo_date'] = date('Y-m-d');
        $request['user_id'] = Auth::user()->id;
        $request['initial_balance'] = $request->amount;

        $validate = $request->validate([
            'amount' => 'required|integer'
        ]);

        if($validate){
            Balance::create($request->toArray());
            History::create([
                'user_id' => $request['user_id'],
                'date' => $request['last_saldo_date'],
                'type' => 'income',
                'description' => 'initial balance',
                'nominal' => $request['amount']
            ]);
            $request->session()->flash('success', 'Add initial balance success!');
            return redirect()->route('history.index');
        }
        
    }
}
