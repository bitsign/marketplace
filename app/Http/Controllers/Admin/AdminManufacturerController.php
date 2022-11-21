<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Support\Str;

class AdminManufacturerController extends AdminBaseController
{
    public $data;

    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/manufacturers'        => __('admin.list_pages', ['name' => __('admin.manufacturers')]),
                'admin/manufacturers/create' => __('admin.create_page', ['name' => __('admin.manufacturer')]),
                );
        $this->data['css'][]        = "../plugins/datatables/datatables.min.css";
        $this->data['scripts'][]    = "../plugins/datatables/datatables.min.js";
        $this->data['scripts'][]    = "custom_manufacturers.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.list_pages', ['name' => __('admin.manufacturers')]);
        $this->data['manufacturers'] = Manufacturer::all();
        return view('admin.manufacturers.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title']   = __('admin.create_page', ['name' => __('admin.manufacturer')]);
        $this->data['edit']         = false;
        return view('admin.manufacturers.edit', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required',
        ]);

        $posted = $request->all();
        $posted['url'] = create_unique_url('manufacturers',Str::slug($posted['name']));
        if(!empty($request->image))
        {
            $img_ = explode('/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";
        $posted['active']        = !empty($request->active) ? 1 : 0;
        unset($posted['_method']);
        unset($posted['_token']);

        $manufacturer = Manufacturer::create($posted);

        if($manufacturer->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.manufacturer')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.manufacturer')]));

        return redirect()->route('manufacturers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function edit(Manufacturer $manufacturer)
    {
        $this->data['page_title']   = __('admin.manufacturer');
        $this->data['edit']         = true;
        $this->data['manufacturer'] = $manufacturer;
        return view('admin.manufacturers.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        $posted = $request->all();
        $posted['url'] = create_unique_url('manufacturers',Str::slug($posted['name']),$manufacturer->id);
        if(!empty($request->image))
        {
            $img_ = explode('/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";
        $posted['active']        = !empty($request->active) ? 1 : 0;
        unset($posted['_method']);
        unset($posted['_token']);

        $manufacturer->fill($posted)->save();

        if($manufacturer->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.manufacturer')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('manufacturers.edit',$manufacturer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.manufacturer')]));
        return redirect()->route('manufacturers.index');
    }
}
