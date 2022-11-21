<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Product extends Model
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

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(ProductTranslation::class)->where(['lang'=>app()->getLocale()]);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function defaultImage()
    {
        return $this->hasOne(ProductImage::class)->where(['default'=>1]);
    }

    public function manufacturer()
    {
        return $this->hasOne(Manufacturer::class,'id','manufacturer_id')->where(['active'=>1]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeFilter($query)
    {
        $query->select('products.*','pt.id as translation_id','pt.url','pt.details','pt.meta_title','pt.meta_description','pt.meta_keywords',DB::raw("GROUP_CONCAT(c.name separator ' > ') as category_name"));
        
        $query->join('product_translations AS pt', 'products.id', '=', 'pt.product_id');
        
        $query->leftJoin('category_product AS ct', 'products.id', '=', 'ct.product_id');
        $query->leftJoin('categories AS c', 'c.id', '=', 'ct.category_id');

        $query->where('pt.lang','=',config('app.admin_locale'));

        if (!empty(session('filter_product_number')))
            $query->where('product_number', 'LIKE', '%' . session('filter_product_number') . '%');

        if (!empty(session('filter_manufacturer')))
            $query->where('manufacturer_id', session('filter_manufacturer'));

        if (!empty(session('filter_name')))
            $query->where('pt.name', 'LIKE', '%' . session('filter_name') . '%');

        if (!empty(session('filter_categories')))
        {
            $cat_ids = array();
            foreach(session('filter_categories') as $cat_id)
            {
                $descendants = Category::descendantsAndSelf($cat_id);
                if(count($descendants) > 0)
                {
                    foreach($descendants as $desc)
                    {
                        $cat_ids[] = $desc->id;
                    }
                }
            }

            if(!empty($cat_ids))
            {
                foreach($cat_ids as $cid)
                {
                    $query->orWhereRaw('FIND_IN_SET('.$cid.',categories)');
                }
            }
        }

        $query->groupBy('products.id');

        $query->orderBy('products.id','desc');

        return $query;
    }

    public static function searchProducts($q)
    {
        //DB::enableQueryLog();
        $query = self::select('products.*','pt.name','pt.url','pt.details','pt.meta_title','pt.meta_description','pt.meta_keywords')
            ->where('published',1)
            ->where('pt.lang',app()->getLocale())
            ->whereRaw('products.published = 1 AND
                (
                    pt.name LIKE "%' . $q['search_keyword'] . '%"
                    OR pt.details LIKE "%' . $q['search_keyword'] . '%"
                    OR products.product_number LIKE "%' . $q['search_keyword'] . '%"
                    OR SOUNDEX(pt.name) = SOUNDEX("'.$q['search_keyword'].'") 
                    OR SOUNDEX(pt.details) = SOUNDEX("'.$q['search_keyword'].'")
                )')
            ->with('manufacturer')
            ->with('images')
            ->join('product_translations AS pt', 'products.id', '=', 'pt.product_id')
            ->paginate(10);
            //dd(DB::getQueryLog());
        return $query;
    }

    public static function getProduct($url)
    {
        //DB::enableQueryLog();
        $query = self::select('products.*','pt.name','pt.url','pt.details','pt.meta_title','pt.meta_description','pt.meta_keywords')
            ->where('published',1)
            ->with('manufacturer')
            ->with('images')
            ->where('pt.url','=',$url)
            ->join('product_translations AS pt', 'products.id', '=', 'pt.product_id')
            ->first();
            //dd(DB::getQueryLog());
        return $query;
    }

    public static function getProducts($category_id)
    {
        //DB::enableQueryLog();
        $products = self::where('published',1)
            ->whereRaw('FIND_IN_SET('.$category_id.',categories)')
            ->with('translation')
            ->with('defaultImage')
            ->paginate(PRODUCTS_PER_PAGE);
        //dd(DB::getQueryLog());
        return $products;
    }

    public static function getProductsWhere($where,$limit=PRODUCTS_PER_PAGE)
    {
        //dd($where);
        //DB::enableQueryLog();
        $products = self::where('published',1)
            ->where($where)
            ->with('translation')
            ->with('defaultImage')
            ->paginate($limit);
        //$sql = DB::getQueryLog();
        //dd($sql);
        return $products;
    }
}
