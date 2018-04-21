<?php

namespace Responsive\Http\Controllers;

use Illuminate\Http\Request;
use Responsive\Businesscategory;
use Responsive\SecurityCategory;

class JobsController extends Controller
{
    //
    public function create() {

        $all_security_categories = SecurityCategory::get();
        $all_business_categories = Businesscategory::get();
        
        return view('jobs.create', compact('all_security_categories', 'all_business_categories'));
    }
    public function schedule() {
        
        return view('jobs.schedule', compact('all_security_categories', 'all_business_categories'));
    }
}
