<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Orderstatus;


class OrderstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { $orderstatuses = [
        ['name' => 'pending'],
        ['name' => 'Order complete'],
        ['name' => 'out of delivery'],
       
    ];
    
    Orderstatus::insert($orderstatuses);
   
    }
}
