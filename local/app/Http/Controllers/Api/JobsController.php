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
            $return = 'Data Saved Successfully';
            $status_code = 200;
        } else {
            $return = 'Failed to save data';
            $status_code = 500;
        }
        return response()
            ->json($return, $status_code);
    }
}
