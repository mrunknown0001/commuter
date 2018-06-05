<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
        

		// admin user
        DB::table('admins')->insert([
        	'username' => 'admin',
        	'first_name' => 'Admin',
        	'last_name' => 'Admin',
        	'password' => bcrypt('control'),
        	'role' => 1,
            'active' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);


        // locations
        DB::table('locations')->insert([
            'name' => 'TSU San Isidro Campus'
        ]);

        DB::table('locations')->insert([
            'name' => 'TSU Main Campus'
        ]);

        // commuter & driver
        DB::table('users')->insert([
            [
                'first_name' => 'Juan',
                'last_name' => 'Cruz',
                'identification' => '11111',
                'user_type' => 1,
                'mobile_number' => '09156111111',
                'password' => bcrypt('commuter')
            ],
            [
                'first_name' => 'Juancho',
                'last_name' => 'Dela Cruz',
                'identification' => '22222',
                'user_type' => 1,
                'mobile_number' => '09156222222',
                'password' => bcrypt('commuter')
            ],
            [
                'first_name' => 'Jose',
                'last_name' => 'Leon',
                'identification' => '55555',
                'user_type' => 2,
                'mobile_number' => '09106333333',
                'password' => bcrypt('driver')
            ],
            [
                'first_name' => 'Chavit',
                'last_name' => 'Driver',
                'identification' => '99999',
                'user_type' => 2,
                'mobile_number' => '09106444444',
                'password' => bcrypt('driver')
            ]
        ]);


        
    }
}
