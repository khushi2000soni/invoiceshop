<?php

namespace App\Exports;

use App\Models\Address;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AddressExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Address::all()->map(function ($address, $key) {
            return [
                'Sn.' => $key + 1,
                'Address' => $address->address,
                'No. of Customer' => $address->customers->count() ?? 0,
                'Created At' => $address->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ["Sn.", "Address" , "No. of Customer" , "Created At"];
    }

}
