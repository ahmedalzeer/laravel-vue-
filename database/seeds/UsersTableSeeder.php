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
            'name'      =>'ahmed',
            'password'  =>bcrypt('123456'),
            'email'     =>'ahmed@a.com',
            'role'      =>'admin',
            'created_at'=>time(),
            'updated_at'=>time()
        ]);
    }
}
