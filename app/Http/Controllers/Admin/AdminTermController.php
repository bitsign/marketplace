<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Support\Str;

class AdminTermController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                    'admin/terms'         => __('admin.list_pages', ['name' => __('admin.terms')]),
                    'admin/terms/create'  => __('admin.create_page', ['name' => __('admin.terms')]),
                    );

        $this->data['scripts'][]    = "custom_terms.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] =  __('admin.terms');
        $this->data['terms'] = Term::whereLang(config('app.admin_locale'))->get();

        return view('admin.terms.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['edit'] = false;
        $this->data['term'] = [];
        $this->data['page_title'] =  __('admin.create_page', ['name' => __('admin.term')]);
        return view('admin.terms.form',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rows = 0;
        foreach(config('app.available_locales') as $lang)
        {
            $term_data['name']      = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';
            $term_data['url']       = create_unique_url('terms',Str::slug($request['name'][$lang]));
            $term_data['term_key']  = Str::slug($request['name']['en']);
            $term_data['lang']      = $lang;

            $term = Term::create($term_data);

            if($term->id > 0)
                $rows++;
        }

        if($rows > 0)
            alert('success',__('admin.msg_created', ['name' => __('admin.term')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.term')]));

        return redirect()->route('terms.show',$term);
    }

    /**
     * Display the specified resource.
     *
     * @param  \int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['edit']  = true;
        $this->data['term']  = Term::whereId($id)->first();
        $terms = Term::whereTerm_key($this->data['term']['term_key'])->get();
        $terms_array = array();
        foreach($terms as $term)
        {
            $terms_array[$term['lang']] = $term;
        }

        $this->data['terms'] = $terms_array;
        $this->data['page_title'] =  __('admin.edit_page', ['name' => __('admin.term')]);
        return view('admin.terms.form',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Term $term)
    {
        $rows = 0;
        foreach(config('app.available_locales') as $lang)
        {
            if(!empty($request['id'][$lang]))
                $term_exists = Term::where('id', $request['id'][$lang])->first();

            $term_data['name'] = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';

            if((!empty($term_exists) &&  $term_data['name'] != $term_exists->name) || empty($term_exists))
                $term_data['url'] = create_unique_url('terms',Str::slug($request['name'][$lang]), $request['id'][$lang]);
            else
                $term_data['url'] = $term_exists->url;

            $term_data['term_key'] = $request['name']['en'];
            $term_data['lang'] = $lang;

            $update = Term::where('id', $request['id'][$lang])->update($term_data);

            if($update > 0)
                $rows++;
        }

        if($rows > 0)
            alert('success',__('admin.msg_updated', ['name' => __('admin.term')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('terms.show',$term);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        $term_exists = Term::where('id', $term->id)->first();

        $term->whereTerm_key($term_exists->term_key)->delete();

        alert('success',__('admin.msg_deleted', ['name' => __('admin.term')]));

        return redirect()->route('terms.index');
    }
}
