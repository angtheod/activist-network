<?php

namespace controllers;

use models\Network;

/**
 * Class NetworkController
 * @package controllers
 */
class NetworkController
{
    /**
     * NetworkController constructor (Use Dependency Injection)
     *
     * @param Network $network
     */
    public function __construct(Network $network)
    {
        try {
            $network->viewHome();   // TODO - Needs to be moved. This shouldn't be Network's responsibility
            $network->view();
        } catch (\Exception $e) {
            echo '<div id="error">' . $e->getMessage() . '</div>';
        }
    }

    /**
     * Sanitize a string from the form's input
     *
     * @param string $str
     * @return string
     */
    public static function sanitizeStringSt($str): string
    {
        return htmlspecialchars(strip_tags($str));
    }
}
