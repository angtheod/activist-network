<?php

namespace views;

/**
 * Class Home
 * @package views
 */
class Home
{
	/**
	 *
	 */
	public function view()
	{
		require_once TEMPLATES_PATH . lcfirst( (new \ReflectionClass($this))->getShortName() ) . '.html';
	}
}
