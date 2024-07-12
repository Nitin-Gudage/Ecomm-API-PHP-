<?php

namespace Database\Seeders;
use App\Models\Setting;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            if (Setting::count() == 0) {
                $data = [
                    ['key' => 'terms_conditions', 'value' => ''],
                    ['key' => 'privacy_policy', 'value' => ''],
                    ['key' => 'copyright', 'value' => ''],
                    ['key' => 'Website_title', 'value' => ''],
                    ['key' => 'title_descriptions', 'value' => ''],
                    ['key' => 'logo', 'value' => ''],
                    ['key' => 'mobile_logo', 'value' => ''],
                    ['key' => 'favicon_logo', 'value' => ''],
                    ['key' => 'smtp_credential', 'value' => json_encode([
                        "host" => "zzz",
                        "port" => "zz",
                        "username" => "itzpatilmayur@gmail.com",
                        "password" => "zz",
                        "from" => "zz",
                        "name" => "zz"
                    ])],
                    ['key' => 'prefix', 'value' => ''],
                    ['key' => 'working_days', 'value' => json_encode([
                        "Monday" => true,
                        "Tuesday" => true,
                        "Wednesday" => true,
                        "Thursday" => true,
                        "Friday" => true,
                        "Saturday" => true,
                        "Sunday" => true
                    ])],
                    ['key' => 'working_time', 'value' => json_encode(["start_time" => null, "end_time" => null])]
                ];
                Setting::insert($data);
            }
        }
    }
}
