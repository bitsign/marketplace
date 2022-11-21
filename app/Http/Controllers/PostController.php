<?php

namespace App\Http\Controllers;
use App\Models\Page;
use App\Models\Post;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\s;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $data['page']               = Page::getPageByType('blog');
        //DB::enableQueryLog();
        $data['posts']              = Post::getPosts($request);
        //dd(DB::getQueryLog());
        $data['meta_title']         = $data['page']['meta_title'];
        $data['meta_description']   = $data['page']['meta_description'];
        $data['meta_keywords']      = $data['page']['meta_keywords'];
        $data['archives']           = Post::getArchives();
        $terms                      = Post::getTerms();
        $data['terms']              = Term::whereIn('term_key',$terms)->whereLang(app()->getLocale())->get();

        return view('blog.index', $data);
    }

    public function post($url)
    {
        $data['post']               = Post::getPost($url);
        $data['breadcrumbs'][]      = ['url'=>app()->getLocale().'/'.__('routes.blog'),'title'=>__('blog')];
        $data['breadcrumbs'][]      = ['title'=>$data['post']['name']];
        $data['meta_title']         = !empty($data['post']['meta_title']) ? $data['post']['meta_title'] : $data['post']['name'];
        $data['meta_description']   = $data['post']['meta_description'];
        $data['meta_keywords']      = $data['post']['meta_keywords'];
        $data['archives']           = Post::getArchives();
        $terms                      = !empty($data['post']['tags']) ? array_unique(explode(',',$data['post']['tags'])) : array();
        $data['terms']              = Term::whereIn('term_key',$terms)->whereLang(app()->getLocale())->get();
        return view('blog.post', $data);
    }
}
