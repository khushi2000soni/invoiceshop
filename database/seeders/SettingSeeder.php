<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $settings = [
            [
                'key'    => 'site_logo',
                'value'  => null,
                'type'   => 'image',
                'display_name'=>'Site Logo',
                'group'  => 'web',
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
            [
                'key'    => 'favicon',
                'value'  => null,
                'type'   => 'image',
                'display_name'=>'Favicon',
                'group'  => 'web',
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
            [
                'key'    => 'phone_num',
                'value'  =>  null,
                'type'   => 'number',
                'display_name'=>'Phone No.',
                'group'  => 'web',
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
            [
                'key'    => 'thaila_price',
                'value'  =>  null,
                'type'   => 'number',
                'display_name'=>'Thaila Price',
                'group'  => 'web',
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
            [
                'key'    => 'share_invoice_mail_message',
                'value'  => 'Hello Dear, Please check your attached invoice pdf.',
                'type'   => 'text',
                'display_name'=>'Share-Invoice Mail Message',
                'group'  => 'web',
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
            [
                'key'    => 'share_invoice_whatsapp_message',
                'value'  =>  'Hello Dear, Please check your attached invoice pdf.',
                'type'   => 'text',
                'display_name'=>'Share-Invoice Whatsapp Message',
                'group'  => 'web',
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
            [
                'key'    => 'custom_invoice_print_message',
                'value'  =>  'Hello Dear, Please check your invoice Details. If there is any query , kindly contact with us.',
                'type'   => 'text',
                'display_name'=>'Custom Print-Invoice Bottom Message',
                'group'  => 'web',
                'status' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
        ];

        Setting::insert($settings);
    }
}
