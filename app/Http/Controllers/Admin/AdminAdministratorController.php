<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAdministratorController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/administrators'       =>'<i class="bi bi-list"></i> '.__('admin.list_pages', ['name' => __('admin.administrators')]),
                'admin/administrators/create'=>'<i class="bi bi-plus"></i> '.__('admin.create_page', ['name' => __('admin.administrator')])
                );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->data['page_title'] = __('admin.administrators');

        $this->data['administrators'] = Admin::all();

        return view('admin.administrators.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.administrator')]);
        return view('admin.administrators.create', $this->data);
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

        $posted['password'] = Hash::make($request->password);

        $administrator = Admin::create($posted);

        if($administrator->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.administrator')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.administrator')]));

        return redirect()->route('administrators.edit',$administrator->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $administrator)
    {
        $this->data['administrator']  = $administrator;
        $this->data['page_title'] =  __('admin.edit_page', ['name' => __('admin.administrator')]);
        return view('admin.administrators.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $administrator)
    {
        $posted = $request->all();
        unset($posted['_method']);
        unset($posted['_token']);

        if($posted['password'] !== NULL)
            $posted['password'] = Hash::make($request->password);
        else
            unset($posted['password']);

        $administrator->fill($posted)->save();

        if($administrator->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.administrator')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('administrators.edit',$administrator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $administrator)
    {
        $administrator->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.administrator')]));
        return redirect()->route('administrators.index');
    }
}
