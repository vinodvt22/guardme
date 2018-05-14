<?php

namespace Responsive\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Mail;
use Auth;
use Crypt;
use Responsive\Transaction;
use URL;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
	public function show() {
		$wallet = new Transaction();
		$wallet_data = $wallet->getAllTransactionsAndEscrowBalance();
		return view('wallet', compact('wallet_data'));
	}
}
