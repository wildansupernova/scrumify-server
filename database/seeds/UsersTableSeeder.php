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
        //
        $usersArr = [
            [
                'name' => 'Wildan',
                'email' => 'alnataraw@gmail.com',
                'google_id' => '11111111',
            ],
            [
                'name' => 'dion',
                'email' => 'dion@gmail.com',
                'google_id' => '11111112',
            ],
            [
                'name' => 'farhan',
                'email' => 'farhan@gmail.com',
                'google_id' => '11111113',
            ],
            [
                'name' => 'asadasda',
                'email' => 'asdas@gmail.com',
                'google_id' => '11111114',
            ]
        ];
        
        foreach ($usersArr as $element) {
            $user = App\User::create($element);
        }
    }
}
