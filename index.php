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
use models\ActivistNetwork;

require_once 'autoload.php';
ini_set('display_errors', DISPLAY_ERRORS);                           //Set Debug mode

(new NetworkController(
    new ActivistNetwork(
        NetworkController::sanitizeStringSt($_GET['activist-name'] ?? ''),    //Sanitize input and pass to model
        DATA_FILE
    )
));
