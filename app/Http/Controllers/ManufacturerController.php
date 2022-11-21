<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Page;
use App\Models\Product;

class ManufacturerController extends Controller
{
    /**
     * Display manufacturers page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page']          = Page::getPageByType('manufacturers');
        $data['manufacturers'] = Manufacturer::where('active','=','1')->get();
        return view('manufacturers.index', $data);
    }

     /**
     * Display manufacturer by url.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $data['manufacturer']       = Manufacturer::whereUrl($url)->first();
        $data['breadcrumbs'][]      = ['url' => app()->getLocale().'/'.__('routes.manufacturers'),'title'=>__('manufacturers')];
        $data['breadcrumbs'][]      = ['title' => $data['manufacturer']['name']];
        $data['products']           = Product::getProductsWhere(['manufacturer_id' => $data['manufacturer']['id']]);
        return view('manufacturers.show', $data);
    }
}
