<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\BannerGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminBannerController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                    'admin/banners'         => __('admin.list_pages', ['name' => __('admin.banners')]),
                    'admin/banners/create'  => __('admin.create_page', ['name' => __('admin.banner')]),
                    );

        $this->data['scripts'][]    = "custom_banners.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] =  __('admin.banners');
        $this->data['banners'] = Banner::orderBy('sort')->get();
        return view('admin.banners.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['edit'] = false;
        $this->data['banner'] = [];
        $this->data['banner_groups'] = BannerGroup::all();
        $this->data['page_title'] =  __('admin.create_page', ['name' => __('admin.banner')]);
        return view('admin.banners.form',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posted = array();

        if(!empty($request->image))
        {
            $img_ = explode('editor/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";

        $posted['active']      = !empty($request->active) ? 1 : 0;
        $posted['author']      = session('AdminUser')['id'];
        $posted['title']       = $request->translations['title'][app()->getLocale()];

        $posted['translations'] = json_encode($request->translations);

        $banner = Banner::create($posted);

        if($banner->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.banner')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.banner')]));

        return redirect()->route('banners.show',$banner);
    }

    /**
     * Display the specified resource.
     *
     * @param  \int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['edit'] = true;
        $this->data['banner'] = Banner::whereId($id)->first();
        $this->data['translations'] = json_decode($this->data['banner']['translations'],true);
        $this->data['banner_groups'] = BannerGroup::all();
        $this->data['page_title'] =  __('admin.edit_page', ['name' => __('admin.banner')]);
        return view('admin.banners.form',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $posted = array();

        if(!empty($request->image))
        {
            $img_ = explode('editor/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";

        $posted['active']      = !empty($request->active) ? 1 : 0;
        $posted['author']      = session('AdminUser')['id'];
        $posted['title']       = $request->translations['title'][app()->getLocale()];

        $posted['translations'] = json_encode($request->translations);
        
        $banner->fill($posted)->save();

        if($banner->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.banner')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('banners.show',$banner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        alert('success',__('admin.msg_deleted', ['name' => __('admin.banner')]));

        return redirect()->route('banners.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function sortBanners(Request $request)
    {
        $sort = Banner::sortBanners($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.banners')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}
