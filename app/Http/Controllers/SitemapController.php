<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $posts = Post::with('translation')->get();

        $pages = Page::with('translation')->whereActive('1')->whereMenu('1')->get();

        $products = Product::with('translation')->wherePublished('1')->get();
  
        return response()->view('sitemap', [
            'pages' => $pages,
            'products' => $products,
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');
    }
}
