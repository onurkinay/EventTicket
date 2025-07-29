<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketCategory::create([
            'category' => 'General Admission',
            'price' => 100.00, // Example price

        ])->update(['created_at' => now(), 'updated_at' => now()]);

        TicketCategory::create([
            'category' => 'VIP',
            'price' => 200.00, // Example price
        ])->update(['created_at' => now(), 'updated_at' => now()]);
    }
}
