<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //protected $fillable = [];

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeFilter($query)
    {
        $query->select('users.*');

        if(!empty(session('filter_user_name')))
            $query->where('users.name', 'LIKE', '%' . session('filter_user_name') . '%');

        if(!empty(session('filter_user_email')))
            $query->where('users.email', 'LIKE', '%' . session('filter_user_email') . '%');

        if(!empty(session('filter_user_phone')))
            $query->where('users.phone', 'LIKE', '%' . session('filter_user_phone') . '%');

        if(!empty(session('filter_user_order_by')))
        {
            if(session('filter_user_order_by') == 'name_asc')
                $query->orderBy('name','asc');
            if(session('filter_user_order_by') == 'name_desc')
                $query->orderBy('name','desc');
            if(session('filter_user_order_by') == 'date_asc')
                $query->orderBy('created_at','asc');
            if(session('filter_user_order_by') == 'date_desc')
                $query->orderBy('created_at','desc');
        }
        else
            $query->orderBy('id','desc');

        if(!empty(session('filter_user_limit')))
            $query->limit(session('filter_user_limit'));

        return $query;
    }

    public static function getCountries()
    {
        return DB::table('countries')->orderByRaw("
            CASE
                WHEN native = 'Magyarorsz??g' THEN 0 
                WHEN native = 'Rom??nia' THEN 1 
                WHEN native = 'Deutschland' THEN 2 
                ELSE 3
            END ASC")->get(['id','native']);
    }

    public static function getStates($country_id)
    {
        $data['states'] = DB::table('states')->whereCountry_id($country_id)->orderBy('name')->get(['id','name']);
        return $data;
    }

    public static function getCities($state_id)
    {
        $data['cities'] = DB::table('cities')->whereState_id($state_id)->orderBy('name')->get(['id','name']);
        return $data;
    }
}
