<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Venue::create([
            'name' => 'İstanbul Devlet Tiyatrosu',
            'address' => 'Şehit Muhtar Mahallesi, İstiklal Cd. No: 163, 34433 Beyoğlu/İstanbul, Türkiye',
        ])->update(['created_at' => Date::now(), 'updated_at' => Date::now()]);

        Venue::create([
            'name' => 'Atatürk Kültür Merkezi',
            'address' => 'Taksim Meydanı, 34437 Beyoğlu/İstanbul, Türkiye',
        ])->update(['created_at' => Date::now(), 'updated_at' => Date::now()]);

        Venue::create([
            'name' => 'Ankara Devlet Tiyatrosu',
            'address' => 'Talatpaşa Blv. No: 21, 06420 Çankaya/Ankara, Türkiye',
        ])->update(['created_at' => Date::now(), 'updated_at' => Date::now()]);

        Venue::create([
            'name' => 'İzmir Devlet Tiyatrosu',
            'address' => 'Kültürpark, 35220 Konak/İzmir, Türkiye',
        ])->update(['created_at' => Date::now(), 'updated_at' => Date::now()]);
    }
}
