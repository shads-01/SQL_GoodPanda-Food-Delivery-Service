<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';
    protected $primaryKey = 'offer_id';
    public $timestamps = false;

    protected $fillable = [
        'restaurant_id',
        'offer_title',
        'discount_type',
        'discount_value',
        'target_type',
        'target_item_id',
        'target_category_id',
        'start_datetime',
        'end_datetime',
        'is_active',
        'created_at',
    ];
}
