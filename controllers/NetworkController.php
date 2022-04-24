<?php

namespace controllers;

use models\Action;
use models\Activist;

/**
 * @package activistNetwork
 *
 * Class NetworkController
 */
class NetworkController
{
	/**
	 *
	 */
	public function init()
	{
		$whales = new Action(1, 'Whales');
		$toxics = new Action(2, 'Toxics');
		$nukes	= new Action(3, 'Nukes');
		$climate= new Action(4, 'Climate');
		$ozon   = new Action (5, 'Ozon');

		$koyan = new Activist('koyan');
		$remy  = new Activist('remy');
		$bill  = new Activist('bill');
		$maria = new Activist('maria');
		$helen = new Activist('helen');
		$jim   = new Activist('jim');

		$koyan->signAction($whales);
		$remy->signAction($whales);
		$bill->signAction($whales);
		$bill->signAction($nukes);
		$maria->signAction($nukes);
		$maria->signAction($climate);
		$helen->signAction($climate);
		$helen->signAction($ozon);
		$jim->signAction($ozon);

		$this->registerActions();
		$this->registerActivists();
		$this->signActions();
	}

	/**
	 *
	 */
	protected function registerActions()
	{

	}

	/**
	 *
	 */
	protected function registerActivists() {

	}

	/**
	 *
	 */
	protected function signActions() {

	}
}
