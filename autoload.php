<?php

require_once 'config.php';
spl_autoload_register(function ($className) {
    require_once str_replace("\\", "/", $className) . '.php';        #Autolad all classes found
});
