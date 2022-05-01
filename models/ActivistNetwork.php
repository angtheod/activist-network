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
     * {@inheritDoc}
     */
    public function init($activistName, $fileName)
    {
        parent::init($activistName, $fileName);
        $this->createActions($this->data['actions']);
        $this->createActivists($this->data['activists']);
        $this->signActions($this->data['signed-actions']);
        if ($activistName) {
            $this->root = $this->activists[$activistName];
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function validate($activist)
    {
        if (!$activist instanceof Activist) {
            throw new \Exception('Click on an existing activist\'s name to view his/her network.');
        }
    }

    /**
     * @param array $actions
     */
    protected function createActions($actions = [])
    {
        foreach ($actions as $action) {
            if (is_int($action['id'])) {
                $this->actions[$action['name']] = new Action($action['id'], $action['name']);
            }
        }
    }

    /**
     * @param array $activists
     */
    protected function createActivists($activists = [])
    {
        foreach ($activists as $activist) {
            if (is_int($activist['id'])) {
                $this->activists[$activist['name']] = new Activist($activist['id'], $activist['name']);
            }
        }
    }

    /**
     * @param array $signedActions
     */
    protected function signActions($signedActions = [])
    {
        foreach ($signedActions as $signedAction) {
            $this->activists[$signedAction[0]]->sign($this->actions[$signedAction[1]]);
        }
    }

    /**
     * Fill the current activist's network tree
     *
     * @param Activist|null $activist
     * @throws \Exception
     */
    protected function fill($activist = null)
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
                    $activist->getId() !== $signedActivist->getId()     //Skip self
                    && !$activist->isParentOf($signedActivist)          //Skip already added child
                ) {
                    $this->addChild($signedActivist, $activist);
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
