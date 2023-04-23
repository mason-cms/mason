<?php

use App\Facades\Parser;

Parser::registerShortcode('setting', function (array $parameters = []) {
    if (isset($parameters['name'])) {
        if ($setting = site()->setting($parameters['name'])) {
            return $setting;
        }
    }
});
