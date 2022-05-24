<?php

namespace models;

/**
 * Class Action
 * @package models
 */
class Action
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var array */
    public $activists = array();

    /**
     * Action constructor.
     *
     * @param int    $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @param Activist $activist
     */
    public function signBy(Activist $activist): void
    {
        $this->activists[$activist->getId()] = $activist;
    }

    /**
     * @param Activist $activist
     *
     * @return bool
     */
    public function isSignedBy(Activist $activist): bool
    {
        return isset($this->activists[$activist->getId()]);
    }

    /**
     * @return array
     */
    public function getSigningActivists(): array
    {
        return $this->activists;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
