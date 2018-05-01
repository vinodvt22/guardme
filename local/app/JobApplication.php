<?php

namespace Responsive;

use Illuminate\Database\Eloquent\Model;
use DB;

class JobApplication extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_applications';

    /**
     * @param $job_id
     * @return mixed
     */
    public function is_applied($job_id) {
        $user_id = auth()->user()->id;
        $res = DB::table($this->table)
            ->where('applied_by', $user_id)
            ->where('job_id', $job_id)->get();
        return count($res);
    }

    /**
     * @param $job_id
     * @return mixed
     */
    public function is_hired($job_id) {
        $user_id = auth()->user()->id;
        $res = DB::table($this->table)
            ->where('applied_by', $user_id)
            ->where('is_hired', 1)
            ->where('job_id', $job_id)->get();
        return count($res);
    }
}
