<?php

namespace Responsive;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * Eloquent\Model for table items
 *
 * @package Responsive
 */
class Item extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['price', 'image', 'title'];

    /**
     * @var bool
     */
    public $timestamps = false;
}
