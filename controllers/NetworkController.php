<?php

namespace controllers;

use models\ActivistNetwork;

/**
 * Class NetworkController
 * @package controllers
 */
class NetworkController
{
    /**
     * NetworkController constructor.
     *
     * @param string $activistName
     * @param string $fileName
     */
    public function __construct(string $activistName, string $fileName)
    {
        try { //Sanitize input and pass to model
            $activistNetwork = new ActivistNetwork(self::sanitizeStringSt($activistName), $fileName);
            $activistNetwork->viewHome();
            $activistNetwork->view();
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
        return htmlspecialchars(strip_tags(filter_var($str, FILTER_SANITIZE_STRING)));
    }
}
