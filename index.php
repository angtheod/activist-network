<?php
/**
 * Created by PhpStorm.
 * @author Angelos Theodorakopoulos
 * Email: angtheod@gmail.com
 *
 * @version 1.0
 * Date: 04/05/2017
 *
 * @version 1.5
 * Date: 24/04/2022
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
use views\Home;

require_once 'autoload.php';
(new Home())->view();

if (isset($_GET['activist-name']))
{
	$activistName = $_GET['activist-name'];                                          //TODO - sanitize input
	$data = json_decode(file_get_contents(DATA_FILE), true);      //Read data from file

	(new NetworkController($activistName, $data['actions'], $data['activists'], $data['signed-actions']));
}
