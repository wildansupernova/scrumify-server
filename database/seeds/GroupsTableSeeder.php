<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupsArr = [
            [
                'group_name' => 'group1',
                'description' => 'group1yeah',
            ],
            [
                'group_name' => 'group2',
                'description' => 'group2yeah',
            ],
            [
                'group_name' => 'group3',
                'description' => 'group3yeah',
            ]
        ];

        foreach ($groupsArr as $element) {
            App\Group::create($element);
        }
    }
}
