<?php

namespace App\Models;

use App\Models\OrderProduct;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function shipping_method()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class,'status_id');
    }

    public function scopeFilter($query)
    {
        $query->select('orders.*','s.name as status_name','s.color','u.name','u.email','u.phone','u.zip','u.city','u.address','u.country','u.state');
        $query->join('statuses AS s', 'orders.status_id', '=', 's.id');
        $query->join('users AS u', 'orders.user_id', '=', 'u.id');

        if (!empty(session('filter_order_status')))
            $query->where('status_id', session('filter_order_status'));

        if (!empty(session('filter_order_id')))
            $query->where('orders.id', session('filter_order_id'));

        if (!empty(session('filter_order_user')))
            $query->where('u.name', 'LIKE', '%' . session('filter_order_user') . '%');

        if (!empty(session('filter_order_mindate')))
            $query->where('orders.created_at','>=',session('filter_order_mindate'));

        if (!empty(session('filter_order_maxdate')))
            $query->where('orders.created_at','<=',session('filter_order_maxdate'));

        $query->orderBy('orders.id','desc');

        if(!empty(session('order_limit')))
            $query->limit(session('order_limit'));

        return $query;
    }
}
