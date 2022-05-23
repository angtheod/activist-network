<?php

require_once 'config.php';
spl_autoload_register(function ($className) {
	if ($className !== 'PHPUnit\Framework\MockObject\MockedCloneMethodWithVoidReturnType') {
		require_once str_replace("\\", "/", $className) . '.php';        #Autolad all classes found
	}
});
