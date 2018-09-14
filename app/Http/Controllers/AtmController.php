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

    	//... group tgl ... //
        $data['month'] = DB::select("SELECT count(*) num, date from history_atm group by MONTH(date)");


        //data history
        //group tanggal
        $data['dates'] = HistoryAtm::selectRaw('count(*) AS date_count, date')->groupBy('date')->orderBy('date', 'desc')->where('user_id', $user)->where('date', 'like', '%'.date('Y-m'). '%')->get();

        //show detail tanggal
        for($i=0; $i<$data['dates']->count(); $i++){
            $data['daily'][$i] = HistoryAtm::where('date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->get();
            $data['balanced'][$i] = Balance::where('last_saldo_date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->where('balance_type', 'atm')->get();
            
        }

    	return view('history.atm', $data);
    }

    public function details($date){
        $user = Auth::user()->id;
        $saldo = Balance::where('user_id', $user)->where('balance_type', 'atm')->first();
        if(!$saldo) {
            Session::flash('warning', 'Please enter initial balance first!'); 
            return redirect()->route('home');
        } 

        //... masih error ... //
        $data['month'] = DB::select("SELECT count(*) num, date from history_atm group by MONTH(date)");
        

        //data saldo
        $data['balance'] = $saldo;

        //data history
        //group tanggal
        $data['dates'] = HistoryAtm::selectRaw('count(*) AS date_count, date')->groupBy('date')->orderBy('date', 'desc')->where('user_id', $user)->where('date', 'like', '%'.$date. '%')->get();

       //show detail tanggal
        for($i=0; $i<$data['dates']->count(); $i++){
            $data['daily'][$i] = HistoryAtm::where('date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->get();
            $data['balanced'][$i] = Balance::where('last_saldo_date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->where('balance_type', 'atm')->get();
            
        }
        
        $data['menu'] = 1;
        return view('history.index', $data);
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
            	//kalo data wallet ga ada dia create wallet balance baru
            	if(!$wallet){
            		//insert balance
            		$query = Balance::create([
            			'user_id' => $request['user_id'],
            			'amount' => $request['nominal'],
            			'last_saldo_date' => $request->date,
            			'initial_balance' => $request['nominal'],
            			'balance_type' => 'wallet'
            		]);
            		

            		$update_wallet =  $request['nominal'];
            		$saldo = $balance['amount'] - $request['nominal'];

            	} else {
            		$update_wallet = $wallet->amount + $request['nominal'];
            		$saldo = $balance['amount'] - $request['nominal'];
            	}
            	

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
            		'description' => 'pull from atm',
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

    public function destroy($id){
    	$data = HistoryAtm::find($id);
    	$balance = Balance::where('user_id', $data['user_id'])->where('balance_type', 'atm')->first();

    	if($data['desc'] == 'initial atm'){
    		Session::flash('danger', 'Data cannot be deleted! if you want to change the value of your balance, make sure to add some transactions, either income or spending. ');
            return \Redirect::route('atm');
    	}

    	if($data['type'] == 'pull'){
    		Session::flash('danger', 'Delete failed!. ');
            return \Redirect::route('atm');
    	} else if($data['type'] == 'transfer'){
           $update_atm = $data['nominal'] + $balance['amount'];
        } else if($data['type'] == 'income') {
            $update_atm = $balance['amount'] - $data['nominal'];
        }

    	
    	Balance::where('user_id', $data['user_id'])->where('balance_type', 'atm')->update([
    		'amount' => $update_atm
    	]);

    	HistoryAtm::destroy($id);
    	return redirect()->route('atm');
    }
}
