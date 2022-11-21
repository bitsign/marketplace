<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminTeamController extends AdminBaseController
{
    public $data;

    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/team'        => __('admin.list_pages', ['name' => __('admin.staff')]),
                'admin/team/create' => __('admin.create_page', ['name' => __('admin.member')]),
                );
        $this->data['scripts'][]    = "custom_team.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.staff');
        $this->data['teams']     = Team::orderBy('sort')->get();
        return view('admin.team.team', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title']   = __('admin.create_page', ['name' => __('admin.member')]);
        $this->data['edit']         = false;
        return view('admin.team.team_form', $this->data);
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

        $posted = array();
        if(!empty($request->image))
        {
            $img_ = explode('editor/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";
        $posted['active']        = !empty($request->active) ? 1 : 0;
        $posted['name']          = $request->name;
        $posted['occupation']    = $request->translations['occupation'][app()->getLocale()];
        $posted['intro']         = $request->translations['intro'][app()->getLocale()];
        $posted['translations']  = json_encode($request->translations);

        $team = Team::create($posted);

        if($team->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.member')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.member')]));

        return redirect()->route('team.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $this->data['page_title']   = __('admin.member');
        $this->data['edit']         = true;
        $this->data['team']         = Team::whereId($id)->first();
        $this->data['translations'] = json_decode($this->data['team']['translations'],true);
        return view('admin.team.team_form', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Team  $Team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $Team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $posted = array();
        if(!empty($request->image))
        {
            $img_ = explode('editor/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";
        $posted['active']        = !empty($request->active) ? 1 : 0;
        $posted['name']          = $request->name;
        $posted['occupation']    = $request->translations['occupation'][app()->getLocale()];
        $posted['intro']         = $request->translations['intro'][app()->getLocale()];
        $posted['translations']  = json_encode($request->translations);

        $team->fill($posted)->save();

        if($team->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.member')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('team.show',$team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.member')]));
        return redirect()->route('team.index');
    }

    /**
     * Sort pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortTeam(Request $request)
    {
        $sort = Team::sortTeam($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.staff')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}
