<?php

use App\Facades\Parser;

Parser::registerShortcode('csrf-token', function (array $parameters = []) {
    return csrf_token();
});
