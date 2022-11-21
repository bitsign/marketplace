<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;


class ProductTranslationImport implements WithHeadingRow, WithProgressBar, ToCollection
{
    use Importable;
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $url = $row['translation_id'] !== NULL 
                    ? create_unique_url('product_translations',Str::slug($row['name']),$row['translation_id']) 
                    : create_unique_url('product_translations',Str::slug($row['name']));
            $tr_datas['product_id']       = $row['product_id'];
            $tr_datas['name']             = $row['name'];
            $tr_datas['url']              = $url;
            $tr_datas['short_details']    = $row['short_details'];
            $tr_datas['details']          = $row['details'];
            $tr_datas['meta_title']       = $row['meta_title'];
            $tr_datas['meta_keywords']    = $row['meta_keywords'];
            $tr_datas['meta_description'] = $row['meta_description'];
            $tr_datas['lang']             = $row['lang'];

            if($row['translation_id'] !== NULL) 
                ProductTranslation::where('id',$row['translation_id'])->update($tr_datas);
            else
                ProductTranslation::create($tr_datas);
        }
    }
}
