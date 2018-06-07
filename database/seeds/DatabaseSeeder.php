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
        	'identification' => 'admin',
        	'first_name' => 'Admin',
        	'last_name' => 'Admin',
            'mobile_number' => '09000000000',
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
        // DB::table('users')->insert([
        //     [
        //         'first_name' => 'Juan',
        //         'last_name' => 'Cruz',
        //         'identification' => '11111',
        //         'user_type' => 1,
        //         'mobile_number' => '09156111111',
        //         'password' => bcrypt('commuter')
        //     ],
        //     [
        //         'first_name' => 'Juancho',
        //         'last_name' => 'Dela Cruz',
        //         'identification' => '22222',
        //         'user_type' => 1,
        //         'mobile_number' => '09156222222',
        //         'password' => bcrypt('commuter')
        //     ]
        // ]);


        

        DB::table('admin_ids')->insert([
            [
                'identification' => '2018-0001'
            ],
            [
                'identification' => '2018-0002'
            ],
            [
                'identification' => '2018-0003'
            ],
            [
                'identification' => '2018-0004'
            ],
            [
                'identification' => '2018-0005'
            ],
            [
                'identification' => '2018-0006'
            ],
            [
                'identification' => '2018-0007'
            ],
            [
                'identification' => '2018-0008'
            ],
            [
                'identification' => '2018-0009'
            ],
            [
                'identification' => '2018-0010'
            ],
            [
                'identification' => '2018-0011'
            ],
            [
                'identification' => '2018-0012'
            ],
            [
                'identification' => '2018-0013'
            ],
            [
                'identification' => '2018-0014'
            ],
            [
                'identification' => '2018-0015'
            ],
            [
                'identification' => '2018-0016'
            ],
            [
                'identification' => '2018-0017'
            ],
            [
                'identification' => '2018-0018'
            ],
            [
                'identification' => '2018-0019'
            ],
            [
                'identification' => '2018-0020'
            ]
        ]);

    }
}
