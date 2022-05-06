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
    protected $parent;

    /** @var array */
    protected $children = array();

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
    public function setParent(Node $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return Node|null
     */
    public function getParent(): ?Node
    {
        return $this->parent;
    }

    /**
     * @param Node $child
     */
    public function setChild(Node $child): void
    {
        if (!empty($child)) {
            $this->children[$child->id] = $child;
        }
    }

    /**
     * @param Node $child
     * @return bool
     */
    public function isParentOf(Node $child): bool
    {
		//TODO - check if this is correct
        return isset($this->children[$child->id]);
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
