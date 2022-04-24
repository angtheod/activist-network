<?php

namespace test1;

/**
 * Class Activist
 */
class Activist extends Node
{
    /**
     * @var Action[]
     */
    public $actions = array();

    /**
     * @param Action $action
     */
    public function signAction(Action $action) {
        $this->actions[] = $action;
        $action->activistSigned($this);
    }

    /**
     * @return array
     */
	public function getSignedActions(): array {
        return $this->actions;
    }

	/**
	 * @return array
	 */
	public function getSignedActionsNames(): array {
		$names = [];
		foreach ($this->actions as $action) {
			$names[] = $action->getName();
		}

		return $names;
	}
}
