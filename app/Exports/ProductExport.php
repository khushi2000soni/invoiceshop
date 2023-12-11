<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $category_id;
    protected $product_id;

    public function __construct($category_id,$product_id)
    {
        $this->category_id = $category_id;
        $this->product_id = $product_id;
    }


    public function collection()
    {
        //return Product::all()->map(function ($product, $key) {
            
            $query = Product::query();
            if ($this->category_id !== null && $this->category_id != 'null') {
                $query->where('category_id', $this->category_id);
            }
            if ($this->product_id !== null) {
                $query->where('id', $this->product_id);
            }    
            $products = $query->orderBy('id','desc')->get();    
            return $products->map(function ($product, $key) {
            return [
                'Sn.' => $key + 1,
                'Item Name' => $product->name,
                'Category Name' => $product->category->name ?? '',
                'Created At' => $product->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ["Sn.", "Item Name" , "Category Name" , "Created At"];
    }
}
