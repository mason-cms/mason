<?php

use App\Facades\Parser;

Parser::registerShortcode('csrf', function (array $parameters = []) {
    $csrfToken = csrf_token();

    return "<input type=\"hidden\" name=\"_token\" value=\"{$csrfToken}\" />";
});
