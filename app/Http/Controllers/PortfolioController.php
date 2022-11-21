<?php

namespace App\Http\Controllers;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Models\Page;
use App\Models\Term;


class PortfolioController extends Controller
{
    /**
     * Display portfolio.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page']               = Page::getPageByType('portfolio');
        $data['portfolio']          = Portfolio::with('translation')->get();
        $data['meta_title']         = $data['page']['name'];
        $data['meta_description']   = $data['page']['meta_description'];
        $data['meta_keywords']      = $data['page']['meta_keywords'];
        return view('portfolio.index', $data);
    }

     /**
     * Display portfolio images.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $data['portfolio']          = Portfolio::getPortfolio($url);
        $data['images']             = PortfolioImage::wherePortfolio_id($data['portfolio']['portfolio_id'])->get();
        $data['tags']               = $this->collectTags($data['images']);
        $data['meta_title']         = !empty($data['portfolio']['meta_title']) ? $data['portfolio']['meta_title'] : $data['portfolio']['name'];
        $data['meta_description']   = $data['portfolio']['meta_description'];
        $data['meta_keywords']      = $data['portfolio']['meta_keywords'];
        $data['breadcrumbs'][]      = ['url' => app()->getLocale().'/'.__('routes.portfolio'),'title'=>__('portfolio')];
        $data['breadcrumbs'][]      = ['title' => $data['portfolio']['name']];
        $data['css'][]              = "../vendor/lightgallery/css/lightgallery-bundle.min.css";
        $data['js'][]               = "../vendor/lightgallery/lightgallery.min.js";
        $data['js'][]               = "../vendor/lightgallery/plugins/fullscreen/lg-fullscreen.min.js";
        $data['js'][]               = "../vendor/lightgallery/plugins/zoom/lg-zoom.min.js";
        $data['js'][]               = "../vendor/lightgallery/plugins/thumbnail/lg-thumbnail.min.js";
        $data['js'][]               = asset('vendor/isotope-layout/isotope.pkgd.min.js');
        $data['js'][]               = asset('js/portfolio.js');
        return view('portfolio.show', $data);
    }

    private function collectTags($images)
    {
        $tags = array();
        foreach($images as $pi)
        {
            $tag_datas = Term::whereIn('term_key',explode(',',$pi->tags))->whereLang(app()->getLocale())->get();
            if(!empty($tag_datas))
            {
                foreach($tag_datas as $td)
                {
                    $tags[$td->term_key] = $td->name;
                }
            }
        }
        return $tags;
    }
}
