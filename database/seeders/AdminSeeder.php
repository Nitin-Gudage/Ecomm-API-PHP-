<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::count() == 0){
            $item = new User;
            $item->role_id = 1;
            $item->name = "Admin";
            $item->email = "admin@absax.com";
            $item->password = Hash::make("12345678");
            $item->save();
        }
    }
}
