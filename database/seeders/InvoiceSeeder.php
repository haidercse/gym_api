<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 25) as $invoice) {
            Invoice::create([
                'member_id' => date('Y').str_pad($invoice,6,0,STR_PAD_LEFT),
                'create_by' => rand(1,10),
                'start_date' => date('Y-m-d'),
                'end_date' => date('Y-m-d', strtotime('+3 month')),
                'amount' => rand(500,1000),
                'fee_type' => 1,
                'payment_type' => 1
            ]);
        }
    }
}