<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Balance;
use App\History;
use App\HistoryAtm;

class AtmController extends Controller
{
    public function index(){
    	$user = Auth::user()->id;
    	$data['menu'] = 2;
    	$data['saldo_atm'] = Balance::where('user_id', $user)->where('balance_type', 'atm')->first();

    	if(!$data['saldo_atm']){
    		Session::flash('warning', 'Please insert initial balance for your atm first');
    		return view('initial_atm')->with('menu', 2);
    	}


        //data history
        //group tanggal
        $data['dates'] = HistoryAtm::selectRaw('count(*) AS date_count, date')->groupBy('date')->orderBy('date', 'desc')->where('user_id', $user)->get();

        //show detail tanggal
        for($i=0; $i<$data['dates']->count(); $i++){
            $data['daily'][$i] = HistoryAtm::where('date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->get();
            $data['balanced'][$i] = Balance::where('last_saldo_date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->where('balance_type', 'atm')->get();
            
        }

    	return view('history.atm', $data);
    }

    public function initialAtm(Request $request){
    	$balance = Balance::where('user_id', Auth::user()->id)->where('balance_type', 'atm')->first();
        if($balance){
            Session::flash('danger', "You has been input initial balance"); 
            return redirect()->route('atm'); 
        }
        $request['last_saldo_date'] = date('Y-m-1');
        $request['user_id'] = Auth::user()->id;
        $request['amount'] = str_replace(",", '', $request->amount);
        $request['initial_balance'] = $request['amount'];
        $request['balance_type'] = 'atm';

        $validate = $request->validate([
            'amount' => 'required'
        ]);

        if($validate){
            Balance::create($request->toArray());
            HistoryAtm::create([
                'user_id' => $request['user_id'],
                'date' => $request['last_saldo_date'],
                'type' => 'income',
                'desc' => 'initial atm',
                'nominal' => $request['amount']
            ]);
            $request->session()->flash('success', 'Add initial balance atm success!');
            return redirect()->route('atm');
        }

    }

    public function store(Request $request){
    	$validate = $request->validate([ 
            'date' => 'required',
            'type' => 'required',
            'nominal' => 'required',
        ]);

        $request['nominal'] = str_replace(",", '', $request->nominal);
        $request['user_id'] = Auth::user()->id;

        if($validate){
            
            $balance = Balance::where('user_id', $request['user_id'])->where('balance_type', 'atm')->first();
            if($request->type == 'income'){
            	$a=0;
                $saldo = $balance['amount'] + $request['nominal'];
            } else if($request->type == 'pull'){
            	//kalo dia pull, saldo di wallet otomatis tambah
            	$a = 1;
            	$wallet = Balance::where('user_id', $request['user_id'])->where('balance_type', 'wallet')->first();
            	$update_wallet = $wallet->amount + $request['nominal'];
            	$saldo = $balance['amount'] - $request['nominal'];


            }
            else if($request->type == 'transfer') {
            	$a=0;
                $saldo = $balance['amount'] - $request['nominal'];
            }

            if($a==1){
            	//insert to table history atm
	            HistoryAtm::create($request->toArray());
	            //insert to table history wallet
            	History::create([
            		'user_id' => $request['user_id'],
            		'date' => $request->date,
            		'type' => 'income',
            		'nominal' => $request['nominal'],
            		'description' => 'pull from atm'
            	]);
            	//update balance wallet
            	Balance::where('user_id', $request['user_id'])->where('balance_type', 'wallet')->update([
	                'amount' => $update_wallet,
	                'last_saldo_date' => $request['date'],
	            ]);
            	//update balance atm
	            Balance::where('user_id', $request['user_id'])->where('balance_type', 'atm')->update([
	                'amount' => $saldo,
	                'last_saldo_date' => $request['date'],
	            ]);

            	Session::flash('success', 'Your wallet has been successfully added!');
	            return redirect()->route('history.index');
            } else {
            	//insert to table history
	            HistoryAtm::create($request->toArray());

	            //update table balance to newest saldo
	            Balance::where('user_id', $request['user_id'])->where('balance_type', 'atm')->update([
	                'amount' => $saldo,
	                'last_saldo_date' => $request['date'],
	         
	            ]);

	            Session::flash('success', 'Add new history successfully!');
	            return redirect()->route('atm');

            }
        }
    }
}
