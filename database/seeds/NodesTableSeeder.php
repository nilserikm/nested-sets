<?php

use Illuminate\Database\Seeder;

class NodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = microtime(true);

        $numBuildings = 3;
        $numPhases = 7;
        $numApartments = 20;
        $numActivities = 25;

        for ($i = 0; $i < $numBuildings; $i++) {
            $root = new \App\Node();
            $root->title = "building " . $i;
            $root->saveAsRoot();

            $activities = [];
            for ($j = 0; $j < $numActivities; $j++) {
                array_push($activities, [
                    'title' => 'activity ' . $j,
                ]);
            }

            $apartments = [];
            for ($k = 0; $k < $numApartments; $k++) {
                array_push($apartments, [
                    'title' => 'apartment ' . $k,
                    'children' => $activities
                ]);
            }

            $phases =[];
            for ($m = 0; $m < $numPhases; $m++) {
                $phase = \App\Node::create([
                    'title' => 'phase ' . $m,
                    'children' => $apartments
                ]);
                array_push($phases, $phase);
            }

            foreach ($phases as $phase) {
                $root->appendNode($phase);
            }
        }

        $this->command->info("time: " . ((microtime(true) - $start)));
    }
}
