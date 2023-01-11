<?php

use App\WakalahApplication;
use Illuminate\Database\Seeder;

class WakalahApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WakalahApplication::factory()->count(50)->create();
    }
}
