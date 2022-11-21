<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $table = 'categories';

    use HasFactory;
    use NodeTrait;

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
        return $this->hasOne(CategoryTranslation::class)->where(['lang'=>app()->getLocale()]);
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public static function tree()
    {
        return static::with('translation')->defaultOrder()->descendantsOf(1)->toTree();
    }

    /*protected function getScopeAttributes()
    {
        return [ 'category_id' ];
    }*/


    //admin functions

    public static function getCategoryImages($id)
    {
        return DB::table('category_images')->where('id',$id)->get();
    }

    public static function getCategoryTree()
    {

        return  DB::select( DB::raw("SELECT CONCAT( REPEAT( ' ', (COUNT(parent.name) - 1) ), node.name) AS name
                            FROM categories AS node, categories AS parent
                            WHERE node.lft BETWEEN parent.lft AND parent.rgt
                            GROUP BY node.name
                            ORDER BY node.lft"));
    }


}
