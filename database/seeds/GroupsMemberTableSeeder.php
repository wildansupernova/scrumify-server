<?php

use Illuminate\Database\Seeder;

class GroupsMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupsMember = [
            [
                'group_id' => 1,
                'user_id' => 1,
            ],
            [
                'group_id' => 1,
                'user_id' => 2,
            ],
            [
                'group_id' => 2,
                'user_id' => 1,
            ],
        ];

        foreach ($groupsMember as $element) {
            App\GroupMember::create($element);
        }
    }
}
