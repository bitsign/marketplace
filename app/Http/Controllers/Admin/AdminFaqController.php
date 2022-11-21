<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminFaqController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/faqs'        => __('admin.list_pages', ['name' => __('admin.faq')]),
                'admin/faqs/create' => __('admin.create_page', ['name' => __('admin.faq')]),
                );
        $this->data['scripts'][]    = "custom_faq.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.faq');
        $this->data['faqs'] = Faq::orderBy('sort')->get();
        return view('admin.faqs.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['edit'] = false;
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.faq')]);
        return view('admin.faqs.form', $this->data);
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
        $posted['name']    = $request->translations['name'][app()->getLocale()];
        $posted['content']   = $request->translations['content'][app()->getLocale()];
        $posted['translations'] = json_encode($request->translations);
        $faq = Faq::create($posted);

        if($faq->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.faq')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.faq')]));

        return redirect()->route('faqs.show',$faq);
    }

   /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $this->data['edit'] = true;
        $this->data['faq']  = Faq::whereId($id)->first();
        $this->data['translations'] = json_decode($this->data['faq']['translations'],true);
        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.faq')]);
        return view('admin.faqs.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\TeamModel  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $posted = array();
        $posted['name']    = $request->translations['name'][app()->getLocale()];
        $posted['content']   = $request->translations['content'][app()->getLocale()];
        $posted['translations'] = json_encode($request->translations);

        $faq->fill($posted)->save();

        if($faq->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.faq')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('faqs.show',$faq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\TeamModel  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.faq')]));
        return redirect()->route('faqs.index');
    }

    /**
     * Sort pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortFaqs(Request $request)
    {
        $sort = Faq::sortFaqs($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.faq')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}
