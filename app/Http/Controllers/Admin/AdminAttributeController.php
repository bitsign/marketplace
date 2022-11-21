<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Attribute;
use App\Models\AttributeTranslation;
use App\Models\AttributeOption;
use App\Models\AttributeOptionTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminAttributeController extends AdminBaseController
{
    function __construct()
    {
        parent::__construct();
        $this->data['css'][]         = "jquery-ui.min.css";
        $this->data['scripts'][]     = "jquery.blockUI.js";
        $this->data['css'][]         = "../plugins/datatables/datatables.min.css";
        $this->data['scripts'][]     = "../plugins/datatables/datatables.min.js";
        $this->data['scripts'][]     = "custom_attributes.js?v=".time();
        $this->data['tabs'][]=Array(
                'admin/attributes'         =>'<i class="bi bi-list"></i> '.__('admin.list_pages', ['name' => __('admin.attributes')]),
                'admin/attributes/create'  =>'<i class="bi bi-plus"></i> '.__('admin.create_page', ['name' => __('admin.attribute')]),
                );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.attributes');
        $this->data['attributes'] = Attribute::tree();
        return view('admin.attributes.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.attribute')]);
        $this->data['edit'] = false;
        return view('admin.attributes.form', $this->data);
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
        $posted['url'] = create_unique_url('attributes',Str::slug($request->name[app()->getLocale()]));

        if(!empty($request->image))
        {
            $img_ = explode('/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";

        $posted['name']         = $request['name'][app()->getLocale()];
        $posted['is_filter']    = !empty($request->is_filter) ? 1 : 0;
        $posted['is_hidden']    = !empty($request->is_hidden) ? 1 : 0;
        $posted['is_multiple']  = !empty($request->is_multiple) ? 1 : 0;
        $posted['parent_id']    = !empty($request->parent_id) ? $request->parent_id : 0;
        unset($posted['_method']);
        unset($posted['_token']);

        $attribute = Attribute::create($posted);

        if($attribute->wasRecentlyCreated)
        {
            foreach(config('app.available_locales') as $lang)
            {
                $translation['name']           = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';
                $translation['url']            = create_unique_url('page_translations',Str::slug($request['name'][$lang]));
                $translation['lang']           = $lang;
                $translation['attribute_id']   = $attribute->id;

                $insert = AttributeTranslation::create($translation);
            }
            alert('success',__('admin.msg_created', ['name' => __('admin.attribute')]));
        }
        else
             alert('danger',__('admin.msg_not_created', ['name' => __('admin.attribute')]));

        return redirect()->route('attributes.edit',$attribute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Attribute  $Attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->data['edit'] = true;
        $this->data['option_values']    = AttributeOption::whereAttribute_id($id)->with('translations')->orderBy('sort','asc')->get();
        $this->data['attribute']        = Attribute::with('translations')->whereId($id)->first();

        $translations = array();
        if(!empty($this->data['attribute']->translations))
        {
            foreach ($this->data['attribute']->translations as $key => $value)
            {
                $translations[$value['lang']] = $value;
            }
        }
        $this->data['translations'] = $translations;

        $opt_translations = array();

        if(!empty($this->data['option_values']))
        {
            foreach ($this->data['option_values'] as $option_value)
            {
                if(!empty($option_value->translations))
                {
                    foreach ($option_value->translations as $key => $value)
                    {
                        $opt_translations[$value['attribute_option_id']][$value['lang']] = $value;
                    }
                }
            }
        }
        $this->data['opt_translations'] = $opt_translations;
        
        $this->data['page_title']       = __('admin.edit_page', ['name' => __('admin.attribute')]);
        return view('admin.attributes.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Attribute  $Attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $rows = 0;
        foreach(config('app.available_locales') as $lang)
        {
            if(!empty($request['translation_id'][$lang]))
                $translation_exists = AttributeTranslation::where('id', $request['translation_id'][$lang])->first();
            else
                $translation_exists = array();

            $translation['name'] = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';

            if((!empty($translation_exists) &&  $translation['name'] != $translation_exists->name) || empty($translation_exists))
                $translation['url'] = create_unique_url('attribute_translations',Str::slug($request['name'][$lang]));
            else
                $translation['url'] = $translation_exists->url;
            $translation['lang'] = $lang;
            $translation['attribute_id'] = $attribute->id;

            if(!empty($request['translation_id'][$lang]))
            {
                $update = AttributeTranslation::where('id', $request['translation_id'][$lang])->update($translation);
                if($update > 0)
                    $rows++;
            }
            else
            {
                $insert = AttributeTranslation::create($translation);
                if($insert->wasRecentlyCreated)
                    $rows++;
            }
        }

        $posted = array();

        $posted['name']         = $request['name'][app()->getLocale()];
        $posted['url']          = create_unique_url('attribute_translations',Str::slug($request['name'][app()->getLocale()]),$attribute->id);
        $posted['image']        = $request['image'] ?? "";
        $posted['sort']         = $request['sort'] ?? 0;
        $posted['parent_id']    = !empty($request->parent_id) ? $request->parent_id : 0;
        $posted['is_filter']    = !empty($request->is_filter) ? 1 : 0;
        $posted['is_hidden']    = !empty($request->is_hidden) ? 1 : 0;
        $posted['is_multiple']  = !empty($request->is_multiple) ? 1 : 0;

        $attribute->fill($posted)->save();

        if($attribute->wasChanged() || $rows > 0)
            alert('success',__('admin.msg_updated', ['name' => __('admin.attribute')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('attributes.edit',$attribute->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Attribute  $attributeModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $children = Attribute::whereParent_id($attribute->id)->get();
        if(!empty($children))
        {
            foreach($children as $child)
            {
                Attribute::where('id', $child->id)->update(['parent_id'=>0]);
            }
        }
        AttributeTranslation::where('attribute_id',$attribute->id)->delete();
        Attribute::deleteOptionValues($attribute->id);
        $attribute->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.attribute')]));
        return redirect()->route('attributes.index');
    }

    /**
     * Sort attributes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortAttributes(Request $request)
    {
        $sort = Attribute::sortAttributes($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.attributes')]));
            echo "1";
        }
        else
        {
            alert('danger',__('admin.msg_no_change'));
            echo "0";
        }
    }

    /**
     * Sort values.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortValues(Request $request)
    {
        $sort = Attribute::sortValues($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.attribute_values')]));
            echo "1";
        }
        else
        {
            alert('danger',__('admin.msg_no_change'));
            echo "0";
        }
    }

    function updateValues(int $attribute_id, Request $request)
    {
       $save = Attribute::addOptionValues($attribute_id,$request->all());
       if($save > 0)
            alert('success',__('admin.msg_updated', ['name' => __('admin.attribute_values')]));
        else
            alert('danger',__('admin.msg_no_change'));
        return redirect()->route('attributes.edit',$attribute_id);
    }

    function deleteValue(int $id)
    {
        $delete = Attribute::deleteOptionValue($id);
        if($delete > 0)
            echo __('admin.msg_deleted', ['name' => __('admin.attribute_value')]);
        else
            echo __('admin.msg_no_change');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    function getAttributeValues(Request $request)
    {
        $str = $request->query("term");

        $data['response'] = 'false';

        $options = Attribute::getOptionsLike($str);

        if(count($options) > 0)
        {
            $data['message'] = array();

            foreach($options as $option)
            {
                $data['message'][] = array(
                    'label' => $option->name,
                    'value' => $option->name,
                    'id'    => $option->id,
                );
            }

            $data['response'] = 'true';
        }
        return response()->json($data);
    }
}
