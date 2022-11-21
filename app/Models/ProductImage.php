<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     * @var string
     */
    //protected $table = 'team';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    //protected $fillable = [];

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function getDefaultProductImage(int $productId)
    {
        return self::where('product_id',$productId)->where('default',1)->first();
    }


}
