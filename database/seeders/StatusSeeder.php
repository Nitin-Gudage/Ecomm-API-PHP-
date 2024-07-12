<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Status::count() == 0){
            $data = [
                ['name' => 'new'],
                ['name' => 'accepted'],
                ['name' => 'out_of_delivery'],
                ['name' =>'deliverd'],
                ['name' => 'reject'],
             
            ];
            Status::insert($data);
        }
    }
}
