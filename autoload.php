<?php

defined('TEMPLATES_PATH') or define ('TEMPLATES_PATH', 'templates/');
defined('DATA_FILE') or define ('DATA_FILE', 'data.json');
defined('CSS_PATH') or define ('CSS_PATH', 'assets/styles/');
defined('JS_PATH') or define ('JS_PATH', 'assets/scripts/');

#Autolad all classes found
spl_autoload_register(function ($className) {
	require_once str_replace("\\","/", $className) . '.php';
});
