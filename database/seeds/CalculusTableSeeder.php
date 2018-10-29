<?php

use Illuminate\Database\Seeder;

class CalculusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = microtime(true);
        $startSecond = microtime(true);

        // INITIAL SEEDER
        $treeTwoRoot = new \App\CalcNode();
        $treeTwoRoot->title = "rootTwo node ...";
        $treeTwoRoot->estimate = 1;
        $treeTwoRoot->saveAsRoot();

        $treeTwoChildOne = new \App\CalcNode();
        $treeTwoChildOne->title = "rootTwo child one";
        $treeTwoChildOne->estimate = 1;

        $treeTwoChildTwo = new \App\CalcNode();
        $treeTwoChildTwo->title = "rootTwo child two";
        $treeTwoChildTwo->estimate = 1;

        $treeTwoRoot->appendNode($treeTwoChildOne);
        $treeTwoRoot->appendNode($treeTwoChildTwo);

        $treeTwoChildOneSubtree = new \App\CalcNode();
        $treeTwoChildOneSubtree->title = "rootTwo sub one child one";
        $treeTwoChildOneSubtree->estimate = 1;
        $treeTwoChildOne->appendNode($treeTwoChildOneSubtree);

        // NEW SEEDER
        $level5 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level5, [
                'title' => 'level5' . "-" . $i,
                'estimate' => 5
            ]);
        }

        $level4 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level4, [
                'title' => 'level4' . "-" . $i,
                'estimate' => 4,
                'children' => $level5
            ]);
        }

        $level3 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level3, [
                'title' => 'level3' . "-" . $i,
                'estimate' => 3,
                'children' => $level4
            ]);
        }

        $level2 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level2, [
                'title' => 'level2' . "-" . $i,
                'estimate' => 2,
                'children' => $level3
            ]);
        }

        $level1 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level1, [
                'title' => 'level1' . "-" . $i,
                'estimate' => 1,
                'children' => $level2
            ]);
        }

        $node = \App\CalcNode::create([
            'title' => "nalle",
            'estimate' => 123,
            'children' => $level1
        ]);

        $this->command->info("\n--------------------------------------------------\n");
        $this->command->info("NalleSeeder :: Total time: " . (microtime(true) - $start) . "s");

        $testStart = microtime(true);

        $testNode = new \App\CalcNode();
        $testNode->title = "test node";
        $testNode->estimate = 123;
        $node->appendNode($testNode);


        $testNodeTwoStart = microtime(true);
        $testNodeTwo = new \App\CalcNode();
        $testNodeTwo->title = "rootTwo child two";
        $testNodeTwo->estimate = 1;

        $treeTwoRoot->appendNode($testNodeTwo);
        $this->command->info("testnode2: " . (microtime(true) - $testNodeTwoStart) . "s");


        $this->command->info("testnode: " . (microtime(true) - $testStart) . "s");
        $this->command->info("the real total time: " . ((microtime(true) - $startSecond)));










        $start = microtime(true);
        $startSecond = microtime(true);

        // INITIAL SEEDER
        $treeTwoRoot = new \App\CalcNode();
        $treeTwoRoot->title = "rootTwo node ...";
        $treeTwoRoot->estimate = 1;
        $treeTwoRoot->saveAsRoot();

        $treeTwoChildOne = new \App\CalcNode();
        $treeTwoChildOne->title = "rootTwo child one";
        $treeTwoChildOne->estimate = 1;

        $treeTwoChildTwo = new \App\CalcNode();
        $treeTwoChildTwo->title = "rootTwo child two";
        $treeTwoChildTwo->estimate = 1;

        $treeTwoRoot->appendNode($treeTwoChildOne);
        $treeTwoRoot->appendNode($treeTwoChildTwo);

        $treeTwoChildOneSubtree = new \App\CalcNode();
        $treeTwoChildOneSubtree->title = "rootTwo sub one child one";
        $treeTwoChildOneSubtree->estimate = 1;
        $treeTwoChildOne->appendNode($treeTwoChildOneSubtree);

        // NEW SEEDER
        $level5 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level5, [
                'title' => 'level5' . "-" . $i,
                'estimate' => 5
            ]);
        }

        $level4 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level4, [
                'title' => 'level4' . "-" . $i,
                'estimate' => 4,
                'children' => $level5
            ]);
        }

        $level3 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level3, [
                'title' => 'level3' . "-" . $i,
                'estimate' => 3,
                'children' => $level4
            ]);
        }

        $level2 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level2, [
                'title' => 'level2' . "-" . $i,
                'estimate' => 2,
                'children' => $level3
            ]);
        }

        $level1 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level1, [
                'title' => 'level1' . "-" . $i,
                'estimate' => 1,
                'children' => $level2
            ]);
        }

        $node = \App\CalcNode::create([
            'title' => "nalle",
            'estimate' => 123,
            'children' => $level1
        ]);

        $this->command->info("\n--------------------------------------------------\n");
        $this->command->info("NalleSeeder :: Total time: " . (microtime(true) - $start) . "s");

        $testStart = microtime(true);

        $testNode = new \App\CalcNode();
        $testNode->title = "test node";
        $testNode->estimate = 123;
        $node->appendNode($testNode);


        $testNodeTwoStart = microtime(true);
        $testNodeTwo = new \App\CalcNode();
        $testNodeTwo->title = "rootTwo child two";
        $testNodeTwo->estimate = 1;

        $treeTwoRoot->appendNode($testNodeTwo);
        $this->command->info("testnode2: " . (microtime(true) - $testNodeTwoStart) . "s");


        $this->command->info("testnode: " . (microtime(true) - $testStart) . "s");
        $this->command->info("the real total time: " . ((microtime(true) - $startSecond)));



        $start = microtime(true);
        $startSecond = microtime(true);

        // INITIAL SEEDER
        $treeTwoRoot = new \App\CalcNode();
        $treeTwoRoot->title = "rootTwo node ...";
        $treeTwoRoot->estimate = 1;
        $treeTwoRoot->saveAsRoot();

        $treeTwoChildOne = new \App\CalcNode();
        $treeTwoChildOne->title = "rootTwo child one";
        $treeTwoChildOne->estimate = 1;

        $treeTwoChildTwo = new \App\CalcNode();
        $treeTwoChildTwo->title = "rootTwo child two";
        $treeTwoChildTwo->estimate = 1;

        $treeTwoRoot->appendNode($treeTwoChildOne);
        $treeTwoRoot->appendNode($treeTwoChildTwo);

        $treeTwoChildOneSubtree = new \App\CalcNode();
        $treeTwoChildOneSubtree->title = "rootTwo sub one child one";
        $treeTwoChildOneSubtree->estimate = 1;
        $treeTwoChildOne->appendNode($treeTwoChildOneSubtree);

        // NEW SEEDER
        $level5 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level5, [
                'title' => 'level5' . "-" . $i,
                'estimate' => 5
            ]);
        }

        $level4 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level4, [
                'title' => 'level4' . "-" . $i,
                'estimate' => 4,
                'children' => $level5
            ]);
        }

        $level3 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level3, [
                'title' => 'level3' . "-" . $i,
                'estimate' => 3,
                'children' => $level4
            ]);
        }

        $level2 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level2, [
                'title' => 'level2' . "-" . $i,
                'estimate' => 2,
                'children' => $level3
            ]);
        }

        $level1 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level1, [
                'title' => 'level1' . "-" . $i,
                'estimate' => 1,
                'children' => $level2
            ]);
        }

        $node = \App\CalcNode::create([
            'title' => "nalle",
            'estimate' => 123,
            'children' => $level1
        ]);

        $this->command->info("\n--------------------------------------------------\n");
        $this->command->info("NalleSeeder :: Total time: " . (microtime(true) - $start) . "s");

        $testStart = microtime(true);

        $testNode = new \App\CalcNode();
        $testNode->title = "test node";
        $testNode->estimate = 123;
        $node->appendNode($testNode);


        $testNodeTwoStart = microtime(true);
        $testNodeTwo = new \App\CalcNode();
        $testNodeTwo->title = "rootTwo child two";
        $testNodeTwo->estimate = 1;

        $treeTwoRoot->appendNode($testNodeTwo);
        $this->command->info("testnode2: " . (microtime(true) - $testNodeTwoStart) . "s");


        $this->command->info("testnode: " . (microtime(true) - $testStart) . "s");
        $this->command->info("the real total time: " . ((microtime(true) - $startSecond)));


        $start = microtime(true);
        $startSecond = microtime(true);

        // INITIAL SEEDER
        $treeTwoRoot = new \App\CalcNode();
        $treeTwoRoot->title = "rootTwo node ...";
        $treeTwoRoot->estimate = 1;
        $treeTwoRoot->saveAsRoot();

        $treeTwoChildOne = new \App\CalcNode();
        $treeTwoChildOne->title = "rootTwo child one";
        $treeTwoChildOne->estimate = 1;

        $treeTwoChildTwo = new \App\CalcNode();
        $treeTwoChildTwo->title = "rootTwo child two";
        $treeTwoChildTwo->estimate = 1;

        $treeTwoRoot->appendNode($treeTwoChildOne);
        $treeTwoRoot->appendNode($treeTwoChildTwo);

        $treeTwoChildOneSubtree = new \App\CalcNode();
        $treeTwoChildOneSubtree->title = "rootTwo sub one child one";
        $treeTwoChildOneSubtree->estimate = 1;
        $treeTwoChildOne->appendNode($treeTwoChildOneSubtree);

        // NEW SEEDER
        $level5 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level5, [
                'title' => 'level5' . "-" . $i,
                'estimate' => 5
            ]);
        }

        $level4 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level4, [
                'title' => 'level4' . "-" . $i,
                'estimate' => 4,
                'children' => $level5
            ]);
        }

        $level3 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level3, [
                'title' => 'level3' . "-" . $i,
                'estimate' => 3,
                'children' => $level4
            ]);
        }

        $level2 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level2, [
                'title' => 'level2' . "-" . $i,
                'estimate' => 2,
                'children' => $level3
            ]);
        }

        $level1 = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($level1, [
                'title' => 'level1' . "-" . $i,
                'estimate' => 1,
                'children' => $level2
            ]);
        }

        $node = \App\CalcNode::create([
            'title' => "nalle",
            'estimate' => 123,
            'children' => $level1
        ]);

        $this->command->info("\n--------------------------------------------------\n");
        $this->command->info("NalleSeeder :: Total time: " . (microtime(true) - $start) . "s");

        $testStart = microtime(true);

        $testNode = new \App\CalcNode();
        $testNode->title = "test node";
        $testNode->estimate = 123;
        $node->appendNode($testNode);


        $testNodeTwoStart = microtime(true);
        $testNodeTwo = new \App\CalcNode();
        $testNodeTwo->title = "rootTwo child two";
        $testNodeTwo->estimate = 1;

        $treeTwoRoot->appendNode($testNodeTwo);
        $this->command->info("testnode2: " . (microtime(true) - $testNodeTwoStart) . "s");


        $this->command->info("testnode: " . (microtime(true) - $testStart) . "s");
        $this->command->info("the real total time: " . ((microtime(true) - $startSecond)));
    }
}
