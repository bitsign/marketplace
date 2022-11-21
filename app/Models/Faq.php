<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

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

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


     //admin functions

     public static function sortFaqs($items)
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
}
