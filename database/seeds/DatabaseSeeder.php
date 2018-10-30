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
            'mobile_number' => '09000000000',
        	'password' => bcrypt('control'),
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


    }
}
