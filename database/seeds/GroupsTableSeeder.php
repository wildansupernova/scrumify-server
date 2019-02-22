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
        factory(App\Groups::class, 15)->create()->each(function ($groups) {
            $members = Rand(5, 9);
            $groupsMember = factory(App\GroupsMember::class, $members)->make();
            $groups->members()->saveMany($groupsMember);
        });
    }
}
