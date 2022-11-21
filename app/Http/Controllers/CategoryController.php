<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the subcategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($url)
    {
        $category = Category::whereUrl($url)->join('category_translations as ct','ct.category_id','=','categories.id')->first();
        //dd($category);
        if(empty($category))
            abort(404);

        $data['category']      = $category;
        $data['subcategories'] = Category::leftJoin('category_translations as ct','ct.category_id','=','categories.id')->where('ct.lang','=',app()->getLocale())->descendantsOf($category->category_id);

        $ancestors =  Category::leftJoin('category_translations as ct','ct.category_id','=','categories.id')->where('ct.lang','=',app()->getLocale())->ancestorsOf($category->category_id)->toArray();

        if(!empty($ancestors))
        {
            krsort($ancestors);
            foreach($ancestors as $ancestor)
            {
                if($ancestor['id'] == 1)
                    continue;
                $name = !empty($ancestor['short_name']) ? $ancestor['short_name'] :$ancestor['name'];
                $data['breadcrumbs'][] = ['url'=>app()->getLocale().'/'.__('routes.products').'/'.$ancestor['url'],'title'=>$name];
            }
        }
        $data['breadcrumbs'][]    = ['title'=>$category->name];

        $data['meta_title']       = $data['category']['name'];
        $data['meta_description'] = $data['category']['meta_description'];
        $data['meta_keywords']    = $data['category']['meta_keywords'];

        return view('categories.subcategories', $data);
    }


    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function products($url)
    {
        $category = Category::whereUrl($url)->join('category_translations as ct','ct.category_id','=','categories.id')->first();
        if(empty($category))
            abort(404);

        $data['categories'] = Category::tree();

        $data['products'] = Product::getProducts($category->category_id);

        $data['category'] = $category;
        $ancestors        = Category::leftJoin('category_translations as ct','ct.category_id','=','categories.id')->where('ct.lang','=',app()->getLocale())->ancestorsOf($category->category_id)->toArray();

        if(!empty($ancestors))
        {
            //krsort($ancestors);
            foreach($ancestors as $ancestor)
            {
                if($ancestor['id'] == 1)
                    continue;
                $data['breadcrumbs'][] = ['url'=>app()->getLocale().'/'.__('routes.products').'/'.$ancestor['url'],'title'=>$ancestor['name']];
            }
        }
        $data['breadcrumbs'][] = ['title'=>$category->name];

        $data['meta_title']       = $data['category']['name'];
        $data['meta_description'] = $data['category']['meta_description'];
        $data['meta_keywords']    = $data['category']['meta_keywords'];

        return view('categories.product-list', $data);
    }

    public function search(Request $request)
    {

        if($request->search_products !== NULL)
            $data['products'] = Product::searchProducts(['search_keyword'=>$request->search_products]);
        else
            $data['products'] = [];

        $data['breadcrumbs'][] = ['title'=>__('search')];

        $data['categories'] = Category::tree();

        $data['category']['name'] = __('search');

        $data['meta_title']       = __('search').' '.$request->search_products;
        $data['meta_description'] = __('search').' '.$request->search_products;
        $data['meta_keywords']    = __('search').', '.$request->search_products;

        return view('categories.product-list', $data);
    }
}
