<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/settings'       =>'<i class="bi bi-list"></i> '.__('admin.list_pages', ['name' => __('admin.settings')]),
                'admin/settings/create'=>'<i class="bi bi-plus"></i> '.__('admin.create_page', ['name' => __('admin.setting')])
                );
        $this->data['css'][]         = "../plugins/datatables/datatables.min.css";
        $this->data['scripts'][]     = "../plugins/datatables/datatables.min.js";
        $this->data['scripts'][]    = "custom_settings.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->data['page_title'] = __('admin.settings');

        $this->data['settings'] = Setting::all();

        return view('admin.settings.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.setting')]);
        return view('admin.settings.create', $this->data);
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
        unset($posted['_method']);
        unset($posted['_token']);

        $setting = Setting::create($posted);

        if($setting->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.setting')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.setting')]));

        return redirect()->route('settings.edit',$setting->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        $this->data['setting']  = $setting;
        $this->data['page_title'] =  __('admin.edit_page', ['name' => __('admin.setting')]);
        return view('admin.settings.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $posted = $request->all();
        unset($posted['_method']);
        unset($posted['_token']);

        $setting->fill($posted)->save();

        if($setting->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.setting')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('settings.edit',$setting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.setting')]));
        return redirect()->route('settings.index');
    }
}
