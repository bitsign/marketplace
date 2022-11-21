<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Page;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    /**
     * Display packages
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page']     = Page::getPageByType('offer');
        $data['packages'] = Package::all();
        if (Auth::guard('vendor')->check())
        {
            $vendor = Auth::guard('vendor')->user();
            $data['subscription'] = Subscription::whereVendor_id($vendor->id)->first();
        }
        else
            $data['subscription'] = array();
        return view('packages.index', $data);
    }

     /**
     * Display service by url.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($url, Request $request)
    {
        $package = Package::whereUrl($url)->first();
        if($package === NULL)
            abort(404);
        if (Auth::guard('vendor')->check())
        {
            $vendor = Auth::guard('vendor')->user();
            $data['intent'] = $vendor->createSetupIntent();
            $data['subscription'] = Subscription::whereVendor_id($vendor->id)->first();
        }
        else
        {
            $data['subscription'] = array();
            alert('info',__('login_needed'));
            return redirect()->route('vendor.login-register');
        }
        $data['page']               = Page::getPageByType('offer');
        $data['package']            = $package;
        $data['breadcrumbs'][]      = ['url' => app()->getLocale().'/'.__('routes.offer'),'title'=>__('offer')];
        $data['breadcrumbs'][]      = ['title' => $data['package']['name']];
        $data['meta_title']         = !empty($data['package']['meta_title']) ? $data['package']['meta_title'] : $data['package']['name'];
        $data['meta_description']   = $data['package']['meta_description'];
        $data['meta_keywords']      = $data['package']['meta_keywords'];
        return view('packages.subscription', $data);
    }

    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\Response
     */
    public function subscription(Request $request)
    {
        $package = Package::find($request->package);
  
        $subscription = $request->user('vendor')->newSubscription($package->name, $package->stripe_plan)->create($request->token);
  
        return view("packages.subscription_success");
    }
}