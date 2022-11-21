<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Kalnoy\Nestedset\NodeTrait;
//use Illuminate\Support\Facades\DB;

class CategoryTranslation extends Model
{
    use HasFactory;
    //use NodeTrait;

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


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
