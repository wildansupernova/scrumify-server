<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Tasks::class, 200)->create()->each(function ($task) {
            $pic = factory(App\TasksMember::class)->make();
            $task->pic()->save($pic);
        });
    }
}
