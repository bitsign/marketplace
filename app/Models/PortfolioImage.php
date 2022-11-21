<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortfolioImage extends Model
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

    public $timestamps = false;

    public static function setImage($request)
    {
        $row = 0;

        if(!empty($request['img_default']))
        {
            static::where('portfolio_id',$request['id'])->update(['featured'=>0]);
            $data['featured'] = 1;
        }
        else 
            $data['featured'] = 0;

        if(!empty($request['tags']))
            $data['tags'] = implode(',', array_filter($request['tags']));
        else
            $data['tags'] = "";
    
        $data['name'] = $request['title'];
        //$data['alt'] = $p['alt'];
        
        $row += static::where('id',$request['img_id'])->update($data);
    
        return $row;
    }
}
