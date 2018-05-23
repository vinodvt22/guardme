<?php
namespace Responsive\Http\Controllers\Api;

use Responsive\Http\Traits\JobsTrait;
use Illuminate\Http\Request;
use Responsive\Http\Controllers\Controller;
use Responsive\Job;
use Responsive\JobApplication;
use Responsive\Transaction;
use Responsive\User;
use Responsive\Referral;
use Responsive\Businesscategory;
use Responsive\SecurityCategory;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    use JobsTrait;

    public function getUsers(){
       $id = Auth::user()->id ;

         //$user = new User();
         // $balance = $user->getBalance();
         // $user->getReferrals();

       $users =  Referral::with('getUsers')->where('to' , $id)->get();
       $balance =  10 * count($users);
        $data = array();
        foreach($users as $list){
            $data[] = [
                 'id'=> $list->getUsers['id'],
                 'email'=> $list->getUsers['email'] ,
                 'total_earned'=>$balance
            ];
        }
        return response()
            ->json($data, 200);
    }



    public function getItemsBought(){
        $id = Auth::user()->id ;
        $data =  User::select('id' ,'name' , 'email')->with('getUserItems')->where('id' , $id)->get();

        return response()
            ->json($data, 200);



    }

}
