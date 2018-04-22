<?php

namespace Responsive\Http\Controllers\Api;

use Illuminate\Http\Request;
use Responsive\Http\Controllers\Controller;
use Responsive\Job;

class JobsController extends Controller
{
    //
    public function create(Request $request) {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        $job = new Job();
        $postedData = $request->all();
        $job->title = !empty($postedData['title']) ? ($postedData['title']) : null;
        $job->description = !empty($postedData['description']) ? ($postedData['description']) : null;
        $job->country = !empty($postedData['country']) ? ($postedData['country']) : null;
        $job->city_town = !empty($postedData['town']) ? ($postedData['town']) : null;
        $job->address_line1 = !empty($postedData['line1']) ? ($postedData['line1']) : null;
        $job->address_line2 = !empty($postedData['line2']) ? ($postedData['line2']) : null;
        $job->address_line3 = !empty($postedData['line3']) ? ($postedData['line3']) : null;
        $job->post_code = !empty($postedData['postcode']) ? ($postedData['postcode']) : null;
        $job->latitude = !empty($postedData['addresslat']) ? ($postedData['addresslat']) : null;
        $job->longitude = !empty($postedData['addresslong']) ? ($postedData['addresslong']) : null;
        $job->business_category_id = !empty($postedData['business_category']) ? ($postedData['business_category']) : null;
        $job->security_category_id = !empty($postedData['security_category']) ? ($postedData['security_category']) : null;
        $job->created_by = !empty(auth()->user()->id) ? (auth()->user()->id) : 0;
        $isSaved = $job->save();
        if ($isSaved) {
            $return = ['message' => 'Data Saved Successfully', 'id' => $job->id];
            $status_code = 200;
        } else {
            $return = ['message' => 'Failed to save data'];
            $status_code = 500;
        }
        return response()
            ->json($return, $status_code);
    }
    public function schedule(Request $request, $id) {
        $this->validate($request, [
            'working_hours' => 'required|integer',
            'working_days' => 'required|integer',
            'pay_per_hour' => 'required|integer',
        ]);
        $posted_data = $request->all();
        $working_days = !empty($posted_data['working_days']) ? $posted_data['working_days'] : 0;
        $working_hours = !empty($posted_data['working_hours']) ? $posted_data['working_hours'] : 0;
        $pay_per_hour = !empty($posted_data['pay_per_hour']) ? $posted_data['pay_per_hour'] : 0;

        $job = Job::find($id);
        $logged_in_id = !empty(auth()->user()->id) ? (auth()->user()->id) : 0;
        $return_data = ['Not allowed to perform this action'];
        $return_status = 500;
        if (!empty($job) && !empty($job->created_by) && $job->created_by == $logged_in_id) {
            $job->daily_working_hours = $working_hours;
            $job->monthly_working_days = $working_days;
            $job->per_hour_rate = $pay_per_hour;
            if ($job->save()) {
                $return_data = ['message' => 'Data saved successfully'];
                $return_status = 200;
            }

        }
        return response()
            ->json($return_data, $return_status);
    }
}
