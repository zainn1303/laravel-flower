<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Input to Users table, this table is for Manager Level only
        DB::table('users')->insert([
            'name' => 'ManagerCoba',
            'email' => 'manager@gmail.com',
            'password' => 'manager_12345',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // Input to Customers table, this table is for Customer Level only
        DB::table('customers')->insert([
            'username' => 'UserCoba',
            'email' => 'user@gmail.com',
            'password' => 'user_12345',
            'gender' => 'L',
            'birthday' => "2000-03-13",
            'address' => "Jl. Coba Saja No. 36",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        //Input to Categories 
        DB::table('categories')->insert([
            'name' => 'Cascade Bouquet',
            'image' => 'cascade.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('categories')->insert([
            'name' => 'Composite Bouquet',
            'image' => 'composite.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('categories')->insert([
            'name' => 'Hand Tied Bouquet',
            'image' => 'hand_tied.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
