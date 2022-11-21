<?php

namespace App\Http\Controllers\Admin;

use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminBlockController extends AdminBaseController
{
    public $data;

    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/blocks'        => __('admin.list_pages', ['name' => __('admin.blocks')]),
                'admin/blocks/create' => __('admin.create_page', ['name' => __('admin.block')]),
                );
        $this->data['scripts'][]    = "custom_blocks.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.list_pages', ['name' => __('admin.blocks')]);
        $this->data['blocks']     = Block::all();
        return view('admin.blocks.blocks', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title']   = __('admin.create_page', ['name' => __('admin.block')]);
        $this->data['edit']         = false;
        return view('admin.blocks.block-form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posted = array();

        if(!empty($request->image))
        {
            $img_ = explode('editor/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";

        $posted['name']         = $request->name;
        $posted['active']       = !empty($request->active) ? 1 : 0;
        $posted['title']        = $request->translations['title'][app()->getLocale()];
        $posted['translations'] = json_encode($request->translations);

        $block = Block::create($posted);

        if($block->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.block')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.block')]));

        return redirect()->route('blocks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $this->data['page_title']   = "Blokk";
        $this->data['edit']         = true;
        $this->data['block']        = Block::whereId($id)->first();
        $this->data['translations'] = json_decode($this->data['block']['translations'],true);
        return view('admin.blocks.block-form', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Block  $Block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $Block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        $posted = array();

        if(!empty($request->image))
        {
            $img_ = explode('editor/',$request->image);
            $posted['image'] = end($img_);
        }
        else
            $posted['image'] = "";

        $posted['name']         = $request->name;
        $posted['active']       = !empty($request->active) ? 1 : 0;
        $posted['title']        = $request->translations['title'][app()->getLocale()];
        $posted['translations'] = json_encode($request->translations);

        $block->fill($posted)->save();

        if($block->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.block')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('blocks.show',$block);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        $block->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.block')]));
        return redirect()->route('blocks.index');
    }
}
