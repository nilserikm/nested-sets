<?php

namespace App\Http\Controllers;

use App\Node;
use Illuminate\Http\Request;
use Kalnoy\Nestedset\Collection;

class WelcomeController extends Controller
{
    public function checkTree(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;
        $isBroken = null;
        $countErrors = null;

        try {
            $isBroken = Node::where('id', 1)->isBroken();
            $countErrors = Node::where('id', 1)->countErrors();

            $success = true;
            $httpCode = 200;
            $message = "Tree checked ...";
        } catch(\Exception $exception) {
            $message = "Something went wrong when checking the tree";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'allCount' => $this->getCount(),
            'time' => microtime(true) - $start,
            'isBroken' => $isBroken,
            'countErrors' => $countErrors
        ], $httpCode);
    }

    public function getRandomNode($node = null)
    {
        if (is_null($node)) {
            $node = \App\Node::find(rand(1, \App\Node::count()));
            return $this->getRandomNode($node);
        }

        return $node;
    }

    public function randomNode(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;

        $root = \App\Node::find(1);

        if (empty($root)) {
            $message = "Root not found ...";
        } else {
            $node = $this->getRandomNode();

            if (!is_null($node->parent_id)) {
                $path = $this->getPath($node);
            } else {
                $path = $node->title;
            }

            $node->path = $path;
            $success = true;
            $message = "random node info found";
            $httpCode = 200;
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'node' => !empty($node) ? $node : null,
            'allCount' => $this->getCount(),
            'time' => microtime(true) - $start
        ], $httpCode);
    }

    public function getRandomLeaf($base)
    {
        if (count($base->children) > 0) {
            $child = $base->children[rand(0, ($base->children->count() - 1))];
            return $this->getRandomLeaf($child);
        }

        return $base;
    }

    public function randomLeaf(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;

        $root = \App\Node::find(1);
        $node = $this->getRandomLeaf($root);

        if (empty($root)) {
            $message = "Root not found ...";
        } else if (empty($node)) {
            $message = "Node not found ...";
        } else {
            if (!is_null($node->parent_id)) {
                $path = $this->getPath($node);
            } else {
                $path = $node->title;
            }

            $node->path = $path;
            $success = true;
            $message = "random leaf info found";
            $httpCode = 200;
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'node' => !empty($node) ? $node : null,
            'allCount' => $this->getCount(),
            'time' => microtime(true) - $start
        ], $httpCode);
    }

    public function getPath(\App\Node $node)
    {
        $path = [];
        array_unshift($path, $node->title);

        if (!is_null($node->parent_id)) {
            $traverse = function($base, &$array) use (&$traverse) {
                if (!is_null($base->parent_id)) {
                    $parent = \App\Node::find($base->parent_id);
                    array_unshift($array, $parent->title);
                    $traverse($parent, $array);
                }

                return $array;
            };

            $path = $traverse($node, $path);
        }

        return implode(" > ", $path);
    }

    /**
     * Copies the given nodeId and appends the copy (with subtree) to the
     * parentId node
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function copyNode(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;

        $root = \App\Node::find(1);
        $node = \App\Node::find($request->input('nodeId'));
        $parent = \App\Node::find($request->input('parentId'));

        if (empty($root)) {
            $message = "Root not found ...";
        } else if (empty($node)) {
            $message = "Node not found ...";
        } else if ($request->has('parentId') && is_null($request->input('parentId'))) {
            $message = "Parent not found ...";
        } else {
            if (count($node->children) > 0) {
                // has children, copy duplicate with subtree
                $base = $node->replicate();
                $base->save();
                $base = $this->duplicateTree($base, $node->children);
                $base->appendToNode($parent)->save();
            } else {
                // no children, simply duplicate the node itself
                $base = $this->duplicateLeaf($node);
                $base->appendToNode($parent)->save();
            }

            $message = "Cloned (" . $base->id .") from (" . $node->id . ") and appended to " . $parent->id;
            $success = true;
            $httpCode = 200;
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'allCount' => $this->getCount(),
            'time' => microtime(true) - $start
        ], $httpCode);
    }

    public function duplicateTree(\App\Node $base, Collection $children)
    {
        foreach ($children as $child) {
            $copy = $child->replicate();
            $copy->appendToNode($base)->save();

            if (count($child->children) > 0) {
                $this->duplicateTree($copy, $child->children);
            }
        }

        return $base;
    }

    public function duplicateLeaf(\App\Node $node)
    {
        $copy = $node->replicate();
        return $copy;
    }

    public function deleteNode(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;

        $root = \App\Node::find(1);
        $node = \App\Node::find($request->input('nodeId'));

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

    /**
     * Appends a new, empty node to the given parent id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function appendNode(Request $request)
    {
        $start = microtime(true);
        $success = false;
        $httpCode = 500;

        $root = \App\Node::find(1);
        $parent = \App\Node::find($request->input('parentId'));

        if (empty($root)) {
            $message = "Root not found ...";
        } else if (empty($parent)) {
            $message = "Parent node not found ...";
        } else {
            $node = new \App\Node();
            $node->title = "New append node ...";
            $parent->appendNode($node);

            $success = true;
            $httpCode = 200;
            $message = "Node (" . $node->id . ") appended to ". $parent->id;
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'node' => $node,
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
            'tree' => Node::whereDescendantOrSelf(1)->get()->toTree(),
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
        return \App\Node::count();
    }

    public function welcome(Request $request)
    {
        $roots = Node::whereIsRoot()->get();
        $nonEmptyRoots = Node::hasChildren()->get();
        $rootTwo = Node::find(1);
        $rootTwoDescendants = $rootTwo->descendants;
        $tree = Node::whereDescendantOrSelf(1)->get();
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
