<?php

namespace App\Imports;

use App\Models\AttachedProduct;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements WithHeadingRow, ToCollection
{
    use Importable;
    public function collection(Collection $rows)
    {
        $datas = array();
        $img_arr = array();
        foreach ($rows as $row) 
        {
            if($row['images'] !== NULL)
                $img_arr = explode('|', $row['images']);

            $datas['name']             = $row['name'];
            $datas['categories']       = $row['categories'];
            $datas['product_number']   = $row['product_number'];
            $datas['manufacturer_id']  = $row['manufacturer_id'];
            $datas['published']        = $row['published'];
            $datas['featured']         = $row['featured'];
            $datas['available']        = $row['available'];
            $datas['free_shipping']    = $row['free_shipping'];
            $datas['shipping_cost']    = $row['shipping_cost'];
            $datas['warranty']         = $row['warranty'];
            $datas['stock']            = $row['stock'];
            $datas['unit_id']          = $row['unit_id'];
            $datas['reward']           = $row['reward'];
            $datas['weight']           = $row['weight'];
            $datas['price']            = $row['price'];
            $datas['action_price']     = $row['action_price'];
            $datas['action_start_date']= $row['action_start_date'];
            $datas['action_end_date']  = $row['action_end_date'];
            $datas['attributes']       = $row['attributes'];
            $datas['grouped']          = $row['grouped'];
            
            $categories = explode(',',$datas['categories']);

            if($row['product_id'] !== NULL)
            {
                $product = Product::whereId($row['product_id'])->first();
                $product->whereId($row['product_id'])->update($datas);
                $product->categories()->sync([]);
                if(!empty($categories[0]))
                {
                    $product->categories()->attach($categories);
                }
            }
            else
            {
                $product = Product::create($datas);
                if(!empty($categories[0]))
                    $product->categories()->attach($categories);
                //alapértlemezett fordítás létrehozása
                foreach(config('app.available_locales') as $lang)
                {
                    $tr_datas['product_id'] = $product->id;
                    $tr_datas['name'] = $lang == $row['lang'] ? $row['name'] : NULL;
                    $tr_datas['url']  = $lang == $row['lang'] ? create_unique_url('product_translations',Str::slug($row['name'])) : NULL;
                    $tr_datas['lang'] = $lang;
                    ProductTranslation::create($tr_datas);
                }
            }

            if(!empty($img_arr))
            {
                ProductImage::whereProduct_id($product->id)->delete();
                foreach($img_arr as $key => $img)
                {
                    $name                   = explode(".",$img);
                    $im_datas['product_id'] = $product->id;
                    $im_datas['filename']   = $img;
                    $im_datas['default']    = $key == 0 ? 1 : 0;
                    $im_datas['alt']        = $name[0];
                    $im_datas['title']      = $name[0];
                    ProductImage::create($im_datas);
                }
            }

            if(!empty($row['attached_products']))
                AttachedProduct::updateOrCreate(['product_id'=>$product->id,'attached_product_id'=>$row['attached_products']]);
        }
    }
}
