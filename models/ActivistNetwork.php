<?php

namespace models;

use views\Home;

/**
 * Class ActivistNetwork
 * @package models
 */
class ActivistNetwork extends Network
{
    /** @var Action[] */
    protected $actions = [];

    /** @var Activist[] */
    protected $activists = [];

    /**
     * Initialize network by reading data source and create respective nodes and their relations
     *
     * @param string $activistName
     * @param string $fileName
     * @return void
     * @throws \Exception
     */
    public function init($activistName, $fileName): void
    {
        parent::init($activistName, $fileName);
        $this->createActions($this->data['actions']);
        $this->createActivists($this->data['activists']);
        $this->signActions($this->data['signed-actions']);
        $this->root = $this->activists[$activistName] ?? null;
    }

    /**
     * @param Activist $node
     * @return void
     * @throws \Exception
     */
    protected function validate($node): void
    {
        if (!$node instanceof Activist) {
            throw new \Exception('Click on an existing activist\'s name to view his/her network.');
        }
    }

    /**
     * @param array $actions
     * @return void
     * @throws \Exception
     */
    protected function createActions($actions = []): void
    {
        foreach ($actions as $action) {
            if (isset($this->actions[$action['name']])) {
                throw new \Exception('Invalid data. Action duplication.');
            }
            if (is_int($action['id'])) {    // TODO - use `id` as identifier/key
                $this->actions[$action['name']] = new Action($action['id'], $action['name']);
            }
        }
    }

    /**
     * @param array $activists
     * @return void
     * @throws \Exception
     */
    protected function createActivists($activists = []): void
    {
        foreach ($activists as $activist) {
            if (isset($this->activists[$activist['name']])) {
                throw new \Exception('Invalid data. Activist duplication.');
            }
            if (is_int($activist['id'])) {    // TODO - use `id` as identifier/key
                $this->activists[$activist['name']] = new Activist($activist['id'], $activist['name']);
            }
        }
    }

    /**
     * @param $signedActions
     * @return void
     */
    protected function signActions($signedActions = []): void
    {
        foreach ($signedActions as $signedAction) {
            $this->activists[$signedAction[0]]->sign($this->actions[$signedAction[1]]);
        }
    }

    /**
     * @return Action[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @return Activist[]
     */
    public function getActivists(): array
    {
        return $this->activists;
    }

    /**
     * @return int
     */
    public function getSignedActions(): int
    {
        $signedActions = 0;
        foreach ($this->activists as $activist) {
            $signedActions += count($activist->getSignedActions());
        }
        return $signedActions;
    }

    /**
     * Fill the current activist's network tree
     *
     * @param Activist|null $activist
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function fill($activist = null): void
    {
        if (!$activist) {
            if (!$this->root) {
                return;
            }
            $activist = $this->root;
        }

        #Get current activist's signed actions
        $signedActions = $activist->getSignedActions();

        #Remove from signed actions the ones that parent activist has also signed since the relation was already set
        /** @var Activist $activistParent */
        if ($activistParent = $activist->getParent()) {
            $parentActionsSigned = $activistParent->getSignedActions();
            $signedActions = array_udiff($signedActions, $parentActionsSigned, function (Action $obj_a, Action $obj_b) {
                return $obj_a->getId() - $obj_b->getId();
            });
        }

        #For each signed action get the co-signed activists network and add them as children to current activists node
        /** @var Action $action */
        foreach ($signedActions as $action) {
            $signedActivists = $action->getSigningActivists();

            foreach ($signedActivists as $signedActivist) {
                if (
                    $activist->getId() !== $signedActivist->getId()   //Skip self
                    && !$this->contains($signedActivist)              //Skip if signedActivist already exists in subtree
                ) {
                    $this->addNode($signedActivist, $activist);
                }
            }
        }

        #Get current activist's children and do recursion for each child
        if ($children = $activist->getChildren()) {
            foreach ($children as $child) {
                $this->fill($child);                                    //Recursion
            }
        }
    }

    /**
     * View the current activist's network tree
     * TODO - Needs to be moved. This shouldn't be Network's responsibility
     *
     * @throws \Exception
     */
    public function viewHome()
    {
        (new Home())->view([
            'activistName' => $this->root ? $this->root->getName() : '',
            'activists'    => $this->data['activists']
        ]);
    }

    /**
     * View the current activist's network tree
     *
     * @param Activist|null $activist
     * @throws \Exception
     */
    public function view($activist = null)
    {
        static $depth = 0;

        #The first time we start with the root activist
        if (!$activist) {
            echo '<ul class="tree">';
            if (!$this->root) {
                return;
            }
            $activist = $this->root;
        }

        (new \views\Activist())->view([
            'activist' => $activist,
            'depth'    => $depth
        ]);

        if ($children = $activist->getChildren()) {
            $depth++;
            foreach ($children as $child) {
                $this->view($child);                                    //Recursion
            }
            $depth--;
        }
        echo '</ul>';
    }
}
