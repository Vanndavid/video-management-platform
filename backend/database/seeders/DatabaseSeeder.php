<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        Listing::factory()->create(['title'=>'12 Sample St','address'=>'Richmond VIC']);
        Listing::factory()->create(['title'=>'9 Ocean Ave','address'=>'St Kilda VIC']);
    }
}
