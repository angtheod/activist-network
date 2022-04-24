<?php

namespace test1;

/**
 * Class ActivistNetwork
 */
class ActivistNetwork extends Network
{
    /**
     * ActivistNetwork constructor.
     *
     * @param Activist|null $root
     *
     * @throws \Exception
     */
    public function __construct(Activist $root = null) {
        if(!$root instanceof Activist)
            throw new \Exception('Enter an existing activist\'s name to view his/her network.');

        parent::__construct($root);
    }

    /**
     * Fill the current activist's network tree
     *
     * @param Node|null $activist
     *
     * @throws \Exception
     */
    public function fill (Node $activist = null) {

        if(!isset($activist))
            $activist = $this->_root;

        #The first time we start with the root activist
        if(!$activist instanceof activist)
            throw new \Exception('An activist\'s name to fill his/her network is required.');

        #Get current activist's signed actions
        $signedActions = $activist->getSignedActions();

        #Remove from the signed actions the ones that the parent activist has also signed since the relation has already been set in that case
        /** @var activist $activistParent */
        if($activistParent = $activist->getParent()) {
            $parentActionsSigned = $activistParent->getSignedActions();
            $signedActions = array_udiff($signedActions, $parentActionsSigned, function (Action $obj_a, Action $obj_b) {
                return $obj_a->getId() - $obj_b->getId();
            });
        }

        #For each signed action get the co-signed activists network and add them as children to the current activists node
        /** @var action $action */
        foreach ($signedActions as $action) {

            $signedActivists = $action->getSigningActivists();

            foreach ($signedActivists as $signedActivist)
                if($activist->id !== $signedActivist->id)           #Skip self
                    $this->addChild($activist, $signedActivist);
        }

        #Get current activist's children and do recursion for each child
        if($children = $activist->getChildren())
            foreach($children as $child)
                $this->fill($child);                                #recursion
    }

    /**
     * View the current activist's network tree
     *
     * @param Node|null $activist
     *
     * @throws \Exception
     */
    public function view (Node $activist = null) {

        static $depth = 0;

        #The first time we start with the root activist
        if(!isset($activist))
            $activist = $this->_root;

        if(!$activist instanceof activist)
            throw new \Exception('An activist\'s name to view his/her network is required.');

        echo '<ul>';
        echo '<li id="depth'.$depth.'" class="hoverable">';
        echo '<span class="hoverable__main">' . $activist->id . "</span> &nbsp;($depth)";
        echo '<span class="hoverable__tooltip">' . implode('<br />', $activist->getSignedActionsNames()) . '</span>';
        echo '</li>';

        if($children = $activist->getChildren()) {
            $depth++;
            foreach ($children as $child)
                $this->view($child);                                #recursion
            $depth--;
        }
        echo '</ul>';
    }
}
