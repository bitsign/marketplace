<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Block;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Package;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Product;
use App\Models\Service;
use App\Models\Team;

class PageController extends Controller
{
    /**
     * Display front page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['main_categories']  = [];//Category::with('translation')->withDepth()->having('depth', '=', 1)->get();
        $data['services']         = [];//Service::getAllServices();
        $data['banners']          = Banner::whereGroupId(1)->whereActive(1)->get();
        $data['blocks']           = [];//Block::whereName('Fooldal')->whereActive(1)->get();
        $data['team']             = [];//Team::orderBy('sort','asc')->get();
        $data['featured_products']= Product::getProductsWhere(['featured'=>1],8);
        $data['manufacturers']    = [];//Manufacturer::all();
        $data['packages']         = Package::all();
        return view('front-page', $data);
    }

     /**
     * Display pages by url.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $data['page']               = Page::getPage($url);
        if($data['page'] === NULL)
            return abort(404);
        $data['meta_title']         = !empty($data['page']['menu_title']) ? $data['page']['menu_title'] : $data['page']['name'];
        $data['meta_description']   = $data['page']['meta_description'];
        $data['meta_keywords']      = $data['page']['meta_keywords'];
        return view('page-content', $data);
    }
}
