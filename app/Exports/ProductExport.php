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
    public function collection()
    {
        return Product::all()->map(function ($product, $key) {
            return [
                'Sn.' => $key + 1,
                'Name' => $product->name,
                'Category Name' => $product->category->name ?? '',
                'Created At' => $product->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ["Sn.", "Name" , "Category Name" , "Created At"];
    }
}
