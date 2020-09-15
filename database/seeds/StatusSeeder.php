<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status1 = new \App\Status();
        $status1->name = "Done";
        $status1->save();

        $status2 = new \App\Status();
        $status2->name = "In proggress";
        $status2->save();

        $status3 = new \App\Status();
        $status3->name = "Done";
        $status3->save();
    }
}
