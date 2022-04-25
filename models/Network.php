<?php

namespace models;

/**
 * Class Network
 * @package models
 */
abstract class Network
{
    /** @var Node */
    protected $_root;

    /** @var array */
    protected $_hashTable = array();      #Hash table that will contain all the nodes of this network

    /**
     * Network constructor.
     *
     * @param Node $root
     * @throws \Exception
     */
    public function __construct(Node $root) {
        if(!$root instanceof Node)
            throw new \Exception('A root node for the network is required.');

        $this->_root = $root;
        $this->_hashTable[$this->_root->getId()] = $this->_root;
        $this->fill();
    }

    /**
     * @param Node      $child
     * @param Node|null $parent
     *
     * @return int
     * @throws \Exception
     */
    public function addChild(Node $child, Node $parent = null): int
    {
        if(!$child instanceof Node)
            throw new \Exception('A child node is required.');

        if(!$parent)
            $parent = $this->_root;

        $this->_hashTable[$parent->getId()] = $child;
        $this->setChild($parent, $child);
        $this->setParent($child, $parent);

        return $child->getId();
    }

    /**
     * @param Node $parent
     * @param Node $child
     */
    public function setChild(Node $parent, Node $child)
    {
        if($parent)
            $parent->setChild($child);
    }

    /**
     * @param Node $child
     * @param Node $parent
     */
    public function setParent(Node $child, Node $parent)
    {
        if($child)
            $child->setParent($parent);
    }

    /**
     * Fill this network tree with Nodes
     *
     * @param Node|null $node
     */
    abstract function fill (Node $node = null);

    /**
     * @param Node|null $node
     */
    abstract function view (Node $node = null);
}
