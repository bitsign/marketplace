<?php

namespace App\Http\Controllers;
use App\Models\Page;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display front page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['faqs']               = Faq::all();
        $data['page']               = Page::getPageByType('faq');
        $data['meta_title']         = !empty($data['page']['menu_title']) ? $data['page']['menu_title'] : $data['page']['name'];
        $data['meta_description']   = $data['page']['meta_description'];
        $data['meta_keywords']      = $data['page']['meta_keywords'];

        return view('faqs.index', $data);
    }
}
