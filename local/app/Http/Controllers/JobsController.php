<?php
namespace Responsive\Http\Controllers;
use Illuminate\Http\Request;
use Responsive\Businesscategory;
use Responsive\SecurityCategory;
use Responsive\Job;
use Responsive\Transaction;
class JobsController extends Controller
{
    //
    public function create() {
        $all_security_categories = SecurityCategory::get();
        $all_business_categories = Businesscategory::get();

        return view('jobs.create', compact('all_security_categories', 'all_business_categories'));
    }
    public function schedule($id) {
        return view('jobs.schedule', compact('id'));
    }
    public function broadcast($id) {
        $all_security_categories = SecurityCategory::get();
        return view('jobs.broadcast', compact('id', 'all_security_categories'));
    }
    public function paymentDetails($id) {
        $trans = new Transaction();
        $available_balance = $trans->getWalletAvailableBalance();
        $jobDetails = Job::calculateJobAmount($id);
        return view('jobs.payment-details', compact('jobDetails', 'id', 'available_balance'));
    }
    public function confirmation() {
        return view('jobs.confirm');
    }

    /**
     * @return mixed
     */
    public function myJobs() {
        $my_jobs = Job::getMyJobs();
        return view('jobs.my', compact('my_jobs'));
    }

    /**
     * @return mixed
     */
    public function findJobs() {
        $jobs = Job::findJobs();
        return view('jobs.find', compact('jobs'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function viewJob($id) {
        if (!$id) {
            return abort(404);
        }
        $job = Job::find($id);
        if (empty($job)) {
            return abort(404);
        }
        return view('jobs.detail', compact('job'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function applyJob($id) {
        $job = Job::find($id);
        return view('jobs.apply', ['job' => $job]);
    }
}