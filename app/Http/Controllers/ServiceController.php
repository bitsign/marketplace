<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceTranslation;

class ServiceController extends Controller
{
    /**
     * Display services
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page']     = Page::getPageByType('services');
        $data['services'] = Service::getAllServices();
        return view('services.index', $data);
    }

     /**
     * Display service by url.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $data['page']               = Page::getPageByType('services');
        $data['service']            = Service::getService($url);
        $data['breadcrumbs'][]      = ['url' => app()->getLocale().'/'.__('routes.services'),'title'=>__('services')];
        $data['breadcrumbs'][]      = ['title' => $data['service']['name']];
        $data['meta_title']         = !empty($data['service']['menu_title']) ? $data['service']['menu_title'] : $data['service']['name'];
        $data['meta_description']   = $data['service']['meta_description'];
        $data['meta_keywords']      = $data['service']['meta_keywords'];
        return view('services.show', $data);
    }
}
