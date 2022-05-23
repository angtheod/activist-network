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

    /** @var Node[] */
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
            $this->children[$child->getId()] = $child;
        }
    }

    /**
     * @return Node[]
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
