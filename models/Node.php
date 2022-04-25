<?php

namespace models;

/**
 * Class Node
 * @package models
 */
class Node
{
    /** @var int */
    protected $id;

    /** @var Node */
    protected $_parent;

    /** @var array */
    protected $_children = array();

    /**
     * Node constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param Node $parent
     */
    public function setParent(Node $parent)
    {
        $this->_parent = $parent;
    }

    /**
     * @return Node|null
     */
    public function getParent(): ?Node
    {
        return $this->_parent;
    }

    /**
     * @param Node $child
     */
    public function setChild(Node $child)
    {
        if(!empty($child))
            $this->_children[] = $child;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->_children;
    }

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}
}
