<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Balance;
use App\History;
use App\HistoryAtm;

class ResetsController extends Controller
{
    public function doReset($id){
    	HistoryAtm::where('user_id', $id)->delete();
    	Balance::where('user_id', $id)->delete();
    	History::where('user_id', $id)->delete();
    	
    	Session::flash('success', 'Reset data success.');
    	return redirect()->route('history.index');

    }
}
