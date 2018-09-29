<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'glucas#1948',
            'provider' => 'battlenet-stateful',
            'provider_id' => '52005551',
            'battlenet_region_default' => 'us',
            'created_at' => '2018-09-28 06:26:08',
            'updated_at' => '2018-09-28 06:26:08',
        ]);
    }
}
