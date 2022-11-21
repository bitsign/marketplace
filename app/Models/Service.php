<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
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

    public function translation()
    {
        return $this->hasOne(ServiceTranslation::class)->where(['lang'=>app()->getLocale()]);
    }

    public function translations()
    {
        return $this->hasMany(ServiceTranslation::class);
    }

    public static function getAllServices()
    {
        return static::with('translation')->where(['active'=>1])->orderBy('sort','ASC')->get();
    }

    public static function getService($url)
    {
        return static::whereUrl($url)->join('service_translations as st','st.service_id','=','services.id')->first();
    }

    //admin functions

    public static function getServices()
    {
        return DB::table('services as s')
                        ->select('s.*','st.name', 'st.url', 'st.content','st.meta_description','st.meta_keywords','st.lang')
                        ->leftJoin('service_translations as st','st.service_id','=','s.id')
                        ->where('st.lang','=',config('app.admin_locale'))
                        ->orWhere('st.id','=',NULL)
                        ->orderBy('sort')
                        ->get();
    }

    public static function sortServices($items)
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
