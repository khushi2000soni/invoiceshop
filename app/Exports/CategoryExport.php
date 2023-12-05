<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::all()->map(function ($category, $key) {
            return [
                'Sn.' => $key + 1,
                'Name' => $category->name,
                'No. of Customer' => $category->products->count() ?? 0,
                'Created At' => $category->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ["Sn.", "Name" , "No. of Products" , "Created At"];
    }

}
