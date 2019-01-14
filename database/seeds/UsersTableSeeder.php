<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'role_id' => '1',
            'name' => 'Alan Dantas',
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'MD.Author',
            'username' => 'author',
            'email' => 'author@mail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Angelina',
            'username' => 'angel',
            'email' => 'angel@mail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
