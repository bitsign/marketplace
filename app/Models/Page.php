<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model
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

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with('translation')->orderBy('sort');
    }

    public function translation()
    {
        return $this->hasOne(PageTranslation::class)->where(['lang'=>app()->getLocale()]);
    }

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public static function tree()
    {
        return static::with('translation')->with(implode('.', array_fill(0, 100, 'children')))->where(['parent_id'=>0])->where(['active'=>1])->where(['menu'=>1])->orderBy('sort','ASC')->get();
    }

    public static function footMenu()
    {
        return static::with('translation')->where(['footmenu'=>1])->where(['active'=>1])->orderBy('sort','ASC')->get();
    }

    public static function getChildren()
    {
        return static::with('translation')->where('parent_id','!=',0)->where(['active'=>1])->orderBy('sort','ASC')->get();
    }

    public static function getPage($url)
    {
        return static::whereUrl($url)->join('page_translations as pt','pt.page_id','=','pages.id')->first();
    }

    public static function getPageByType($type)
    {
        return static::whereType($type)->where('pt.lang','=',app()->getLocale())->join('page_translations as pt','pt.page_id','=','pages.id')->first();
    }

    //admin functions

    public static function getPages()
    {
        return DB::table('pages as p')
                        ->select('p.*','pt.name', 'pt.url', 'pt.content','pt.menu_title','pt.meta_description','pt.meta_keywords','pt.lang')
                        ->leftJoin('page_translations as pt','pt.page_id','=','p.id')
                        ->where('pt.lang','=',config('app.admin_locale'))
                        ->orWhere('pt.id','=',NULL)
                        ->orderBy('sort')
                        ->get();
    }

    public static function sortPages($items)
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
