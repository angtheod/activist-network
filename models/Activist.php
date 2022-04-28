<?php

namespace models;

/**
 * Class Activist
 * @package models
 */
class Activist extends Node
{
    /** @var string */
    protected $name;

    /** @var Action[]  */
    public $actions = array();

    /**
     * Activist constructor.
     *
     * @param int    $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        parent::__construct($id);
        $this->name = $name;
    }

    /**
     * @param Action $action
     */
    public function sign(Action $action)
    {
        $this->actions[] = $action;
        $action->signedBy($this);
    }

    /**
     * @return array
     */
    public function getSignedActions(): array
    {
        return $this->actions;
    }

    /**
     * @return array
     */
    public function getSignedActionsNames(): array
    {
        $names = [];
        foreach ($this->actions as $action) {
            $names[] = $action->getName();
        }

        return $names;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
