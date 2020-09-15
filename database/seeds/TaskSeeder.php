<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task1 = new \App\Task();
        $task1->task_name = "Matematikos namu darbai";
        $task1->task_description = "Atlikti matematikos namu darbus, butinai pasimokinti kodel x = 5";
        $task1->status_id = 2;
        $task1->add_date = date_format(date_add(date_create(), date_interval_create_from_date_string("3 days")), "Y-m-d");
        $task1->save();

        $task2 = new \App\Task();
        $task2->task_name = "Programavimo namu darbai";
        $task2->task_description = "Atlikti programavimo namu darbus, butinai pasimokinti apie masyvus";
        $task2->status_id = 2;
        $task2->add_date = date_format(date_add(date_create(), date_interval_create_from_date_string("7 days")), "Y-m-d");
        $task2->save();
    }
}
