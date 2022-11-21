<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                    'admin/users'         => __('admin.list_pages', ['name' => __('admin.users')]),
                    'admin/users/create'  => __('admin.create_page', ['name' => __('admin.user')]),
                    );

        $this->data['scripts'][]    = "custom_users.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('users.list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function usersList(Request $request,User $user)
    {
        //dd($request);
        if(!empty($request))
            $this->setFilters($request);

        //DB::enableQueryLog();
        $this->data['users'] = User::filter($request)->paginate(50);
        //dd(DB::getQueryLog());

        //appends pagination link
        $url = $request->fullUrl();
        if(!empty(parse_url($url)['query']))
        {
            parse_str(parse_url($url)['query'], $get_array);
            $this->data['users']->appends($get_array);
        }

        $this->data['page_title'] =  __('admin.users');

        return view('admin.users.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] =  __('admin.create_page', ['name' => __('admin.user')]);
        return view('admin.users.create',$this->data);
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
                return redirect()->route('users.create',$user);
            }
        }
        else
        {
            alert('danger',__('Password field is required'));
            return redirect()->route('users.create',$user);
        }
        unset($posted['_method']);
        unset($posted['_token']);
        unset($posted['confirm_password']);

        $user = User::create($posted);

        if($user->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.user')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.user')]));

        return redirect()->route('users.edit',$user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->data['user'] = $user;

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.user')]).' - '.$user->name;

        return view('admin.users.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
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

        $user->fill($posted)->save();

        if($user->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.user')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('users.edit',$user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete(int $user_id)
    {
        $user = User::whereId($user_id)->first();
        $user->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.user')]));
        return redirect()->route('users.list');
    }

    function setFilters($request)
    {
        if(!empty($request['filter']))
            session(['filter_user'=>1]);

        if(!empty($request['name']))
            session(['filter_user_name'=>$request['name']]);
        else
            session()->forget('filter_user_name');

        if(!empty($request['email']))
            session(['filter_user_email'=>$request['email']]);
        else
            session()->forget('filter_user_email');

        if(!empty($request['phone']))
            session(['filter_user_phone'=>$request['phone']]);
        else
            session()->forget('filter_user_phone');

        if(!empty($request['order_by']))
            session(['filter_user_order_by'=>$request['order_by']]);
        else
            session()->forget('filter_user_order_by');

        if(!empty($request['limit']))
            session(['filter_user_limit'=>$request['limit']]);
        else
            session()->forget('filter_user_limit');

        if(!empty($request['clear_filters']))
            session()->forget(['filter_user_name', 'filter_user_email','filter_user_phone','filter_user_order_by','filter_user_limit','filter_user']);

    }

    public function checkUserEmail(Request $request)
    {
        $check = User::where('email',$request->email)->get()->count();
        if($check > 0)
            return 'false';
        return 'true';
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
