<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Exports\ProductTranslationsExport;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Imports\ProductTranslationImport;
use App\Imports\ProductsImport;
use App\Models\AttachedProduct;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminProductController extends AdminBaseController
{
    public $data;

    function __construct()
    {
        parent::__construct();
        $this->data['css'][]        = "../plugins/datepicker/datepicker3.css";
        $this->data['scripts'][]    = "../plugins/datepicker/bootstrap-datepicker.js";
        if(app()->getLocale() != 'en')
            $this->data['scripts'][] = "../plugins/datepicker/locales/bootstrap-datepicker.".app()->getLocale().".js";
        $this->data['scripts'][]    = "jquery.blockUI.js";
        $this->data['css'][]        = "custom_product.css";
        $this->data['scripts'][]    = "https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js";
        $this->data['scripts'][]    = "products.js?v=".time();
        $this->data['tabs'][]=Array(
                'admin/products'                =>'<i class="bi bi-list"></i> '.__('admin.list_pages', ['name' => __('admin.products')]),
                'admin/products/create'         =>'<i class="bi bi-plus-square"></i> '.__('admin.create_page', ['name' => __('admin.product')]),
                'admin/products-import-view'    =>'<i class="bi bi-box-arrow-in-right"></i> '.__('admin.product_import'),
                //'admin/products/product-sort'   =>'<i class="bi bi-hand-pointer-o"></i> '.__('admin.product_sort'),
                //'admin/products/settings'       =>'<i class="bi bi-gears"></i> '.__('admin.settings'),
                );
        //$this->data['categories'] = Category::with('translation')->get()->toTree();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Product $product)
    {
        if(!empty($request))
            $this->setFilters($request);

        //DB::enableQueryLog();
        $this->data['products'] = Product::filter($request)->paginate(50);
        //dd(DB::getQueryLog());

        //appends pagination link
        $url = $request->fullUrl();
        if(!empty(parse_url($url)['query']))
        {
            parse_str(parse_url($url)['query'], $get_array);
            $this->data['products']->appends($get_array);
        }

        $this->data['page_title'] = __('admin.products');

        return view('admin.products.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.product')]);
        $this->data['units'] = Unit::all();
        return view('admin.products.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $defaults = $this->setDefautFields($request->all());
        
        $product = Product::create($defaults);

        $product->categories()->attach($request->categories);

        foreach(config('app.available_locales') as $lang)
        {
            $translation = $this->setTranslationFields($request->all(),$lang,$product->id);
            ProductTranslation::create($translation);
        }

        if($product->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.product')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.product')]));

        return redirect()->route('products.edit',$product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $product = Product::with('translations')->whereId($id)->first();
        if($product === NULL)
        {
            alert('danger',__('no_product'));
            return redirect()->route('products.index');
        }
        $translations = array();
        if(!empty($product->translations))
        {
            foreach ($product->translations as $key => $value)
            {
                $translations[$value['lang']] = $value;
            }
        }
        $this->data['units']               = Unit::all();
        $this->data['translations']        = $translations;
        $this->data['product']             = $product;
        $this->data['page_title']          = __('admin.edit_page', ['name' => __('admin.product')]).' - '.$translations[config('app.admin_locale')]['name'];
        $this->data['attributes']          = Attribute::with('children')->with('translation')->orderBy('sort','asc')->get();
        $this->data['category_attributes'] = $this->collectAttributes($product['categories']);
        $this->data['selected_attributes'] = $product['attributes'] !== 'null' ? json_decode($product['attributes'],true) : array();
        $attached_products = AttachedProduct::whereProduct_id($id)->first();
        if(isset($attached_products->attached_product_id))
            $this->data['attached_products'] = Product::with('translation')->whereIn('id',explode(',',$attached_products->attached_product_id))->get();
        return view('admin.products.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $defaults = $this->setDefautFields($request->all());

        Product::where('id', $product->id)->update($defaults);

        foreach(config('app.available_locales') as $lang)
        {
            $translation = $this->setTranslationFields($request->all(),$lang,$product->id);
            if($request['translation_id'][$lang] !== NULL)
                ProductTranslation::where('id', $request['translation_id'][$lang])->update($translation);
            else
                ProductTranslation::create($translation);
        }

        $product->categories()->sync([]);
        $product->categories()->attach($request->categories);

        alert('success',__('admin.msg_updated', ['name' => __('admin.product')]));

        return redirect()->route('products.edit',$product->id);
    }

    function setDefautFields($request)
    {
        $posted                      = array();
        $posted['product_number']    = $request['product_number'];
        $posted['categories']        = implode(',',$request['categories']);
        $posted['available']         = $request['available'] ?? 0;
        $posted['published']         = $request['published'] ?? 0;
        $posted['featured']          = $request['featured'] ?? 0;
        $posted['free_shipping']     = $request['free_shipping'] ?? 0;
        $posted['price']             = $request['price'];
        $posted['action_price']      = $request['action_price'];
        $posted['action_start_date'] = $request['action_start_date'];
        $posted['action_end_date']   = $request['action_end_date'];
        $posted['manufacturer_id']   = $request['manufacturer_id'] ?? 0;
        $posted['shipping_cost']     = $request['shipping_cost'] ?? 0;
        $posted['stock']             = $request['stock'] ?? 0;
        $posted['unit_id']           = $request['unit_id'] ?? 0;
        $posted['warranty']          = $request['warranty'] ?? 0;
        $posted['weight']            = $request['weight'] ?? 0;
        $posted['reward']            = $request['reward'] ?? 0;

        return $posted;
    }

    function setTranslationFields($request,$lang,$product_id)
    {
        $translation = array();
        if(!empty($request['translation_id'][$lang]))
            $translation_exists = ProductTranslation::where('id', $request['translation_id'][$lang])->first();
        else
            $translation_exists = array();

        $translation['name'] = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';

        if((!empty($translation_exists) &&  $translation['name'] != $translation_exists->name) || empty($translation_exists))
            $translation['url'] = create_unique_url('product_translations',Str::slug($request['name'][$lang]));
        else
            $translation['url'] = $translation_exists->url;
        $translation['short_details']    = !empty($request['short_details'][$lang]) ? $request['short_details'][$lang] : '';
        $translation['details']          = !empty($request['details'][$lang]) ? $request['details'][$lang] : '';
        $translation['meta_description'] = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
        $translation['meta_keywords']    = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
        $translation['meta_title']       = !empty($request['meta_title'][$lang]) ? $request['meta_title'][$lang] : '';
        $translation['lang']             = $lang;
        $translation['product_id']       = $product_id;

        return $translation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Product  $productModel
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $images = ProductImage::whereProduct_id($id)->get();
        ProductTranslation::whereProduct_id($id)->delete();
        ProductImage::whereProduct_id($id)->delete();
        AttachedProduct::whereProduct_id($id)->delete();
        $aff_rows = Product::whereId($id)->delete();

        if(!empty($images))
        {
            foreach($images as $image)
            {
                @unlink($_SERVER['DOCUMENT_ROOT'].'/files/products/original/'.$image['filename']);
                @unlink($_SERVER['DOCUMENT_ROOT'].'/files/products/small/'.$image['filename']);
                @unlink($_SERVER['DOCUMENT_ROOT'].'/files/products/medium/'.$image['filename']);
                @unlink($_SERVER['DOCUMENT_ROOT'].'/files/products/large/'.$image['filename']);
            }
        }

        /*TRUNCATE `attached_products`;
        TRUNCATE `category_product`;
        TRUNCATE `products`;
        TRUNCATE `product_comments`;
        TRUNCATE `product_files`;
        TRUNCATE `product_images`;
        TRUNCATE `product_rating`;
        TRUNCATE `product_translations`;
        TRUNCATE `users_products`;*/

        if($aff_rows > 0)
            alert('success',__('admin.msg_deleted', ['name' => __('admin.product')]));
        else
            alert('info',__('admin.msg_no_change'));
        return redirect()->route('products.index');
    }

    function setFilters($request)
    {
        if(!empty($request['filter']))
            session(['filter_product'=>1]);

        if(!empty($request['product_number']))
            session(['filter_product_number'=>$request['product_number']]);
        else
            session()->forget('filter_product_number');

        if(!empty($request['manufacturer_id']))
            session(['filter_manufacturer'=>$request['manufacturer_id']]);
        else
            session()->forget('filter_manufacturer');

        if(!empty($request['categories']))
            session(['filter_categories'=>$request['categories']]);
        else
            session()->forget('filter_categories');

        if(!empty($request['name']))
            session(['filter_name'=>$request['name']]);
        else
            session()->forget('filter_name');

        if(!empty($request['clear_filters']))
            session()->forget(['filter_product', 'filter_product_number','filter_manufacturer','filter_name']);

    }

    /**
     * Save the specified attributes for product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveAttributes(Request $request)
    {
        //dd($request);
        $product = Product::find($request['product_id']);
        $product->attributes = json_encode($request['attributes']);
        $product->save();
        if($product->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.attributes')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->to(url()->previous() . '#tab0');
    }

    /**
     * Collect attributes by prouct categories.
     *
     * @param  @param  string  $product_categories (comma separated attribute ids)
     * @return parent, child attributes and its values in multidimensional array
     */
    function collectAttributes($product_categories)
    {
        $product_categories = explode(',',$product_categories);
        $attributes = array();
        if(!empty($product_categories))
        {
            foreach ($product_categories as $cat_id)
            {
                $category = Category::select('attributes')->whereId($cat_id)->first();
                
                if(!empty($category['attributes']))
                {
                   $attrs = Attribute::with('children')->with('translation')->whereIn('id',explode(',',$category['attributes']))->orderBy('sort','asc')->get();

                    if(!empty($attrs))
                    {
                        foreach ($attrs as $attr)
                        {
                            $attributes[$attr['id']]['group_name'] = $attr['name'];
                            $attributes[$attr['id']]['is_multiple'] = $attr['is_multiple'];
                            
                            if(count($attr->children) > 0)
                            {
                                foreach($attr->children as $child_attr)
                                {
                                    $attribute_values = Attribute::getOptionValues($child_attr['id']);
                                    $attributes[$attr['id']][$child_attr['id']]['name'] = $child_attr['name'];
                                    $attributes[$attr['id']][$child_attr['id']]['is_multiple'] = $child_attr['is_multiple'];
                                    if(!empty($attribute_values))
                                    {
                                        foreach($attribute_values as $attr_val)
                                        {
                                            $attributes[$attr['id']][$child_attr['id']]['values'][$attr_val->id] = $attr_val;
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $attribute_values = Attribute::getOptionValues($attr['id']);
                                $attributes[$attr['id']][$attr['id']]['name'] = $attr['name'];
                                $attributes[$attr['id']][$attr['id']]['is_multiple'] = $attr['is_multiple'];
                                if(!empty($attribute_values))
                                {
                                    foreach($attribute_values as $attr_val)
                                    {
                                        $attributes[$attr['id']][$attr['id']]['values'][$attr_val->id] = $attr_val;
                                    }
                                }
                            }
                        }
                    }
                }
                
            }
        }
        return $attributes;
    }

    public function ajaxGetOptionValues(int $attr_id)
    {
        $attributes = "";
        $attribute_values = Attribute::getOptionValues($attr_id);
        if(!empty($attribute_values))
        {
            foreach($attribute_values as $attr_val)
            {
                $attributes .= '<option value="'.$attr_val->id.'"">'.$attr_val->translation->name.'</option>';
            }
        }
        return $attributes;
    }

    public function ajaxGetProductsByCategory($category_id)
    {
        $products = Product::getProducts($category_id);
        if(count($products) > 0)
        {
            $values = '<select name="attached_products[]" class="form-select" multiple>';
            foreach ($products as $p)
            {
                $values .= '<option value="'.$p->id.'">'.$p->translation->name.'</option>';
            }
            $values .= '</select>';
            echo $values;
        }
        else
            echo '0';
    }

    /**
     * Save the specified attributes for product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAttachedProducts(Request $request)
    {
        if(!empty($request->deleteall))
        {
            AttachedProduct::whereProduct_id($request->product_id)->delete();
            alert('success',__('admin.msg_deleted', ['name' => __('admin.attached_products')]));
        }
        else
        {
            $att_product = AttachedProduct::whereProduct_id($request->product_id)->first();

            if(!empty($att_product->product_id))
                AttachedProduct::whereProduct_id($request->product_id)->update(['attached_product_id' => implode(',',$request->attached_products)]);
            else
                $att_product = AttachedProduct::create([
                    'product_id' => $request->product_id,
                    'attached_product_id' => implode(',',$request->attached_products)
                ]);
            

            if($att_product->product_id)
                alert('success',__('admin.msg_updated', ['name' => __('admin.attached_products')]));
            else
                alert('info',__('admin.msg_no_change'));
        }

        return redirect()->to(url()->previous() . '#tab3');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export(Request $request) 
    {
        return Excel::download(new ProductsExport($request->product_ids), 'products_'.date('Y-m-d_H-i').'.xlsx');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function exportTranslations(Request $request) 
    {
        return Excel::download(new ProductTranslationsExport($request->product_ids), 'product_translations_'.date('Y-m-d_H-i').'.xlsx');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importView(Request $request)
    {
        $this->data['page_title'] = __('admin.product_import');

        return view('admin.products.import', $this->data);
    }

    /**
     * Import default product datas.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file'));

        alert('success',__('admin.msg_imported', ['name' => __('admin.products')]));

        return redirect()->back();
    }

    /**
     * Import product translations.
     *
     * @return \Illuminate\Http\Response
     */
    public function importTranslations(Request $request)
    {
        Excel::import(new ProductTranslationImport, $request->file('file'));

        alert('success',__('admin.msg_imported', ['name' => __('admin.translations')]));

        return redirect()->back();
    }
}
