<?php

namespace test1;

/**
 * Class Node
 */
class Node
{
    /**
     * @var
     */
    public $id;
    /**
     * @var Node
     */
    protected $_parent;
    /**
     * @var array
     */
    protected $_children = array();

    /**
     * Node constructor.
     *
     * @param $id
     */
    function __construct($id) {
        $this->id = $id;
    }

    /**
     * @param Node $parent
     */
    public function setParent(Node $parent) {
        $this->_parent = $parent;
    }

    /**
     * @return Node
     */
    public function getParent() {
        return $this->_parent;
    }

    /**
     * @param Node $child
     */
    public function setChild(Node $child) {
        if(!empty($child))
            $this->_children[] = $child;
    }

    /**
     * @return array
     */
    public function getChildren() {
        return $this->_children;
    }
}