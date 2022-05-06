<?php

namespace models;

/**
 * Class Network
 * @package models
 */
abstract class Network
{
    /** @var Node */
    protected $root;                        //Root node of the network

    /** @var array */
    protected $hashTable = array();         //Hash table that will contain all the nodes of this network

    /** @var array */
    protected $data = array();              //Contains all the data read from the data source (file)

    /**
     * Network constructor.
     *
     * @param string $activistName
     * @param string $fileName
     * @throws \Exception
     */
    public function __construct(string $activistName, string $fileName)
    {
        $this->init($activistName, $fileName);
        try {
            $this->validate($this->root);       //Validate Node
            $this->hashTable[$this->root->getId()] = $this->root;
            $this->fill();
        } catch (\Exception $e) {
            echo '<div id="error">' . $e->getMessage() . '</div>';
        }
    }

    /**
     * Initialize network by reading data source and create respective nodes and their relations
     *
     * @param string $activistName
     * @param string $fileName
     * @return void
     */
    public function init($activistName, $fileName): void
    {
        $this->readData($fileName);
    }

    /**
     * @param $node
     *
     * @throws \Exception
     */
    protected function validate($node): void
    {
        if (!$node instanceof Node) {
            throw new \Exception('Invalid node.');
        }
    }

    /**
     * @param Node      $child
     * @param Node|null $parent
     *
     * @return int
     * @throws \Exception
     */
    public function addChild($child, $parent = null): int
    {
        if (!$child instanceof Node) {
            throw new \Exception('A child node is required.');
        }

        if (!$parent) {
            $parent = $this->root;
        }

        $this->hashTable[$parent->getId()] = $child;
        $this->setChild($parent, $child);
        $this->setParent($child, $parent);

        return $child->getId();
    }

    /**
     * @param Node $parent
     * @param Node $child
     */
    public function setChild($parent, $child): void
    {
        if ($parent) {
            $parent->setChild($child);
        }
    }

    /**
     * @param Node $child
     * @param Node $parent
     */
    public function setParent($child, $parent): void
    {
        if ($child) {
            $child->setParent($parent);
        }
    }

    /**
     * @param Node $node
     *
     * @return bool
     */
    public function contains($node): bool
    {
        return isset($this->hashTable[$node->getId()]);
    }

    /**
     * Read data from file (json, csv)
     *
     * @param string $fileName
     */
    protected function readData(string $fileName): void
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($extension === 'json') {
            $this->data = json_decode(file_get_contents($fileName), true);      //Read data from json file
        } elseif ($extension === 'csv') {
            $this->data = array_map('str_getcsv', file($fileName));              //Read data from csv file
        }
    }

    /**
     * Fill this network tree with Nodes
     *
     * @param Node|null $node
     */
    abstract protected function fill(Node $node = null);

    /**
     * @param Node|null $node
     */
    abstract public function view(Node $node = null);
}
