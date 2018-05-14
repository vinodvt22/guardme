<?php

namespace Responsive;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'security_jobs';

    public static function calculateJobAmount($id) {
        $job = Job::find($id);
        $working_hours = $job->daily_working_hours;
        $working_days = $job->monthly_working_days;
        $pay_per_hour = $job->per_hour_rate;
        $total_working_hours = $working_hours * $working_days;
        $basic_total = $total_working_hours * $pay_per_hour;
        $vat_fee = number_format(($basic_total * 20) / 100, 2, '.', '');
        $admin_fee = number_format(($basic_total * 14.99) / 100, 2, '.', '');
        $grand_total = $basic_total + $vat_fee + $admin_fee;
        $grand_total = number_format($grand_total, 2, '.', '');
        $return_data = [
            'daily_working_hours' => $working_hours,
            'monthly_working_days' => $working_days,
            'per_hour_rate' => $pay_per_hour,
            'total_working_hours_per_month' => $total_working_hours,
            'basic_total' => floatval($basic_total),
            'vat_fee' => floatval($vat_fee),
            'admin_fee' => floatval($admin_fee),
            'grand_total' => floatval($grand_total)
        ];
        return $return_data;
    }

    /**
     * @return \Illuminate\Support\Collection
     * 
     */
    public static function getMyJobs() {
        $user_id = auth()->user()->id;
        $data = Job::where('created_by', $user_id)
            ->where('status', 1)
            ->get();
        return $data;
    }

    public static function findJobs() {
        $jobs = Job::where('status', 1)
            ->orderBy('id', 'DESC')
            ->get();
        return $jobs;
    }

    function industory(){
        return $this->belongsTo(Businesscategory::class,'business_category_id');
    }

    function poster(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class,'job_id');
    }
}
