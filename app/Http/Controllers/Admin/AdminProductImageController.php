<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminProductImageController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'filename.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072',
        ]);

        $posted = $request->all();

        unset($posted['_method']);
        unset($posted['_token']);

        if ($request->hasfile('filename')) {

            $defaultImage = ProductImage::getDefaultProductImage($posted['product_id']);
            if(empty($defaultImage['id']))
                ProductImage::where('product_id',$posted['product_id'])->update(['default'=>0]);

            $images = $request->file('filename');

            foreach($images as $key => $image)
            {
                $base_file_name = Str::of($image->getClientOriginalName())->basename('.'.$image->getClientOriginalExtension());
                $friendly_name  = Str::of($base_file_name)->ascii();
                $new_filename   = Str::slug($friendly_name).'.'.$image->getClientOriginalExtension();

                $image->move(public_path('files/products/original'), $new_filename);

                if(empty($defaultImage['id']))
                    $posted['default']  = $key == 0 ? 1 : 0;
                $posted['filename'] = $new_filename;
                $posted['alt']      = $base_file_name;
                $posted['title']    = $base_file_name;
                $imgs = ProductImage::create($posted);
            }
        }

        if($imgs->wasRecentlyCreated)
            alert('success','Termék képek módosítva!');
        else
            alert('info','Nincs változás');

        return redirect()->to('admin/products/'.$request->product_id.'/edit#tab2');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImage $productImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImage $productImage)
    {

        $posted = $request->all();
        $posted['default']    = !empty($request->default) ? 1 : 0;

        if($posted['default'] == 1)
        {
            $productImage->where('product_id',$posted['product_id'])->update(['default'=>0]);
        }

        unset($posted['_method']);
        unset($posted['_token']);

        $productImage->fill($posted)->save();

        if($productImage->wasChanged())
            return response()->json(['code' => 1,'msg'  => 'Termékkép sikeresen módosítva'], 200);
        else
            return response()->json(['code' => 0,'msg'  => 'Hiba! Termékkép nincs módosítva'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id product image ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->image_id;
        $image = ProductImage::find($id);
        $img_dirs = ['small','medium','large','original'];
        foreach($img_dirs as $img_dir)
        {
            $file = public_path("files/products/".$img_dir."/".$image->filename);
            if(file_exists($file))
                unlink($file);
        }

        $query = $image->delete();

        if($query)
            return response()->json(['code' => 1,'msg'  => 'Termékkép sikeresen törölve'], 200);
        else
            return response()->json(['code' => 0,'msg'  => 'Hiba! Termékkép nincs törölve'], 200);
    }
}
