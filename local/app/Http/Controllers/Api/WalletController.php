<?php

namespace Responsive\Http\Controllers\Api;

use Illuminate\Http\Request;
use Responsive\Http\Controllers\Controller;
use Responsive\Transaction;
class WalletController extends Controller
{
    //
    public function getWalletData() {
        $wallet = new Transaction();
        $wallet_data = $wallet->getAllTransactionsAndEscrowBalance();
        return response()
            ->json($wallet_data, 200);
    }


}
