<?php

namespace App\Http\Controllers;

use App\CalcNode;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function deleteNode(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;

        $root = \App\CalcNode::find(1);
        $node = \App\CalcNode::find($request->input('nodeId'));

        if (empty($root)) {
            $message = "Root not found ...";
        } else if (empty($node)) {
            $message = "Node not found ...";
        } else {
            try {
                $node->delete();

                $success = true;
                $httpCode = 200;
                $message = "Node deleted ...";
            } catch(\Exception $exception) {
                $message = $exception->getMessage();
                $httpCode = $exception->getCode();
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'allCount' => $this->getCount(),
            'time' => microtime(true) - $start
        ], $httpCode);
    }

    public function createNode(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;

        $root = \App\CalcNode::find(1);
        $parent = \App\CalcNode::find($request->input('parentId'));

        if (empty($root)) {
            $message = "Root not found ...";
        } else if (empty($parent)) {
            $message = "Parent node not found ...";
        } else {
            $node = new \App\CalcNode();
            $node->title = "new insert node ...";
            $parent->appendNode($node);

            $success = true;
            $httpCode = 200;
            $message = "Node inserted ...";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'allCount' => $this->getCount(),
            'time' => microtime(true) - $start
        ], $httpCode);
    }

    /**
     * Returns the initial fetch of the entire tree/table/nodes
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchTree(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;

        if (true) {
            $success = true;
            $httpCode = 200;
            $message = "Tree fetched ...";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'allCount' => $this->getCount(),
            'time' => microtime(true) - $start
        ], $httpCode);
    }

    /**
     * Returns the count of nodes in the tree, including the root
     * @return int
     */
    public function getCount()
    {
        return \App\CalcNode::count();
    }

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
