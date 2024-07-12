<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Category::count() == 0){
           $obj = new Category;
           $obj->name = "Fruits";
           $obj->is_active = true;
           $obj->save(); 
        }
    }
}
