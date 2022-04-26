<?php

namespace models;

/**
 * Class ActivistNetwork
 * @package models
 */
class ActivistNetwork extends Network
{
    /**
     * Fill the current activist's network tree
     *
     * @param Activist|null $activist
     * @throws \Exception
     */
    public function fill ($activist = null)
    {
        if(!$activist)
            $activist = $this->_root;

        #The first time we start with the root activist
        if(!$activist instanceof Activist)
            throw new \Exception('An activist\'s name to fill his/her network is required.');

        #Get current activist's signed actions
        $signedActions = $activist->getSignedActions();

        #Remove from the signed actions the ones that the parent activist has also signed since the relation has already been set in that case
        /** @var Activist $activistParent */
        if($activistParent = $activist->getParent()) {
            $parentActionsSigned = $activistParent->getSignedActions();
            $signedActions = array_udiff($signedActions, $parentActionsSigned, function (Action $obj_a, Action $obj_b) {
                return $obj_a->getId() - $obj_b->getId();
            });
        }

        #For each signed action get the co-signed activists network and add them as children to the current activists node
        /** @var Action $action */
        foreach ($signedActions as $action) {
            $signedActivists = $action->getSigningActivists();

            foreach ($signedActivists as $signedActivist)
                if ($activist->getId() !== $signedActivist->getId()     //Skip self
                   && !$activist->isParentOf($signedActivist))          //Skip already added child
                    $this->addChild($signedActivist, $activist);
        }

        #Get current activist's children and do recursion for each child
        if($children = $activist->getChildren())
            foreach($children as $child)
                $this->fill($child);                                    //Recursion
    }

    /**
     * View the current activist's network tree
     *
     * @param Activist|null $activist
     * @throws \Exception
     */
    public function view ($activist = null)
    {
        static $depth = 0;

        #The first time we start with the root activist
        if(!$activist)
	        $activist = $this->_root;

        if(!$activist instanceof Activist)
            throw new \Exception('An activist\'s name to view his/her network is required.');

	    (new \views\Activist())->view([
	    	'activist' => $activist,
		    'depth'    => $depth
	    ]);

        if($children = $activist->getChildren()) {
            $depth++;
            foreach ($children as $child)
                $this->view($child);                                    //Recursion
            $depth--;
        }
        echo '</ul>';
    }

	/**
	 * {@inheritDoc}
	 */
	public function validate($activist)
    {
	    if(!$activist instanceof Activist)
            throw new \Exception('Enter an existing activist\'s name to view his/her network.');
    }
}
