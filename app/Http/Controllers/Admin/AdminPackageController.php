<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Package;
use Illuminate\Http\Request;

class AdminPackageController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/packages'       =>'<i class="bi bi-list"></i> '.__('admin.list_pages', ['name' => __('admin.packages')]),
                'admin/packages/create'=>'<i class="bi bi-plus"></i> '.__('admin.create_page', ['name' => __('admin.package')])
                );
        $this->data['scripts'][]    = "packages.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->data['page_title'] = __('admin.packages');

        $this->data['packages'] = Package::orderBy('sort','asc')->get();

        return view('admin.packages.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.package')]);
        return view('admin.packages.create', $this->data);
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

        $package = Package::create($posted);

        if($package->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.package')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.package')]));

        return redirect()->route('packages.edit',$package->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $this->data['package']  = $package;
        $this->data['page_title'] =  __('admin.edit_page', ['name' => __('admin.package')]);
        return view('admin.packages.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $posted = $request->all();
        unset($posted['_method']);
        unset($posted['_token']);

        $package->fill($posted)->save();

        if($package->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.package')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('packages.edit',$package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.package')]));
        return redirect()->route('packages.index');
    }

    /**
     * Sort packages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortPackages(Request $request)
    {
        $sort = Package::sortPackages($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.packages')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}
