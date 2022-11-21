<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
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
                    "name",
                    "categories",
                    "product_number",
                    "manufacturer_id",
                    "published", 
                    "featured",
                    "available", 
                    "free_shipping", 
                    "shipping_cost", 
                    "warranty",
                    "stock",
                    "unit_id",
                    "reward",
                    "weight",
                    "price",
                    "action_price",
                    "action_start_date",
                    "action_end_date",
                    DB::raw("GROUP_CONCAT(DISTINCT pi.filename separator '|') as images"),
                    "attributes",
                    "grouped",
                    "ap.attached_product_id")
                ->leftJoin('attached_products AS ap', 'p.id', '=', 'ap.product_id')
                ->leftJoin('product_images AS pi', 'p.id', '=', 'pi.product_id')
                ->groupBy('p.id');
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
                "name",
                "categories",
                "product_number",
                "manufacturer_id",
                "published", 
                "featured",
                "available", 
                "free_shipping", 
                "shipping_cost", 
                "warranty",
                "stock",
                "unit_id",
                "reward",
                "weight",
                "price",
                "action_price",
                "action_start_date",
                "action_end_date",
                "images",
                "attributes",
                "grouped",
                "attached_products"
            ];
    }
}
