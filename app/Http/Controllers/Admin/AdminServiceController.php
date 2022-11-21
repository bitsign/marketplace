<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ServiceTranslation;
use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Support\Facades\Auth;

class AdminServiceController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/services'          =>__('admin.list_pages', ['name' => __('admin.services')]),
                'admin/services/create'   =>__('admin.create_page', ['name' => __('admin.service')])
                );
        $this->data['scripts'][]    = "custom_service.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.services');

        $this->data['services'] = Service::getServices();

        return view('admin.services.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.service')]);
        return view('admin.services.create', $this->data);
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

        $posted['active']        = !empty($request->active) ? 1 : 0;

        $service = Service::create($posted);

        if($service->wasRecentlyCreated)
        {
            foreach(config('app.available_locales') as $lang)
            {
                $translation['name']                = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';
                $translation['url']                 = create_unique_url('service_translations',Str::slug($request['name'][$lang]));
                $translation['content']             = !empty($request['content'][$lang]) ? $request['content'][$lang] : '';
                $translation['meta_description']    = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
                $translation['meta_keywords']       = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
                $translation['menu_title']          = !empty($request['menu_title'][$lang]) ? $request['menu_title'][$lang] : '';
                $translation['lang']                = $lang;
                $translation['service_id']          = $service->id;

                $insert = ServiceTranslation::create($translation);

                if($insert->wasRecentlyCreated)
                    $rows++;
            }
            alert('success',__('admin.msg_created', ['name' => __('admin.service')]));
        }
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.service')]));

        return redirect()->route('services.edit',$service);
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
        $this->data['service'] = Service::with('translations')->whereId($id)->first();
        $translations = array();
        if(!empty($this->data['service']->translations))
        {
            foreach ($this->data['service']->translations as $key => $value)
            {
                $translations[$value['lang']] = $value;
            }
        }
        $this->data['translations'] = $translations;

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.service')]);

        return view('admin.services.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\services  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $rows = 0;
        foreach(config('app.available_locales') as $lang)
        {
            if(!empty($request['translation_id'][$lang]))
                $translation_exists = ServiceTranslation::where('id', $request['translation_id'][$lang])->first();
            else
                $translation_exists = array();

            $translation['name'] = !empty($request['name'][$lang]) ? $request['name'][$lang] : '';

            if((!empty($translation_exists) &&  $translation['name'] != $translation_exists->name) || empty($translation_exists))
                $translation['url'] = create_unique_url('service_translations',Str::slug($request['name'][$lang]));
            else
                $translation['url'] = $translation_exists->url;

            $translation['content'] = !empty($request['content'][$lang]) ? $request['content'][$lang] : '';
            $translation['meta_description'] = !empty($request['meta_description'][$lang]) ? $request['meta_description'][$lang] : '';
            $translation['meta_keywords'] = !empty($request['meta_keywords'][$lang]) ? $request['meta_keywords'][$lang] : '';
            $translation['menu_title'] = !empty($request['menu_title'][$lang]) ? $request['menu_title'][$lang] : '';
            $translation['lang'] = $lang;
            $translation['service_id'] = $service->id;

            if(!empty($request['translation_id'][$lang]))
            {
                $update = ServiceTranslation::where('id', $request['translation_id'][$lang])->update($translation);
                if($update > 0)
                    $rows++;
            }
            else
            {
                $insert = ServiceTranslation::create($translation);
                if($insert->wasRecentlyCreated)
                    $rows++;
            }
        }

        $posted = array();
        if(!empty($request->image))
        {
            $img_ = explode('/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";
        $posted['active']        = !empty($request->active) ? 1 : 0;

        $service->fill($posted)->save();

        if($service->wasChanged())
            $rows++;

        if($rows > 0)
            alert('success',__('admin.msg_updated', ['name' => __('admin.service')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('services.edit',$service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\services  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service,ServiceTranslation $service_translation)
    {
        $service_translation->whereServiceId($service->id)->delete();
        $service->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.service')]));
        return redirect()->route('services.index');
    }

    /**
     * Sort services.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortServices(Request $request)
    {
        $sort = Service::sortServices($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.services')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}
