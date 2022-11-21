<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    
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

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
