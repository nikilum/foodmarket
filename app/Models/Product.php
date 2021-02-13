<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * фикс бага пхпшторма TODO потом убрать
 * @property boolean $timestamps
 */

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $table = 'products';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'product_description',
        'product_image_name',
        'product_price'
    ];
}
