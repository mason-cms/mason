<?php

use App\Facades\Parser;

Parser::registerShortcode('recent-entries', function (array $parameters = []) {
    $query = site()->entries()->orderBy('published_at', 'desc');

    if (isset($parameters['type'])) {
        $query->byType($parameters['type']);
    }

    if (isset($parameters['count'])) {
        $query->take($parameters['count']);
    }

    $view = $parameters['view'] ?? 'shortcodes.recent-entries';

    return view($view, [
        'entries' => $query->get(),
        'parameters' => $parameters,
    ]);
});
