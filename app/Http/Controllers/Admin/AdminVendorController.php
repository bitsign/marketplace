<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminVendorController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                    'admin/vendors'         => __('admin.list_pages', ['name' => __('admin.designers')]),
                    'admin/vendors/create'  => __('admin.create_page', ['name' => __('admin.designer')]),
                    );

        $this->data['scripts'][]    = "vendors.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('vendors.list');
    }/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendorsList(Request $request,Vendor $vendor)
    {
        //dd($request);
        if(!empty($request))
            $this->setFilters($request);

        //DB::enableQueryLog();
        $this->data['vendors'] = Vendor::filter($request)->paginate(50);
        //dd(DB::getQueryLog());

        //appends pagination link
        $url = $request->fullUrl();
        if(!empty(parse_url($url)['query']))
        {
            parse_str(parse_url($url)['query'], $get_array);
            $this->data['vendors']->appends($get_array);
        }

        $this->data['page_title'] =  __('admin.designers');

        return view('admin.vendors.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] =  __('admin.create_page', ['name' => __('admin.designer')]);
        return view('admin.vendors.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posted = $request->all();

        $posted['active'] = !empty($request->active) ? 1 : 0;

        if(!empty($posted['password']) && !empty($posted['confirm_password']))
        {
            if($posted['password'] == $posted['confirm_password'])
                $posted['password'] = Hash::make($posted['password']);
            else
            {
                alert('danger',__('The password confirmation does not match.'));
                return redirect()->route('vendors.create',$vendor);
            }
        }
        else
        {
            alert('danger',__('Password field is required'));
            return redirect()->route('vendors.create',$vendor);
        }
        unset($posted['_method']);
        unset($posted['_token']);
        unset($posted['confirm_password']);

        $vendor = Vendor::create($posted);

        if($vendor->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.designer')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.designer')]));

        return redirect()->route('vendors.edit',$vendor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $this->data['vendor'] = $vendor;

        $this->data['subscription'] = Subscription::whereUser_id($vendor->id)->first();
        if($this->data['subscription']!==NULL)
            $this->data['package'] = Package::whereStripe_plan($this->data['subscription']['stripe_price'])->first();
        else
            $this->data['package'] = array();

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.designer')]).' - '.$vendor->name;

        return view('admin.vendors.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $posted = $request->all();

        if(!empty($request->password) && !empty($request->confirm_password))
            $posted['password'] = Hash::make($request->password);
        else
            unset($posted['password']);

        $posted['active'] = !empty($request->active) ? 1 : 0;
        unset($posted['_method']);
        unset($posted['_token']);
        unset($posted['confirm_password']);

        $vendor->fill($posted)->save();

        if($vendor->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.designer')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('vendors.edit',$vendor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function delete(int $vendor_id)
    {
        $vendor = Vendor::whereId($vendor_id)->first();
        $vendor->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.designer')]));
        return redirect()->route('vendors.list');
    }

    function setFilters($request)
    {
        if(!empty($request['filter']))
            session(['filter_vendor'=>1]);

        if(!empty($request['name']))
            session(['filter_vendor_name'=>$request['name']]);
        else
            session()->forget('filter_vendor_name');

        if(!empty($request['email']))
            session(['filter_vendor_email'=>$request['email']]);
        else
            session()->forget('filter_vendor_email');

        if(!empty($request['phone']))
            session(['filter_vendor_phone'=>$request['phone']]);
        else
            session()->forget('filter_vendor_phone');

        if(!empty($request['order_by']))
            session(['filter_vendor_order_by'=>$request['order_by']]);
        else
            session()->forget('filter_vendor_order_by');

        if(!empty($request['limit']))
            session(['filter_vendor_limit'=>$request['limit']]);
        else
            session()->forget('filter_vendor_limit');

        if(!empty($request['clear_filters']))
            session()->forget(['filter_vendor_name', 'filter_vendor_email','filter_vendor_phone','filter_vendor_order_by','filter_vendor_limit','filter_vendor']);

    }

    public function checkVendorEmail(Request $request)
    {
        $check = Vendor::where('email',$request->email)->get()->count();
        if($check > 0)
            return 'false';
        return 'true';
    }

    public function export() 
    {
        return Excel::download(new vendorsExport, 'vendors.xlsx');
    }
}
