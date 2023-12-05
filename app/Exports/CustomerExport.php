<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $address_id;

    public function __construct($address_id)
    {
        $this->address_id = $address_id;
    }

    public function collection()
    {

        $query = Customer::query();

        if ($this->address_id !== null) {
            $query->where('address_id', $this->address_id);
        }

        $customers = $query->get();

        return $customers->map(function ($customer, $key) {
            return [
                'Sn.' => $key + 1,
                'Name' => $customer->name ?? '',
                'Husband/Guardian Name' => $customer->guardian_name ?? '',
                'Phone no.' => $customer->phone ?? '',
                'Alternate Ph no.' => $customer->phone2 ?? '',
                'City' => $customer->address->address ?? '',
                'Created At' => $customer->created_at->format('d-m-Y'),
            ];
        });

    }

    public function headings(): array
    {
        return ["Sn.", "Name" , "Husband/Guardian Name" , "Phone no.", "Alternate Ph no.", "City","Created At"];
    }
}
