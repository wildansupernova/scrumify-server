<?php

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        factory(App\Comment::class, 1000)->create();
    }
}
