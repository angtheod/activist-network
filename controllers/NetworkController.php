<?php

namespace controllers;

use models\Action;
use models\Activist;
use models\ActivistNetwork;

/**
 * Class NetworkController
 * @package controllers
 */
class NetworkController
{
	/** @var Action[] */
	protected $actions = [];

	/** @var Activist[] */
	protected $activists = [];

	/**
	 * NetworkController constructor.
	 *
	 * @param string $name
	 * @param Action[] $actions
	 * @param Activist[] $activists
	 * @param array $signedActions
	 */
	public function __construct(string $name, $actions = [], $activists = [], $signedActions = [])
	{
		$this->init($actions, $activists, $signedActions);              //Initialize network by creating all the nodes and their relations
		$activist = $this->activists[$this->sanitize($name)];           //Sanitize form's input

		try {
			(new ActivistNetwork($activist))->view();
		} catch (\Exception $e) {
			echo '<div id="error">' . $e->getMessage() . '</div>';
		}
	}

	/**
	 * @param array $actions
	 * @param array $activists
	 * @param array $signedActions
	 */
	public function init($actions = [], $activists = [], $signedActions = [])
	{
		$this->registerActions($actions);
		$this->registerActivists($activists);
		$this->signActions($signedActions);
	}

	/**
	 * @param array $actions
	 */
	protected function registerActions($actions = [])
	{
		foreach ($actions as $action)
			if (is_int($action['id']))
				$this->actions[$action['name']] = new Action($action['id'], $action['name']);
	}

	/**
	 * @param array $activists
	 */
	protected function registerActivists($activists = [])
	{
		foreach ($activists as $activist)
			if (is_int($activist['id']))
				$this->activists[$activist['name']] = new Activist($activist['id'], $activist['name']);
	}

	/**
	 * @param array $signedActions
	 */
	protected function signActions($signedActions = [])
	{
		foreach ($signedActions as $signedAction)
			$this->activists[$signedAction[0]]->signAction($this->actions[$signedAction[1]]);
	}

	/**
	 * Sanitize form input
	 *
	 * @param string $name
	 * @return string
	 */
	protected function sanitize($name): string
	{
		return htmlspecialchars(strip_tags(filter_var($name, FILTER_SANITIZE_STRING)));
	}
}
