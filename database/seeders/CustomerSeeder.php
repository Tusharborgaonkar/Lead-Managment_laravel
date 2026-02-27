<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Acme Corporation',
                'phone' => '+1 800-555-1234',
                'email' => 'contact@acmecorp.com',
                'company_name' => 'Acme Corp',
            ],
            [
                'name' => 'Jane Smith',
                'phone' => '+1 800-555-9876',
                'email' => 'jane.smith@globaltech.io',
                'company_name' => 'Global Tech',
            ]
        ];

        foreach ($customers as $data) {
            Customer::create($data);
        }
    }
}
