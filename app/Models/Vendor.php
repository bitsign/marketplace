<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;
    
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
        $query->select('vendors.*');

        if(!empty(session('filter_user_name')))
            $query->where('vendors.name', 'LIKE', '%' . session('filter_user_name') . '%');

        if(!empty(session('filter_user_email')))
            $query->where('vendors.email', 'LIKE', '%' . session('filter_user_email') . '%');

        if(!empty(session('filter_user_phone')))
            $query->where('vendors.phone', 'LIKE', '%' . session('filter_user_phone') . '%');

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

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
