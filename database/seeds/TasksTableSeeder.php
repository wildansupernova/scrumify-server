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
        //
        $tasks = [
            [
                'group_id' => 1,
                'taskname' => 'Bikin BlockChain',
                'description' => 'Yeah Mancuyyy',
                'status_kanban' => Config::get('constants.STATUS_KANBAN.PRODUCT_BACKLOG')
            ],
            [
                'group_id' => 1,
                'taskname' => 'Bikin BlockChain',
                'description' => 'Yeah Mancuyyy',
                'status_kanban' => Config::get('constants.STATUS_KANBAN.OPEN')
            ],
            [
                'group_id' => 2,
                'taskname' => 'Bikin BlockChain',
                'description' => 'Yeah Mancuyyy',
                'status_kanban' => Config::get('constants.STATUS_KANBAN.PRODUCT_BACKLOG')
            ],
            [
                'group_id' => 2,
                'taskname' => 'Bikin BlockChain',
                'description' => 'Yeah Mancuyyy',
                'status_kanban' => Config::get('constants.STATUS_KANBAN.OPEN')
            ],
        ];
        foreach ($tasks as $element) {
            App\Task::create($element);
        }
    }
}
