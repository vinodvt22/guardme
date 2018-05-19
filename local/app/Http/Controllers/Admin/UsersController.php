<?php

namespace Responsive\Http\Controllers\Admin;



use File;
use Image;
use Responsive\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Responsive\Http\Requests;
use Illuminate\Http\Request;
use Responsive\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function index()
    {
        $data = \request()->all();

        $query = DB::table('users');

        // todo: filter by location
        $location_search_filter = isset($data['location']) ? trim($data['location']) : null;
        if($location_search_filter){
            $location_search_query_array = explode(' ', trim($location_search_filter));

            if(count($location_search_query_array)){
                foreach ($location_search_query_array as $search_location){
                    $query = $query
                        ->whereHas('address', function ($q) use ($search_location){
                            $q->where('citytown', $search_location);
                        });
                }
            }
        }

        // todo: filter by gender
        $search_gender = isset($data['gender']) ? trim($data['gender']) : null;
        if($search_gender && $search_gender != 'all'){
            $query = $query->where('gender', $search_gender);
        }

		// todo: filter by reg date
        $search_reg_date = isset($data['reg_date']) ? trim($data['reg_date']) : null;

        if($search_reg_date){
            $query = $query
                ->whereDate('created_at', $search_reg_date);
        }
		
        $users = $query
            ->orderBy('id','desc')
            ->get();

        return view('admin.users', ['users' => $users]);
    }
	
	
	
	public function destroy($id) {
		
		$image = DB::table('users')->where('id', $id)->first();
		$orginalfile=$image->photo;
		$userphoto="/userphoto/";
       $path = base_path('images'.$userphoto.$orginalfile);
	  File::delete($path);
	  
	  
		$userdetails = DB::table('users')
		 ->where('id', '=', $id)
		 ->get();
	  
	 $uemail = $userdetails[0]->email;
	 
	  DB::delete('delete from seller_services where user_id = ?',[$id]);
	  DB::delete('delete from rating where email = ?',[$uemail]);
	  DB::delete('delete from booking where user_id = ?',[$id]);
	  
	   DB::delete('delete from shop_gallery where user_id = ?',[$id]);
	   DB::delete('delete from shop where user_id = ?',[$id]);
      DB::delete('delete from users where id!=1 and id = ?',[$id]);
	   
      return back();
      
   }
	
}