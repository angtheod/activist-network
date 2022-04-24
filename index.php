<?php
/**
 * Created by PhpStorm.
 * User: losangelos
 * Name: Angelos Theodorakopoulos
 * Email: angtheod@gmail.com
 * Date: 4/5/2017
 * Time: 11:56 πμ
 */

/*
 * We say that two activists who signed the same action have 1 degree of separation.
 * We say that two activists who each have 1 degree of separation with the same activist,
 * but who did not themselves sign the same action, have 2 degrees of separation.  Etc.
 *
 * Write a function that takes an activist as an argument, and that first prints out all activists
 * who have 1 degree of separation from that activist, then prints out all activists that have 2 degrees of separation (from that activist?),
 * then 3, etc.  It should never print the same activist twice.
 *
 * Implementation Design
 * ---------------------------
 * We will implement this by using a HashTable.
 * The HashTable has the activist name as key and the activist object as node.
 * Each node has _parent node (except for the root node) and possibly children nodes.
 * Tested with php 7.3.33
 */

namespace activistNetwork;

use controllers\NetworkController;
use models\Activist;
use models\ActivistNetwork;
use views\Home;

#ini_set('display_errors', 'off');	#turn off Debug mode
defined('CSS_PATH') or define ('CSS_PATH', 'assets/styles/');
defined('JS_PATH') or define ('JS_PATH', 'assets/scripts/');
defined('TEMPLATES_PATH') or define ('TEMPLATES_PATH', 'templates/');

#Autolad all classes found
spl_autoload_register(function ($className) {
	require_once str_replace("\\","/", $className) . '.php';
});

(new Home())->view();
(new NetworkController())->init();

if (isset($_GET['activist-name']))
{
	/** @var Activist $activist */
	$activist = ${$_GET['activist-name']};          #Get the already instantiated activist object by using variable variable names

	try {
		$network = new ActivistNetwork( $activist );
		$network->view();
	} catch ( \Exception $e ) {
		echo '<div id="error">' . $e->getMessage() . '</div>';
	}
	echo '<br /><a href=".">Clear</a>';
}
