<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoryTranslation;
use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Support\Facades\DB;

class AdminCategoryController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = __('admin.categories');
        $this->data['tabs'][]=Array(
                'admin/categories'         => __('admin.list_pages', ['name' => __('admin.categories')]),
                'admin/categories/create'  => __('admin.create_page', ['name' => __('admin.category')]),
                );
        $this->data['scripts'][]    = "custom_category.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.categories');
        $this->data['list_categories'] = Category::with('translation')->get()->toTree();
        return view('admin.categories.categories', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['edit'] = false;
        $this->data['parent']       = "";
        $this->data['categories']   = Category::with('translation')->select(['id','name'])->get();
        //$fields = Schema::getColumnListing('categories');
        $this->data['scripts'][]    = "../plugins/tinymce/tinymce.min.js";
        $this->data['scripts'][]    = "tinymce_settings.js";
        $this->data['category']     = [];
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.category')]);

        return view('admin.categories.category_form', $this->data);
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

        //kép mentése a legutolsó színtű könyvtár nevével
        if(!empty($request->image))
        {
            $img_ = explode('/',$request->image);
            $fldr = '';
            if($img_[count($img_)-1] != 'editor')
                $fldr = $img_[count($img_)-2].'/';
            $posted['image'] = $fldr.end($img_);
        }
        else
            $posted['image'] = "";

        $posted['name']          = $request->name[config('app.locale')];
        $posted['parent_id']     = !empty($request->parent_id) ? $request->parent_id : 1;
        $posted['active']        = !empty($request->active) ? 1 : 0;
        $posted['show_as_menu']  = !empty($request->show_as_menu) ? 1 : 0;
        $posted['discount']      = !empty($request->discount) ? $request->discount : 0;
        $posted['attributes']    = $request->attribs[0] !== NULL ? implode(',',$request->attribs) : '';

        $category = Category::create($posted);

        if($category->id != 0)
        {
            //mentjük a fordításokat
            foreach(config('app.available_locales') as $lang)
            {
                $translation['name']                = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';
                $translation['url']                 = create_unique_url('category_translations',Str::slug($request['name'][$lang]));
                $translation['short_description']   = !empty($request['short_description'][$lang]) ? $request['short_description'][$lang] : '';
                $translation['description']         = !empty($request['description'][$lang]) ? $request['description'][$lang] : '';
                $translation['meta_description']    = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
                $translation['meta_keywords']       = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
                $translation['meta_title']          = !empty($request['meta_title'][$lang]) ? $request['meta_title'][$lang] : '';
                $translation['lang']                = $lang;
                $translation['category_id']         = $category->id;

                $insert = CategoryTranslation::create($translation);
                if($insert->wasRecentlyCreated)
                    $rows++;
            }
            if($rows > 0)
                alert('success',__('admin.msg_created', ['name' => __('admin.category')]));
            else
                alert('danger',__('admin.msg_tr_not_created', ['name' => __('admin.category')]));
        }
        else
            alert('info',__('admin.msg_not_created', ['name' => __('admin.category')]));

        return redirect()->route('categories.edit',$category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $node = Category::with('translations')->whereId($id)->first();
        $translations = array();
        if(!empty($node->translations))
        {
            foreach ($node->translations as $key => $value)
            {
                $translations[$value['lang']] = $value;
            }
        }
        $this->data['translations'] = $translations;
        $this->data['siblings']     = $node->getSiblings();
        $this->data['parent']       = $node->parent_id;
        $this->data['image']        = Category::getCategoryImages($id);
        $this->data['categories']   = Category::with('translation')->select(['id','name'])->get();
        $this->data['edit']         = true;
        $this->data['scripts'][]    = "../plugins/tinymce/tinymce.min.js";
        $this->data['scripts'][]    = "tinymce_settings.js";
        $this->data['category']     = $node;
        $this->data['page_title']   = __('admin.edit_page', ['name' => __('admin.category')]);

        return view('admin.categories.category_form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rows = 0;
        $posted = array();

        //mentjük a fordításokat
        foreach(config('app.available_locales') as $lang)
        {
            if(!empty($request['translation_id'][$lang]))
                $translation_exists = CategoryTranslation::where('id', $request['translation_id'][$lang])->first();
            else
                $translation_exists = array();

            $translation['name'] = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';

            if((!empty($translation_exists) &&  $translation['name'] != $translation_exists->name) || empty($translation_exists))
                $translation['url'] = create_unique_url('category_translations',Str::slug($request['name'][$lang]));
            else
                $translation['url'] = $translation_exists->url;

            //alapértelmezett nyelven mentjük a nevet a categories táblába is
            if(config('app.locale') == $lang)
                $posted['name'] = $translation['name'];

            $translation['short_description'] = !empty($request['short_description'][$lang]) ? $request['short_description'][$lang] : '';
            $translation['description'] = !empty($request['description'][$lang]) ? $request['description'][$lang] : '';
            $translation['meta_description'] = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
            $translation['meta_keywords'] = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
            $translation['meta_title'] = !empty($request['meta_title'][$lang]) ? $request['meta_title'][$lang] : '';
            $translation['lang'] = $lang;
            $translation['category_id'] = $category->id;

            if(!empty($request['translation_id'][$lang]))
            {
                $update = CategoryTranslation::where('id', $request['translation_id'][$lang])->update($translation);
                if($update > 0)
                    $rows++;
            }
            else
            {
                $insert = CategoryTranslation::create($translation);
                if($insert->wasRecentlyCreated)
                    $rows++;
            }
        }

        //kategória fa beállítása
        if($category->parent_id != $request->parent_id)
        {
            if($request->parent_id != 0)
            {
                $category->parent_id = $request->parent_id;
                $category->save();
            }

            //Category::fixTree();
        }

        //kategória sorrendezése
        if($request->sibling_category != 0 && $request->sibling_category != $category->id && !empty($request->category_position))
        {
            $neighbor = Category::whereId($request->sibling_category)->first();
            switch($request->category_position)
            {
                case 'before':
                    $category->insertBeforeNode($neighbor);
                    break;

                default:
                    $category->insertAfterNode($neighbor);
                    break;
            }
        }
        //kép mentése a legutolsó színtű könyvtár nevével
        if(!empty($request->image))
        {
            $img_ = explode('/',$request->image);
            $fldr = '';
            if($img_[count($img_)-1] != 'editor')
                $fldr = $img_[count($img_)-2].'/';
            $posted['image'] = $fldr.end($img_);
        }
        else
            $posted['image'] = "";


        //$posted['parent_id']     = !empty($request->parent_id) ? $request->parent_id : 1;
        $posted['active']        = !empty($request->active) ? 1 : 0;
        $posted['show_as_menu']  = !empty($request->show_as_menu) ? 1 : 0;
        $posted['discount']      = !empty($request->discount) ? $request->discount : 0;
        $posted['attributes']    = !empty($request['attribs']) ? implode(',',array_filter($request['attribs'])) : '';

        $category->fill($posted)->save();

        if($category->wasChanged() || $rows > 0)
             alert('success',__('admin.msg_updated', ['name' => __('admin.category')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('categories.edit',$category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        DB::table('category_translations')->where('category_id', $category->id)->delete();

        DB::table('category_images')->where('cid', $category->id)->delete();
        
        $category->delete();

        alert('success',__('admin.msg_deleted', ['name' => __('admin.category')]));

        return redirect()->route('categories.index');
    }
}
