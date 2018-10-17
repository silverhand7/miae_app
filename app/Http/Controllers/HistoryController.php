<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Balance;
use App\History;

class HistoryController extends Controller
{

    public function index()
    {
        
        $user = Auth::user()->id;
        $now = date("Y-m");
        $saldo = Balance::where('user_id', $user)->where('balance_type', 'wallet')->first();
        if(!$saldo) {
            Session::flash('warning', 'Please enter initial balance first!'); 
            return redirect()->route('home');
        } 

        //... group tgl ... //
        $data['month'] = DB::select("SELECT count(*) num, date from history group by MONTH(date)");
        

        //data saldo
        $data['balance'] = $saldo;

        //data history
        //group tanggal
        $data['dates'] = History::selectRaw('count(*) AS date_count, date')->groupBy('date')->orderBy('date', 'desc')->where('user_id', $user)->where('date', 'like', '%'.date('Y-m'). '%')->get();

       //show detail tanggal
        for($i=0; $i<$data['dates']->count(); $i++){
            $data['daily'][$i] = History::where('date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->get();
            $data['balanced'][$i] = Balance::where('last_saldo_date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->where('balance_type', 'wallet')->get();
            
        }

        //get total pengeluaran & pemasukan bulan ini
        $data['pengeluaran'] = History::selectRaw('sum(nominal) AS total')->where('type', 'expense')->where('date', 'like', '%'.$now. '%')->first();

        $data['pemasukan'] = History::selectRaw('sum(nominal) AS total')->where('type', 'income')->where('date', 'like', '%'.$now. '%')->first();
        
        $data['menu'] = 1;
        return view('history.index', $data);
    }

    public function details($date){
        $user = Auth::user()->id;
        $saldo = Balance::where('user_id', $user)->where('balance_type', 'wallet')->first();
        if(!$saldo) {
            Session::flash('warning', 'Please enter initial balance first!'); 
            return redirect()->route('home');
        } 

        //get total pengeluaran & pemasukan bulan ini
        $data['pengeluaran'] = History::selectRaw('sum(nominal) AS total')->where('type', 'expense')->where('date', 'like', '%'.$date. '%')->first();

        $data['pemasukan'] = History::selectRaw('sum(nominal) AS total')->where('type', 'income')->where('date', 'like', '%'.$date. '%')->first();

        //... masih error ... //
        $data['month'] = DB::select("SELECT count(*) num, date from history group by MONTH(date)");
        

        //data saldo
        $data['balance'] = $saldo;

        //data history
        //group tanggal
        $data['dates'] = History::selectRaw('count(*) AS date_count, date')->groupBy('date')->orderBy('date', 'desc')->where('user_id', $user)->where('date', 'like', '%'.$date. '%')->get();

       //show detail tanggal
        for($i=0; $i<$data['dates']->count(); $i++){
            $data['daily'][$i] = History::where('date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->get();
            $data['balanced'][$i] = Balance::where('last_saldo_date', $data['dates'][$i]->toArray()['date'])->where('user_id', $user)->where('balance_type', 'wallet')->get();
            
        }
        
        $data['menu'] = 1;
        return view('history.index', $data);
    }

    public function store(Request $request)
    {
        

        $validate = $request->validate([ 
            'date' => 'required',
            'type' => 'required',
            'nominal' => 'required',
        ]);

        $request['nominal'] = str_replace(",", '', $request->nominal);
        $request['user_id'] = Auth::user()->id;
        
        if($validate){
            
            $balance = Balance::where('user_id', $request['user_id'])->where('balance_type', 'wallet')->first();
            if($request->type == 'income'){
                $saldo = $balance['amount'] + $request['nominal'];
            } else {
                $saldo = $balance['amount'] - $request['nominal'];
            }

            //insert to table history
            History::create($request->toArray());

            //update table balance to newest saldo
            Balance::where('user_id', $request['user_id'])->where('balance_type', 'wallet')->update([
                'amount' => $saldo,
                'last_saldo_date' => $request['date'],
                'balance_type' => 'wallet'
            ]);

            Session::flash('success', 'Add new history successfully!');
            return redirect()->route('history.index');

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = History::find($id);
        $balance = Balance::where('user_id', $data['user_id'])->where('balance_type', 'wallet')->first();

        if($data['description'] == 'initial balance'){
            Session::flash('danger', 'Data cannot be deleted! if you want to change the value of your balance, make sure to add some transactions, either income or spending. ');
            return \Redirect::route('history.index');
        } else if($data['description'] == 'pull from atm'){
            Session::flash('danger', 'Data cannot be deleted, because you get it from your atm withdrawal transaction. ');
            return \Redirect::route('history.index');
        }

        if($data['type'] == 'expense'){
           $update_saldo = $data['nominal'] + $balance['amount']; 
        } else {
            $update_saldo = $balance['amount'] - $data['nominal'];
        }
        
        Balance::where('user_id', $data['user_id'])->where('balance_type', 'wallet')->update([
            'amount' => $update_saldo
        ]);

        History::destroy($id);
        return redirect()->route('history.index');
    }
}
