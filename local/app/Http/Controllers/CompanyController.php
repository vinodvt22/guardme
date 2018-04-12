<?php

namespace Responsive\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;
use File;
use Image;
use Mail;
use Illuminate\Support\Facades\Validator;

use Responsive\Country;
use Responsive\Address;
use Responsive\Company;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

	 public function __construct()
    {
       $this->middleware('auth');
    }



    public function sangvish_viewshop()
    {






    	$userid = Auth::user()->id;
		$editprofile = DB::select('select * from users where id = ?',[$userid]);
		$data = array('editprofile' => $editprofile);

      $time = array("12:00 AM"=>"0", "01:00 AM"=>"1", "02:00 AM"=>"2", "03:00 AM"=>"3", "04:00 AM"=>"4", "05:00 AM"=>"5", "06:00 AM"=>"6", "07:00 AM"=>"7", "08:00 AM"=>"8",
	 "09:00 AM"=>"9", "10:00 AM"=>"10", "11:00 AM"=>"11", "12:00 PM"=>"12", "01:00 PM"=>"13", "02:00 PM"=>"14", "03:00 PM"=>"15", "04:00 PM"=>"16", "05:00 PM"=>"17", "06:00 PM"=>"18",
	 "07:00 PM"=>"19", "08:00 PM"=>"20", "09:00 PM"=>"21", "10:00 PM"=>"22", "11:00 PM"=>"23");

	 $days=array("1 Day" => "1", "2 Days" => "2", "3 Days" => "3", "4 Days" => "4", "5 Days" => "5", "6 Days" => "6", "7 Days" => "7", "8 Days" => "8", "9 Days" => "9",
			"10 Days" => "10", "11 Days" => "11", "12 Days" => "12", "13 Days" => "13", "14 Days" => "14", "15 Days" => "15", "16 Days" => "16", "17 Days" => "17", "18 Days" => "18",
			"19 Days" => "19", "20 Days" => "20", "21 Days" => "21", "22 Days" => "22", "23 Days" => "23", "24 Days" => "24", "25 Days" => "25", "26 Days" => "26", "27 Days" => "27",
			"28 Days" => "28", "29 Days" => "29", "30 Days" => "30");


	$daytxt=array("Sunday" => "0", "Monday" => "1", "Tuesday" => "2", "Wednesday" => "3", "Thursday" => "4", "Friday" => "5", "Saturday" => "6");

	    $sellermail = Auth::user()->email;
    	 $shopcount = DB::table('shop')
		 ->where('seller_email', '=', $sellermail)
		 ->count();


          $shop = DB::table('shop')
                ->where('seller_email', '=', $sellermail)
				->get();

			if ($shop->isEmpty()) {
				return redirect('/addcompany');
			}


					if($shop[0]->start_time > 12)
					{
						$start=$shop[0]->start_time - 12;
						$stime=$start."PM";
					}
					else
					{
						$stime=$shop[0]->start_time."AM";
					}
					if($shop[0]->end_time>12)
					{
						$end=$shop[0]->end_time-12;
						$etime=$end."PM";
					}
					else
					{
						$etime=$shop[0]->end_time."AM";
					}

		$sel=explode(",",$shop[0]->shop_date);
		$lev=count($sel);


		$uberid=Auth::user()->id;

		$viewservice = DB::table('seller_services')
		->where('user_id', $uberid)
		->orderBy('id','desc')
		->leftJoin('subservices', 'subservices.subid', '=', 'seller_services.subservice_id')
		->get();

		$set_id=1;
		$setting = DB::table('settings')->where('id', $set_id)->get();

		$shop_id = $shop[0]->id;

		$rating_count = DB::table('rating')
	          ->where('rshop_id', '=', $shop_id)

			  ->count();

		$rating = DB::table('rating')
		          ->leftJoin('users', 'users.email', '=', 'rating.email')
	          ->where('rshop_id', '=', $shop_id)
			  ->orderBy('rid', 'desc')

			  ->get();


                $countries = Country::all();
                $address = Address::where('user_id', Auth::user()->id)->get();

		$data = array('time' => $time, 'days' =>  $days, 'daytxt' => $daytxt, 'shopcount' => $shopcount, 'shop' => $shop, 'stime' => $stime,
		'etime' => $etime, 'lev' => $lev, 'sel' => $sel, 'viewservice' => $viewservice, 'setting' => $setting, 'rating_count' => $rating_count, 'rating' => $rating);
            return view('shop', compact('data', 'userid', 'editprofile', 'data','countries','address'))->with($data);
    }










 public function sangvish_addcompany()
    {







      $time = array("12:00 AM"=>"0", "01:00 AM"=>"1", "02:00 AM"=>"2", "03:00 AM"=>"3", "04:00 AM"=>"4", "05:00 AM"=>"5", "06:00 AM"=>"6", "07:00 AM"=>"7", "08:00 AM"=>"8",
	 "09:00 AM"=>"9", "10:00 AM"=>"10", "11:00 AM"=>"11", "12:00 PM"=>"12", "01:00 PM"=>"13", "02:00 PM"=>"14", "03:00 PM"=>"15", "04:00 PM"=>"16", "05:00 PM"=>"17", "06:00 PM"=>"18",
	 "07:00 PM"=>"19", "08:00 PM"=>"20", "09:00 PM"=>"21", "10:00 PM"=>"22", "11:00 PM"=>"23");

	 $days=array("1 Day" => "1", "2 Days" => "2", "3 Days" => "3", "4 Days" => "4", "5 Days" => "5", "6 Days" => "6", "7 Days" => "7", "8 Days" => "8", "9 Days" => "9",
			"10 Days" => "10", "11 Days" => "11", "12 Days" => "12", "13 Days" => "13", "14 Days" => "14", "15 Days" => "15", "16 Days" => "16", "17 Days" => "17", "18 Days" => "18",
			"19 Days" => "19", "20 Days" => "20", "21 Days" => "21", "22 Days" => "22", "23 Days" => "23", "24 Days" => "24", "25 Days" => "25", "26 Days" => "26", "27 Days" => "27",
			"28 Days" => "28", "29 Days" => "29", "30 Days" => "30");


	$daytxt=array("Sunday" => "0", "Monday" => "1", "Tuesday" => "2", "Wednesday" => "3", "Thursday" => "4", "Friday" => "5", "Saturday" => "6");

	    $sellermail = Auth::user()->email;
    	 $shopcount = DB::table('shop')
		 ->where('seller_email', '=', $sellermail)
		 ->count();


          $shop = DB::table('shop')
                ->where('seller_email', '=', $sellermail)
                ->get();


		$admin_idd=1;

		$admin_email_id = DB::table('users')
                ->where('id', '=', $admin_idd)
                ->get();



		$siteid=1;
		$site_setting=DB::select('select * from settings where id = ?',[$siteid]);



                $categories = \Responsive\Businesscategory::all();
                $address = Address::where('user_id', Auth::user()->id)->get();

		$data = array('time' => $time, 'days' =>  $days, 'daytxt' => $daytxt, 'shopcount' => $shopcount, 'shop' => $shop, 'admin_email_id' => $admin_email_id,
		'site_setting' => $site_setting,'categories'=>$categories,'address'=>$address);
            return view('addcompany')->with($data);
    }

































	public function sangvish_editshop(Request $request)
    {





		$testimonials = DB::table('testimonials')->orderBy('id', 'desc')->get();

      $time = array("12:00 AM"=>"0", "01:00 AM"=>"1", "02:00 AM"=>"2", "03:00 AM"=>"3", "04:00 AM"=>"4", "05:00 AM"=>"5", "06:00 AM"=>"6", "07:00 AM"=>"7", "08:00 AM"=>"8",
	 "09:00 AM"=>"9", "10:00 AM"=>"10", "11:00 AM"=>"11", "12:00 PM"=>"12", "01:00 PM"=>"13", "02:00 PM"=>"14", "03:00 PM"=>"15", "04:00 PM"=>"16", "05:00 PM"=>"17", "06:00 PM"=>"18",
	 "07:00 PM"=>"19", "08:00 PM"=>"20", "09:00 PM"=>"21", "10:00 PM"=>"22", "11:00 PM"=>"23");

	 $days=array("1 Day" => "1", "2 Days" => "2", "3 Days" => "3", "4 Days" => "4", "5 Days" => "5", "6 Days" => "6", "7 Days" => "7", "8 Days" => "8", "9 Days" => "9",
			"10 Days" => "10", "11 Days" => "11", "12 Days" => "12", "13 Days" => "13", "14 Days" => "14", "15 Days" => "15", "16 Days" => "16", "17 Days" => "17", "18 Days" => "18",
			"19 Days" => "19", "20 Days" => "20", "21 Days" => "21", "22 Days" => "22", "23 Days" => "23", "24 Days" => "24", "25 Days" => "25", "26 Days" => "26", "27 Days" => "27",
			"28 Days" => "28", "29 Days" => "29", "30 Days" => "30");


	$daytxt=array("Sunday" => "0", "Monday" => "1", "Tuesday" => "2", "Wednesday" => "3", "Thursday" => "4", "Friday" => "5", "Saturday" => "6");

	    $sellermail = Auth::user()->email;
    	 $shopcount = DB::table('shop')
		 ->where('seller_email', '=', $sellermail)
		 ->count();


          $shop = DB::table('shop')
                ->where('seller_email', '=', $sellermail)
                ->get();



		if($shop[0]->start_time > 12)
					{
						$start=$shop[0]->start_time - 12;
						$stime=$start."PM";
					}
					else
					{
						$stime=$shop[0]->start_time."AM";
					}
					if($shop[0]->end_time>12)
					{
						$end=$shop[0]->end_time-12;
						$etime=$end."PM";
					}
					else
					{
						$etime=$shop[0]->end_time."AM";
					}

		$sel=explode(",",$shop[0]->shop_date);
		$lev=count($sel);


		$requestid = $request->id;

		$editshop = DB::select('select * from shop where id = ?',[$requestid]);






		$data = array('time' => $time, 'days' =>  $days, 'daytxt' => $daytxt, 'shopcount' => $shopcount, 'shop' => $shop, 'stime' => $stime,
		'etime' => $etime, 'lev' => $lev, 'sel' => $sel, 'requestid' => $requestid, 'editshop' => $editshop);
            return view('editshop')->with($data);
    }








































    protected function sangvish_savedata(Request $request)
    {
        $data = $request->all();        
        $rules = array();
        $messages = array(
            'email' => 'The :attribute field is already exists',
            'name' => 'The :attribute field must only be letters and numbers (no spaces)'
        );
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            $failedRules = $validator->failed();
            return back()->withErrors($validator);
        } else {            
            $company_name=$data['company_name'];
            $company_phone=$data['company_phone'];
            $company_email=$data['company_email'];
            $business_desc=$data['business_desc'];
            $business_categoryid=$data['category'];
            //Address save
            
            $postcode = isset($data['postcode'])?$data['postcode']:'';
            $houseno = isset($data['houseno'])?$data['houseno']:'';
            $line1 = isset($data['line1'])?$data['line1']:'';
            $line2 = isset($data['line2'])?$data['line2']:'';
            $line3 = isset($data['line3'])?$data['line3']:'';
            $line4 = isset($data['line4'])?$data['line4']:'';
            $locality = isset($data['locality'])?$data['locality']:'';
            $citytown = isset($data['town'])?$data['town']:'';
            $country = isset($data['country'])?$data['country']:'';
            $latitude = isset($data['addresslat'])?$data['addresslat']:'';
            $longitude = isset($data['addresslong'])?$data['addresslong']:'';
            
            $address = Address::where('user_id', Auth::user()->id)->first();
            if(!isset($address)){
                $address = new Address();
                $address->user_id = Auth::user()->id;
            }
            $address->postcode = $postcode;
            $address->houseno = $houseno;
            $address->line1 = $line1;
            $address->line2 = $line2;
            $address->line3 = $line3;
            $address->line4 = $line4;
            $address->locality = $locality;
            $address->longitude = $longitude;
            $address->latitude = $latitude;
            $address->citytown = $citytown;
            $address->country = $country;
            $address->save();
            $company = Company::where('user_id', Auth::user()->id)->first();
            if(!isset($company)) {
                $company = new Company();
            }
            $company->company_name = $company_name;
            $company->company_email = $company_email;
            $company->company_phone = $company_phone;
            $company->business_categoryid = $business_categoryid;
            $company->business_desc = $business_desc;
            $company->user_id = Auth::user()->id;
            $company->save();
            return back()->with('success', 'Company has been created');         
        }
    }
}
