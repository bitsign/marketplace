<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductTranslationsExport implements FromCollection, WithHeadings
{

    public function __construct($product_ids="")
    {
        $this->product_ids = $product_ids;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Product::from('products AS p')
                ->select(
                    "p.id",
                    "pt.id as translation_id",
                    "pt.name",
                    "url",
                    "short_details",
                    "details",
                    "meta_title",
                    "meta_keywords",
                    "meta_description",
                    "lang")
                ->leftJoin('product_translations AS pt', 'p.id', '=', 'pt.product_id')
                ->orderBy('pt.id');
        if($this->product_ids !== NULL)
            $query = $query->whereIn('p.id',$this->product_ids);

        return $query->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["product_id",
                "translation_id",
                "name",
                "url",
                "short_details",
                "details",
                "meta_title",
                "meta_keywords",
                "meta_description",
                "lang",
            ];
    }
}
