<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailText;
use Illuminate\Http\Request;

class AdminEmailTextController extends AdminBaseController
{
    
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/email-texts'       =>'<i class="bi bi-list"></i> '.__('admin.list_pages', ['name' => __('admin.system_emails')]),
                'admin/email-texts/create'=>'<i class="bi bi-plus"></i> '.__('admin.create_page', ['name' => __('admin.system_email')])
                );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->data['page_title'] = __('admin.system_emails');

        $this->data['email_texts'] = EmailText::all();

        return view('admin.email_texts.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.system_email')]);
        return view('admin.email_texts.create', $this->data);
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

        $email_text = EmailText::create($posted);

        if($email_text->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.system_email')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.system_email')]));

        return redirect()->route('email-texts.edit',$email_text->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailText  $emailText
     * @return \Illuminate\Http\Response
     */
    public function show(EmailText $emailText)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailText  $emailText
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailText $emailText)
    {
        $this->data['emailText']  = $emailText;
        $this->data['page_title'] =  __('admin.edit_page', ['name' => __('admin.system_email')]);
        return view('admin.email_texts.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailText  $emailText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailText $emailText)
    {
        $posted = $request->all();
        unset($posted['_method']);
        unset($posted['_token']);

        $emailText->fill($posted)->save();

        if($emailText->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.system_email')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('email-texts.edit',$emailText->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailText  $emailText
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailText $emailText)
    {
        $emailText->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.system_email')]));
        return redirect()->route('email-texts.index');
    }
}
