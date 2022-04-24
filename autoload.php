<?php

#Autolad all classes found
spl_autoload_register(function ($className) {
	require_once str_replace("\\","/", $className) . '.php';
});
