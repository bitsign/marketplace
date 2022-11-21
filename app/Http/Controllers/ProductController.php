<?php

namespace App\Http\Controllers;
use App\Models\AttachedProduct;
use App\Models\AttributeOptionTranslation;
use App\Models\AttributeTranslation;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($url)
    {
        $product = Product::getProduct($url);

        $data['product'] = $product;

        if(empty($data['product']))
            abort(404);

        //legalsó színtű kategória kiválasztása (nem biztos jó)
        $product_cat_id   = max(explode(',',$product['categories']));
        $category         = Category::with('translation')->where('id', $product_cat_id)->first();
        $ancestors        = Category::with('translation')->ancestorsOf($product_cat_id)->toArray();
        if(!empty($ancestors))
        {
            //krsort($ancestors);
            foreach($ancestors as $ancestor)
            {
                if($ancestor['id'] == 1)
                    continue;
                if($ancestor['translation'] !== NULL)
                    $data['breadcrumbs'][] = ['url'=>app()->getLocale().'/'.__('routes.products').'/'.$ancestor['translation']['url'],'title'=>$ancestor['translation']['name']];
            }
        }
        if(isset($category->translation))
            $data['breadcrumbs'][] = ['url'=>app()->getLocale().'/'.__('routes.products').'/'.$category->translation->url,'title'=>$category->translation->name];
        $data['breadcrumbs'][] = ['title'=>$product->name];
        
        $product_attributes = !empty($product->attributes) ? json_decode($product->attributes,true) : array();

        if(!empty($product_attributes))
        {
            foreach($product_attributes as $attribute_id => $attribute)
            {
                unset($product_attributes[$attribute_id]['options'][$attribute_id]['name']);
                unset($product_attributes[$attribute_id]['options'][$attribute_id]['value']);
                $attr_translation = AttributeTranslation::whereAttribute_id($attribute_id)->whereLang(app()->getLocale())->first();
                $product_attributes[$attribute_id]['group_name'] = $attr_translation->name;
                $product_attributes[$attribute_id]['options'][$attribute_id]['name'] = $attr_translation->name;
                foreach($attribute['options'][$attribute_id]['value'] as $opt_id)
                {
                    $values_translation = AttributeOptionTranslation::whereAttribute_option_id($opt_id)->whereLang(app()->getLocale())->first();
                    $product_attributes[$attribute_id]['options'][$attribute_id]['value'][]=$values_translation->name;
                }
            }

            usort($product_attributes, function($a, $b) {
                return $a['order'] <=> $b['order'];
            });
        }
        
        $data['attributes'] = $product_attributes;

        $data['main_image'] = 'no-image.jpg';
        $data['gallery'] = array();
        
        if(!empty($product->images))
        {
            foreach($product->images as $img)
            {
                if($img['default'] == 1)
                    $data['main_image'] = $img;
                else
                    $data['gallery'][] = $img;
            }
        }

        $data['attached_products'] = $this->getAttachedProducts($product->id);

        /* json keresés: 4 GB ram
        $ram = DB::table('products')
                   ->where('attributes->3->options->3->value','4 GB')
                   ->get();
        dd($ram);*/

        $data['css'][]         = "../vendor/lightgallery/css/lightgallery-bundle.min.css";
        $data['js'][]          = "../vendor/lightgallery/lightgallery.min.js";
        $data['js'][]          = "../vendor/lightgallery/plugins/fullscreen/lg-fullscreen.min.js";
        $data['js'][]          = "../vendor/lightgallery/plugins/zoom/lg-zoom.min.js";
        $data['js'][]          = "../vendor/lightgallery/plugins/thumbnail/lg-thumbnail.min.js";

        $data['meta_title']         = !empty($product->meta_title) ? $product->meta_title : $product->name;
        $data['meta_description']   = !empty($product->meta_description) ? $product->meta_description : '';
        $data['meta_keywords']      = !empty($product->meta_keywords) ? $product->meta_keywords : '';

        return view('products.product', $data);
    }

    public function ajaxSearch(Request $request)
    {
        $response = 'false';
        $term = ['search_keyword'=>$request->term];
        if(empty($term))
            echo $response;
        
        $products = Product::searchProducts($term);
        if(count($products) > 0)
        {
            $data['products'] = $products;
            return view('products.ajax_list',$data)->render();
        }
    }

    private function getAttachedProducts($product_id)
    {
        $att_prod_ids = AttachedProduct::whereProduct_id($product_id)->first();
        
        if($att_prod_ids !== NULL)
            return Product::with('translation')->with('images')->whereIn('id',explode(',',$att_prod_ids['attached_product_id']))->get();
        
        return false;
    }
}
