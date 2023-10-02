<?php

use App\Facades\Parser;

Parser::registerShortcode('form', function (array $parameters = []) {
    if (isset($parameters['name'])) {

        if ($form = site()->form($parameters['name'])) {
            return $form;
        }
    }
});
