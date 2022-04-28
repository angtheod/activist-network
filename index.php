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

require_once 'autoload.php';
ini_set('display_errors', DISPLAY_ERRORS);                               #set Debug mode
(new NetworkController($_GET['activist-name'] ?? '', DATA_JSON));
