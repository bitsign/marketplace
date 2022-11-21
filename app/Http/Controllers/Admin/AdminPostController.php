<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPostController extends AdminBaseController
{
    public $data;
    
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/posts'          =>__('admin.list_pages', ['name' => __('admin.posts')]),
                'admin/posts/create'   =>__('admin.create_page', ['name' => __('admin.post')])
                );
        $this->data['css'][]        = "../plugins/datatables/dataTables.bootstrap.css";
        $this->data['scripts'][]    = "../plugins/datatables/jquery.dataTables.min.js";
        $this->data['scripts'][]    = "../plugins/datatables/dataTables.bootstrap.min.js";
        $this->data['scripts'][]    = "jquery.validate.min.js";
        $this->data['scripts'][]    = "jquery.nameBadges.js";
        $this->data['scripts'][]    = "custom_blog.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['page_title'] = __('admin.posts');

        $this->data['posts'] = Post::getPosts($request);

        return view('admin.posts.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['terms'] = Term::whereLang(config('app.admin_locale'))->get();
        
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.post')]);

        return view('admin.posts.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rows = 0;
        $posted = array();

        if(!empty($request->image))
        {
            $img_ = explode('/editor',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";

        $posted['author']        = session('AdminUser')['id'];
        $posted['published']     = !empty($request->published) ? 1 : 0;
        $posted['tags']          = !empty($request->tags) ? implode(',',array_filter($request->tags)) : '';

        $post = Post::create($posted);

        if($post->wasRecentlyCreated)
        {
            foreach(config('app.available_locales') as $lang)
            {
                $translation['name']                = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';
                $translation['url']                 = create_unique_url('post_translations',Str::slug($request['name'][$lang]));
                $translation['intro']               = !empty($request['intro'][$lang]) ? $request['intro'][$lang] : '';
                $translation['content']             = !empty($request['content'][$lang]) ? $request['content'][$lang] : '';
                $translation['meta_description']    = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
                $translation['meta_keywords']       = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
                $translation['meta_title']          = !empty($request['meta_title'][$lang]) ? $request['meta_title'][$lang] : '';
                $translation['lang']                = $lang;
                $translation['post_id']             = $post->id;

                $insert = PostTranslation::create($translation);

                if($insert->wasRecentlyCreated)
                    $rows++;
            }
            alert('success',__('admin.msg_created', ['name' => __('admin.post')]));
        }
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.post')]));

        return redirect()->route('posts.edit',$post);
    }

   /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->data['post']  = Post::with('translations')->whereId($id)->first();
        $this->data['terms'] = Term::whereLang(config('app.admin_locale'))->get();
        $translations = array();
        if(!empty($this->data['post']->translations))
        {
            foreach ($this->data['post']->translations as $key => $value)
            {
                $translations[$value['lang']] = $value;
            }
        }
        $this->data['translations'] = $translations;

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.post')]);

        return view('admin.posts.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Posts  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rows = 0;
        foreach(config('app.available_locales') as $lang)
        {
            if(!empty($request['translation_id'][$lang]))
                $translation_exists = PostTranslation::where('id', $request['translation_id'][$lang])->first();
            else
                $translation_exists = array();

            $translation['name'] = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';

            if((!empty($translation_exists) &&  $translation['name'] != $translation_exists->name) || empty($translation_exists))
                $translation['url'] = create_unique_url('post_translations',Str::slug($request['name'][$lang]));
            else
                $translation['url'] = $translation_exists->url;

            $translation['content']          = !empty($request['content'][$lang]) ? $request['content'][$lang] : '';
            $translation['intro']            = !empty($request['intro'][$lang]) ? $request['intro'][$lang] : '';
            $translation['meta_description'] = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
            $translation['meta_keywords']    = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
            $translation['meta_title']       = !empty($request['meta_title'][$lang]) ? $request['meta_title'][$lang] : '';
            $translation['lang']             = $lang;
            $translation['post_id']          = $post->id;

            if(!empty($request['translation_id'][$lang]))
            {
                $update = PostTranslation::where('id', $request['translation_id'][$lang])->update($translation);
                if($update > 0)
                    $rows++;
            }
            else
            {
                $insert = PostTranslation::create($translation);
                if($insert->wasRecentlyCreated)
                    $rows++;
            }
        }

        $posted = array();
        if(!empty($request->image))
        {
            $img_ = explode('/editor',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";
       
        $posted['published']     = !empty($request->published) ? 1 : 0;
        $posted['tags']          = !empty($request->tags) ? implode(',',array_filter($request->tags)) : '';

        $post->fill($posted)->save();

        if($post->wasChanged())
            $rows++;

        if($rows > 0)
            alert('success',__('admin.msg_updated', ['name' => __('admin.post')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('posts.edit',$post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Posts  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post,PostTranslation $post_translation)
    {
        $post_translation->wherePostId($post->id)->delete();
        $post->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.post')]));
        return redirect()->route('posts.index');
    }

    /**
     * Sort posts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortPosts(Request $request)
    {
        $sort = Post::sortPosts($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.posts')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}