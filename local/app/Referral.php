<?php

namespace Responsive;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Referral
 * Eloquent\Model for table referrals
 *
 * @package Responsive
 */
class Referral extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = ['who', 'to'];

    /**
     * Don't use timestamps in table
     *
     * @var bool
     */
    public $timestamps = false;

    public function getUsers(){
      return $this->belongsTo(User::class , 'who' , 'id');

    }
}
