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
    public function signedBy(Activist $activist)
    {
        $this->activists[] = $activist;
    }

    /**
     * @return array
     */
    public function getSigningActivists(): array
    {
        return $this->activists;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
