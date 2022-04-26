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

namespace activistNetwork;

use controllers\NetworkController;
use views\Home;

ini_set('display_errors', 'off');	#turn off Debug mode
require_once 'autoload.php';

(new Home())->view();
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['activist-name']))
{
	$activistName = $_GET['activist-name'];
	$data = json_decode(file_get_contents(DATA_FILE), true);      //Read data from file

	(new NetworkController($activistName, $data['actions'], $data['activists'], $data['signed-actions']));
}
