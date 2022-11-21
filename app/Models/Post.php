<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
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
        return $this->hasOne(PostTranslation::class)->where(['lang'=>app()->getLocale()]);
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }

    public static function getPost($url)
    {
        return static::whereUrl($url)->join('post_translations as pt','pt.post_id','=','posts.id')->first();
    }


    //admin functions

    public static function getPosts($request)
    {
        $query = DB::table('posts as p')
                        ->select('p.*','pt.name', 'pt.url', 'pt.intro', 'pt.content','pt.meta_title','pt.meta_description','pt.meta_keywords','pt.lang')
                        ->leftJoin('post_translations as pt','pt.post_id','=','p.id')
                        ->where('pt.lang','=',config('app.admin_locale'));

        if($month = $request->month)
            $query->whereMonth('created_at',$month);

        if($year = $request->year)
            $query->whereYear('created_at',$year);

        if($term = $request->term)
            $query->whereRaw('FIND_IN_SET("'.$term.'",tags)');

        if($search = $request->search)
        {
            $query->where('pt.name','like','%'.$search.'%');
            //$query->orWhere('pt.intro','like','%'.$search.'%');
            //$query->orWhere('pt.content','like','%'.$search.'%');
        }
        $query->orderBy('created_at');
        
        return $query->paginate(9);
    }

    public static function getArchives()
    {
        if(app()->getLocale() != 'en')
        {
            $locale = app()->getLocale().'_'.strtoupper(app()->getLocale());
            DB::statement("SET lc_time_names = '".$locale."'");
        }
        return static::selectRaw('year(created_at) year, monthname(created_at) monthname, month(created_at) month, count(*) published')
                    ->groupBy('year','monthname','month')
                    ->orderByRaw('min(created_at) desc')
                    ->get()
                    ->toArray();
    }

    public static function getTerms()
    {
       $query = static::selectRaw('GROUP_CONCAT(DISTINCT(tags )) tags')->first()->toArray();
       return array_unique(explode(',',$query['tags']));
    }

    public static function sortPosts($items)
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
