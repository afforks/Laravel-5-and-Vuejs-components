<?php

use App\City;
use App\Country;
use App\State;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Country::truncate();
        State::truncate();
        City::truncate();
        $countries = [
        	['name'=>'India'],
        	['name'=>'US']
        ];
        $states =[
        	['country_id'=>1,'name'=>'Gujrat'],
        	['country_id'=>1,'name'=>'Maharashtra'],
        	['country_id'=>2,'name'=>'New York'],
        ];
        $cities=[
        	['state_id'=>1,'name'=>'Rajkot'],
        	['state_id'=>1,'name'=>'Ahmedabad'],
        	['state_id'=>2,'name'=>'Mumbai'],
        	['state_id'=>3,'name'=>'New York'],
        ];

        Country::insert($countries);
        State::insert($states);
        City::insert($cities);

    }
}
