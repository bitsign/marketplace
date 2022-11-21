<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Models\PortfolioTranslation;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;

class AdminPortfolioController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/portfolios'          =>__('admin.list_pages', ['name' => __('admin.gallery')]),
                'admin/portfolios/create'   =>__('admin.create_page', ['name' => __('admin.gallery')])
                );
        $this->data['scripts'][]    = "custom_portfolio.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.gallery');

        $this->data['portfolios'] = Portfolio::orderBy('sort')->get();

        return view('admin.portfolio.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['edit'] = false;
        $term_dd = array();
        $this->data['portfolio'] = array();
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.gallery')]);
        return view('admin.portfolio.create', $this->data);
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
            $img_ = explode('/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";

        $posted['sort']     = !empty($request->sort) ? $request->sort : 0;
        $posted['name']      = $request['name'][app()->getLocale()];
        $portfolio = Portfolio::create($posted);

        if($portfolio->wasRecentlyCreated)
        {
            foreach(config('app.available_locales') as $lang)
            {
                $translation['name']                = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';
                $translation['url']                 = create_unique_url('portfolio_translations',Str::slug($request['name'][$lang]));
                $translation['description']         = !empty($request['description'][$lang]) ? $request['description'][$lang] : '';
                $translation['meta_description']    = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
                $translation['meta_keywords']       = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
                $translation['meta_title']          = !empty($request['meta_title'][$lang]) ? $request['meta_title'][$lang] : '';
                $translation['lang']                = $lang;
                $translation['portfolio_id']        = $portfolio->id;

                $insert = PortfolioTranslation::create($translation);

                if($insert->wasRecentlyCreated)
                    $rows++;
            }
            alert('success',__('admin.msg_created', ['name' => __('admin.portfolio')]));
        }
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.portfolio')]));

        return redirect()->route('portfolios.edit',$portfolio);
    }

   /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->data['edit'] = true;

        $this->data['portfolio'] = Portfolio::whereId($id)->with('translation')->first();

        $translations = array();
        if(!empty($this->data['portfolio']->translations))
        {
            foreach ($this->data['portfolio']->translations as $key => $value)
            {
                $translations[$value['lang']] = $value;
            }
        }
        $this->data['translations'] = $translations;

        $this->data['images'] = PortfolioImage::wherePortfolio_id($id)->get();

        $this->data['terms'] = Term::whereLang(config('app.admin_locale'))->get();

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.portfolio')]);

        return view('admin.portfolio.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $rows = 0;
        foreach(config('app.available_locales') as $lang)
        {
            if(!empty($request['translation_id'][$lang]))
                $translation_exists = PortfolioTranslation::where('id', $request['translation_id'][$lang])->first();
            else
                $translation_exists = array();

            $translation['name'] = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';

            if((!empty($translation_exists) &&  $translation['name'] != $translation_exists->name) || empty($translation_exists))
                $translation['url'] = create_unique_url('portfolio_translations',Str::slug($request['name'][$lang]));
            else
                $translation['url'] = $translation_exists->url;

            $translation['description']      = !empty($request['description'][$lang]) ? $request['description'][$lang] : '';
            $translation['meta_description'] = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
            $translation['meta_keywords']    = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
            $translation['meta_title']       = !empty($request['meta_title'][$lang]) ? $request['meta_title'][$lang] : '';
            $translation['lang']             = $lang;
            $translation['portfolio_id']     = $portfolio->id;

            if(!empty($request['translation_id'][$lang]))
            {
                $update = PortfolioTranslation::where('id', $request['translation_id'][$lang])->update($translation);
                if($update > 0)
                    $rows++;
            }
            else
            {
                $insert = PortfolioTranslation::create($translation);
                if($insert->wasRecentlyCreated)
                    $rows++;
            }
        }

        $posted = array();
        if(!empty($request->image))
        {
            $img_ = explode('editor/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";
        $posted['sort']      = !empty($request->sort) ? $request->sort : 0;
        $posted['name']      = $request['name'][app()->getLocale()];

        $portfolio->fill($posted)->save();

        if($portfolio->wasChanged())
            $rows++;

        if($rows > 0)
            alert('success',__('admin.msg_updated', ['name' => __('admin.portfolio')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('portfolios.edit',$portfolio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\PortfolioImage  $portfolio_images
     * @return \Illuminate\Http\Response
     */
    public function uploadImages(int $portfolio_id,Request $request, PortfolioImage $portfolio_images)
    {
        $request->validate([
            'image' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if($request->image)
        {
            //ha már van feltöltve, kivesszük az alapértelmezést
            $existsCheck = PortfolioImage::wherePortfolio_id($portfolio_id)->get();
            if(count($existsCheck) > 0)
                PortfolioImage::wherePortfolio_id($portfolio_id)->update(['featured'=>0]);

            $rows = 0;
            foreach($request->image as $key => $image)
            {
                $image_datas = array();
                $name        = $image->getClientOriginalName();
                $extension   = $image->getClientOriginalExtension();
                $fileName    = pathinfo($name, PATHINFO_FILENAME);
                $cleanName   = Str::slug($fileName);

                //Doc.: https://image.intervention.io/v2/api/resize
                $img = Image::make($image->path());

                $data = getimagesize($image);
                if($data[0] > 1920 || $data[1] > 1080)
                {
                    $img->resize(1920, 1080, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save(public_path('files/portfolio/original/'.$cleanName.'.'.$extension));
                }
                else
                    $image->move(public_path('files/portfolio/original'), $cleanName.'.'.$extension);

                $img->resize(500, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('files/portfolio/thumbs/'.$cleanName.'.'.$extension));
  
                $image_datas['name']         = $fileName;
                $image_datas['image']        = $cleanName.'.'.$extension;
                $image_datas['portfolio_id'] = $portfolio_id;
                $image_datas['featured']     = $key==0 ? 1 : 0;

                $insert = PortfolioImage::create($image_datas);
                if($insert->id > 0)
                    $rows++;
            }

            if($rows > 0)
                alert('success',__('admin.msg_created', ['name' => __('admin.images')]));
        }
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('portfolios.show',$portfolio_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio,PortfolioImage $portfolio_images,PortfolioTranslation $portfolio_translation)
    {
        $portfolio_translation->wherePortfolioId($portfolio->id)->delete();
        $portfolio_images->wherePortfolioId($portfolio->id)->delete();
        $portfolio->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.portfolio')]));
        return redirect()->route('portfolios.index');
    }


    /**
     * Sort portfolio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortPortfolio(Request $request)
    {
        $sort = Portfolio::sortPortfolio($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.portfolio')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }

    function setImage(Request $request)
    {
        $set = PortfolioImage::setImage($request);
        if($set > 0)
            echo '1';
        else
            echo '0';
    }

    function deleteImage(Request $request)
    {
        $image  = PortfolioImage::whereId($request['id'])->get()->first();
        $delete = PortfolioImage::whereId($request['id'])->delete();
        if($delete > 0)
        {
            unlink($_SERVER['DOCUMENT_ROOT'].'/files/portfolio/original/'.$image->image);
            unlink($_SERVER['DOCUMENT_ROOT'].'/files/portfolio/thumbs/'.$image->image);
            echo '1';
        }
        else
            echo '0';
    }
}
