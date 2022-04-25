<?php

namespace views;

/**
 * Class View
 * @package views
 */
class View
{
	/**
	 * Render the related template with the same name
	 */
	public function view()
	{
		require TEMPLATES_PATH . lcfirst( (new \ReflectionClass($this))->getShortName() ) . '.php';
	}
}
