<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\PageType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PageTranslation;
use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Support\Facades\Auth;

class AdminPageController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/pages'          =>__('admin.list_pages', ['name' => __('admin.pages')]),
                'admin/pages/create'   =>__('admin.create_page', ['name' => __('admin.page')])
                );
        $this->data['scripts'][]    = "custom_page.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->get('AdminUser')->group_id == 0)
            $this->data['tabs'][]['admin/pages/page-types/view/0']=__('admin.page_types');

        $this->data['page_title'] = __('admin.pages');

        $this->data['pages'] = Page::getPages();

        return view('admin.pages.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['edit'] = false;
        $pages = Page::getPages();
        $pages_dd = array();
        foreach ($pages as $page) {
            $pages_dd[$page->id] = $page->name;
        }
        $this->data['pages_dd'] = $pages_dd;
        $this->data['pages_types'] = PageType::all();
        $this->data['page'] = array();
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.page')]);
        return view('admin.pages.create', $this->data);
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
        $posted = array();

        if(!empty($request->image))
        {
            $img_ = explode('/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";

        $posted['parent_id']     = !empty($request->parent_id) ? $request->parent_id : 0;
        $posted['type']          = !empty($request->type) ? $request->type : 'page';
        $posted['author']        = session('AdminUser')['id'];
        $posted['active']        = !empty($request->active) ? 1 : 0;
        $posted['menu']          = !empty($request->menu) ? 1 : 0;
        $posted['footmenu']      = !empty($request->footmenu) ? 1 : 0;
        $posted['contact_form']  = !empty($request->contact_form) ? 1 : 0;
        $posted['front_page']    = !empty($request->front_page) ? 1 : 0;

        $page = Page::create($posted);

        if($page->wasRecentlyCreated)
        {
            foreach(config('app.available_locales') as $lang)
            {
                $translation['name']                = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';
                $translation['url']                 = create_unique_url('page_translations',Str::slug($request['name'][$lang]));
                $translation['content']             = !empty($request['content'][$lang]) ? $request['content'][$lang] : '';
                $translation['meta_description']    = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
                $translation['meta_keywords']       = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
                $translation['menu_title']          = !empty($request['menu_title'][$lang]) ? $request['menu_title'][$lang] : '';
                $translation['lang']                = $lang;
                $translation['page_id']             = $page->id;

                $insert = PageTranslation::create($translation);

                if($insert->wasRecentlyCreated)
                    $rows++;
            }
            alert('success',__('admin.msg_created', ['name' => __('admin.page')]));
        }
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.page')]));

        return redirect()->route('pages.edit',$page);
    }

   /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->data['edit'] = true;
        $this->data['page'] = Page::with('translations')->whereId($id)->first();
        $translations = array();
        if(!empty($this->data['page']->translations))
        {
            foreach ($this->data['page']->translations as $key => $value)
            {
                $translations[$value['lang']] = $value;
            }
        }
        $this->data['translations'] = $translations;

        $pages = Page::getPages();
        $pages_dd = array();
        foreach ($pages as $page)
        {
            $pages_dd[$page->id] = $page->name;
        }
        $this->data['pages_dd'] = $pages_dd;

        $this->data['pages_types'] = PageType::all();

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.page')]);

        return view('admin.pages.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Pages  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $rows = 0;
        foreach(config('app.available_locales') as $lang)
        {
            if(!empty($request['translation_id'][$lang]))
                $translation_exists = PageTranslation::where('id', $request['translation_id'][$lang])->first();
            else
                $translation_exists = array();

            $translation['name'] = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';

            if((!empty($translation_exists) &&  $translation['name'] != $translation_exists->name) || empty($translation_exists))
                $translation['url'] = create_unique_url('page_translations',Str::slug($request['name'][$lang]));
            else
                $translation['url'] = $translation_exists->url;

            $translation['content']          = !empty($request['content'][$lang]) ? $request['content'][$lang] : '';
            $translation['meta_description'] = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
            $translation['meta_keywords']    = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
            $translation['menu_title']       = !empty($request['menu_title'][$lang]) ? $request['menu_title'][$lang] : '';
            $translation['lang']             = $lang;
            $translation['page_id']          = $page->id;

            if(!empty($request['translation_id'][$lang]))
            {
                $update = PageTranslation::where('id', $request['translation_id'][$lang])->update($translation);
                if($update > 0)
                    $rows++;
            }
            else
            {
                $insert = PageTranslation::create($translation);
                if($insert->wasRecentlyCreated)
                    $rows++;
            }
        }

        $posted = array();
        if(!empty($request->image))
        {
            $img_ = explode('/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";
        $posted['parent_id']     = !empty($request->parent_id) ? $request->parent_id : 0;
        $posted['type']          = !empty($request->type) ? $request->type : 'page';
        $posted['author']        = session('AdminUser')['id'];
        $posted['active']        = !empty($request->active) ? 1 : 0;
        $posted['menu']          = !empty($request->menu) ? 1 : 0;
        $posted['footmenu']      = !empty($request->footmenu) ? 1 : 0;
        $posted['contact_form']  = !empty($request->contact_form) ? 1 : 0;
        $posted['front_page']    = !empty($request->front_page) ? 1 : 0;

        $page->fill($posted)->save();

        if($page->wasChanged())
            $rows++;

        if($rows > 0)
            alert('success',__('admin.msg_updated', ['name' => __('admin.page')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('pages.edit',$page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Pages  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page,PageTranslation $page_translation)
    {
        $page_translation->wherePageId($page->id)->delete();
        $page->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.page')]));
        return redirect()->route('pages.index');
    }

    /**
     * Sort pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortPages(Request $request)
    {
        $sort = Page::sortPages($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.pages')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }

    /**
     * PageTypes
     *
     * @param  string $event
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\PageType  $page_type
     * @return int
     */
    function pageTypes($event = 'list', $id = 0,Request $request,PageType $page_type)
    {
        $this->data['edit'] = false;

        if($event == 'delete' && $id != 0)
        {
            $page_type->find($id)->delete();
            alert('alert alert-success','Tartalom típus törölve');
            return redirect()->to(url('admin/pages/page-types/view/0'));
        }

        if($event == 'update' && $id != 0)
        {
            $posted = $request->all();
            unset($posted['_token']);
            unset($posted['_method']);

            $page_type->where('id', $id)->update($posted);

            alert('alert alert-success','Tartalom típus módosítva');

            return redirect()->to(url('admin/pages/page-types/view/0'));
        }

        if($event == 'add' && $id == 0)
        {
            $posted = $request->all();
            unset($posted['_token']);
            $add = PageType::create($posted);
            if($add->wasRecentlyCreated)
                alert('alert alert-success','Tartalom típus létrehozva');
            else
                alert('alert alert-danger','Hiba! Tartalom típus nincs létrehozva');
            return redirect()->to(url('admin/pages/page-types/view/0'));
        }

        if($id != 0)
        {
            $this->data['edit'] = true;
            $this->data['page_type'] = $page_type->where('id',$id)->first();
        }
        else
        {
            $this->data['page_type'] = array();
        }

        $this->data['page_title'] = __('admin.page_types');
        $this->data['page_types'] = $page_type->all();

        return view('admin.pages.page-types', $this->data);

    }
}
