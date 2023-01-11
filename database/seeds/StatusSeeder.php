<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'status_name' => 'approved',
            'display_name' => 'Approved',
            'status_color' => 'success',
        ]);
        Status::create([
            'status_name' => 'rejected',
            'display_name' => 'Rejected',
            'status_color' => 'danger',
        ]);
        Status::create([
            'status_name' => 'pending',
            'display_name' => 'Pending',
            'status_color' => 'warning',
        ]);

    }
}