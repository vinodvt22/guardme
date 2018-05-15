<?php
namespace Responsive\Http\Controllers\Api;
use Responsive\Http\Traits\JobsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Responsive\Http\Controllers\Controller;
use Responsive\Job;
use Responsive\JobApplication;
use Responsive\Transaction;
use Responsive\User;
use Responsive\Businesscategory;
use Responsive\SecurityCategory;

class SearchController extends Controller
{
    
    public function getpersonnelsearch(Request $request)
    {        
        $this->validate($request, [
            'page_id' => 'required'
        ]);
        
        $sec_personnels = [];
        $posted_data = $request->all();        
        $page_id = !empty($posted_data['page_id']) ? $posted_data['page_id'] : '';
        $user_id = !empty($posted_data['user_id']) ? $posted_data['user_id'] : '';
        $post_code = !empty($posted_data['post_code']) ? $posted_data['post_code'] : '';
        $cat_val = !empty($posted_data['cat_val']) ? $posted_data['cat_val'] : '';
        $gender = !empty($posted_data['gender']) ? $posted_data['gender'] : '';
        $location_filter = !empty($posted_data['location_filter']) ? $posted_data['location_filter'] : '';
        $sec_personnel = !empty($posted_data['sec_personnel']) ? $posted_data['sec_personnel'] : '';
        $distance = !empty($posted_data['distance']) ? $posted_data['distance'] : '';
        
        if ( $post_code != '' || $cat_val != '' || $gender != '' || $location_filter != '' || $sec_personnel != '' || $distance != '' ) {
            if( $post_code != '' ){
                $post_code = trim($post_code);
                if (!empty($post_code)) {
                    $postcode_url = "https://api.getaddress.io/find/".$post_code."?api-key=ZTIFqMuvyUy017Bek8SvsA12209&sort=true";
                    $postcode_url = str_replace(' ', '%20', $postcode_url);
                    $json_data = file_get_contents($postcode_url);
                    $post_code_array = json_decode($json_data, true);
                    $latitude = $post_code_array['latitude'];
                    $longitude = $post_code_array['longitude'];
                }
                $sec_personnels = User::getPersonnelSearchNearBy($posted_data, $latitude, $longitude, 20, 'kilometers', $page_id);
            } else {
                $sec_personnels = User::getPersonnelNearBy($posted_data, $page_id);
            }
        } else {
            $sec_personnels = User::getPersonnelNearBy($data, $page_id);
        }
        
        return response()->json([
            'personnel_list' => $sec_personnels
        ]);
    }   
    
}