<?php

use Illuminate\Database\Seeder;

class TasksMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taskMembers = [
            [
                'task_id' => 1,
                'user_id' => 1,
            ],
            [
                'task_id' => 2,
                'user_id' => 2,
            ],
            [
                'task_id' => 3,
                'user_id' => 1,
            ],
        ];
        foreach ($taskMembers as $element) {
            App\TasksMember::create($element);
        }
    }
}
