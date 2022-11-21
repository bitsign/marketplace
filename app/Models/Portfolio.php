<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Portfolio extends Model
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
        return $this->hasOne(PortfolioTranslation::class)->where(['lang'=>app()->getLocale()]);
    }

    public function translations()
    {
        return $this->hasMany(PortfolioTranslation::class);
    }

    public static function getPortfolio($url)
    {
        return static::whereUrl($url)->join('portfolio_translations as pt','pt.portfolio_id','=','portfolios.id')->first();
    }

    public static function sortPortfolio($items)
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
