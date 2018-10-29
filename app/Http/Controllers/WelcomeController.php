<?php

namespace App\Http\Controllers;

use App\CalcNode;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome(Request $request)
    {
        $roots = CalcNode::whereIsRoot()->get();
        $nonEmptyRoots = CalcNode::hasChildren()->get();
        $rootTwo = CalcNode::find(1);
        $rootTwoDescendants = $rootTwo->descendants;
        $tree = CalcNode::whereDescendantOrSelf(1)->get();
        $traversed = $tree->toTree();

        return view('tree-experimentation')->with([
            'roots' => $roots,
            'nonEmptyRoots' => $nonEmptyRoots,
            'rootTwo' => $rootTwo,
            'rootTwoDescendants' => $rootTwoDescendants,
            'tree' => json_encode($tree, JSON_PRETTY_PRINT),
            'traversed' => $traversed
        ]);
    }

    public function traverseNodes($nodes)
    {
        $traverse = function ($categories, $prefix = '-') use (&$traverse) {
            foreach ($categories as $category) {
                echo PHP_EOL.$prefix.' '.$category->name;

                $traverse($category->children, $prefix.'-');
            }
        };

        return $traverse($nodes);
    }
}
