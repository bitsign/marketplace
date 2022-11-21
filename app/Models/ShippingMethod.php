<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShippingMethod extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * @var string
     */
    //protected $table = 'shipping_methods';

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

    public $timestamps = false;

    public static function sortShippings($items)
    {
        if(isset($items))
        {
            $row = 0;
            foreach ($items as $position=>$id)
            {
                $row += static::where('id',$id)->update(array('sort'=>$position));
            }
            return $row;
        }
        return 0;
    }

    public static function getCountries()
    {
        return DB::table('countries')->orderByRaw("
            CASE
                WHEN native = 'Magyarország' THEN 0 
                WHEN native = 'România' THEN 1 
                WHEN native = 'Deutschland' THEN 2 
                ELSE 3
            END ASC")->get();
    }
}
