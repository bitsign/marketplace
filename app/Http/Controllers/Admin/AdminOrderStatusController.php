<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminOrderStatusController extends AdminBaseController
{
    public $data;

    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/statuses'        => __('admin.list_pages', ['name' => __('admin.statuses')]),
                'admin/statuses/create' => __('admin.create_page', ['name' => __('admin.status')]),
                );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.statuses');
        $this->data['statuses']   = Status::all();
        return view('admin.statuses.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title']   = __('admin.create_page', ['name' => __('admin.status')]);
        $this->data['edit']         = false;
        return view('admin.statuses.edit', $this->data);
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

        $posted['name']          = $request->name[app()->getLocale()];
        $posted['color']         = $request->color;
        $posted['translations']  = json_encode($request->name);

        $statuses = Status::create($posted);

        if($statuses->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.status')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.status')]));

        return redirect()->route('statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        $this->data['page_title']   = __('admin.status');
        $this->data['edit']         = true;
        $this->data['status']       = $status;
        $this->data['translations'] = json_decode($this->data['status']['translations'],true);
        return view('admin.statuses.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Status  $statuses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $request->validate([
            'name'    => 'required',
        ]);

        $posted['name']          = $request->name[app()->getLocale()];
        $posted['color']         = $request->color;
        $posted['translations']  = json_encode($request->name);

        $status->fill($posted)->save();

        if($status->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.status')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('statuses.edit',$status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Status  $statuses
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.status')]));
        return redirect()->route('statuses.index');
    }

    /**
     * Sort pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortStatus(Request $request)
    {
        $sort = Status::sortStatus($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.status')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}
