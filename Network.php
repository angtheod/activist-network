<?php

namespace test1;

/**
 * Class Network
 */
abstract class Network
{
    /**
     * @var Node
     */
    protected $_root;
    /**
     * @var array
     */
    protected $_hashTable = array();      #Hash table that will contain all the nodes of this network

    /**
     * Network constructor.
     *
     * @param Node $root
     *
     * @throws \Exception
     */
    public function __construct(Node $root) {
        if(!$root instanceof Node)
            throw new \Exception('A root node for the network is required.');

        $this->_root = $root;
        $this->_hashTable[$this->_root->id] = $this->_root;
        $this->fill();
    }

    /**
     * @param Node|null $parent
     * @param Node      $child
     *
     * @return mixed
     * @throws \Exception
     */
    public function addChild(Node $parent = null, Node $child) {
        if(!$child instanceof Node)
            throw new \Exception('A child node is required.');

        if(!$parent)
            $parent = $this->_root;

        $this->_hashTable[$parent->id] = $child;
        $this->setChild($parent, $child);
        $this->setParent($child, $parent);

        return $child->id;
    }

    /**
     * @param Node $parent
     * @param Node $child
     */
    public function setChild(Node $parent, Node $child) {
        if($parent !== false)
            $parent->setChild($child);
    }

    /**
     * @param Node $child
     * @param Node $parent
     */
    public function setParent(Node $child, Node $parent) {
        if($child !== false)
            $child->setParent($parent);
    }

    /**
     * Fill this network tree with Nodes
     *
     * @param Node|null $node
     *
     */
    abstract function fill (Node $node = null);

    /**
     * @param Node|null $node
     *
     */
    abstract function view (Node $node = null);
}