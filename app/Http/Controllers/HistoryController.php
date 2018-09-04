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
        $saldo = Balance::where('user_id', $user)->first();
        if(count($saldo) == 0) {
            Session::flash('warning', 'Please enter initial balance first!'); 
            return redirect()->route('home');
        } 
        //data saldo
        $data['balance'] = $saldo;

        //data history
        //group tanggal
        $data['dates'] = History::selectRaw('count(*) AS date_count, date')->groupBy('date')->orderBy('date', 'asc')->get();
        //dd($data['dates'][3]->toArray()['date']);
        for($i=0; $i<$data['dates']->count(); $i++){
            $data['daily'][$i] = History::where('date', $data['dates'][$i]->toArray()['date'])->get();
            //$data['daily'][$i] = $data['dates'][$i]->toArray()['date'];
        }
        //dd($data['daily']);
        
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
            
            $balance = Balance::where('user_id', $request['user_id'])->first();
            if($request->type == 'income'){
                $saldo = $balance['amount'] + $request['nominal'];
            } else {
                $saldo = $balance['amount'] - $request['nominal'];
            }

            //insert to table history
            History::create($request->toArray());

            //update table balance to newest saldo
            Balance::where('user_id', $request['user_id'])->update([
                'amount' => $saldo,
                'last_saldo_date' => $request['date']
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
        //
    }
}
