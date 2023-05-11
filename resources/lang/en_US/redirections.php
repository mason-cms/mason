<?php

return [
    'title' => "Redirections",
    'singular' => "Redirection",
    'plural' => "Redirections",
    'pagination' => "{0} No redirections|{1} One redirection|[2,*] Showing :count redirections out of :total",
    'noRecords' => "There are no redirections at this moment.",

    'attributes' => [
        'source' => "Source",
        'target' => "Target",
        'http_response_code' => "HTTP Response Code",
        'comment' => "Comment",
        'is_active' => "Active?",
        'active' => "Active",
        'inactive' => "Inactive",
        'last_hit_at' => "Last Hit",
    ],

    'actions' => [
        'create' => [
            'label' => "New Redirection",
        ],

        'view' => [
            'label' => "View",
        ],

        'edit' => [
            'label' => "Edit",
        ],

        'destroy' => [
            'label' => "Delete",
        ],

        'save' => [
            'label' => "Save",
        ],
    ],

    'hits' => [
        'title' => "Hits",
        'plural' => "Hits",
        'singular' => "Hit",
    ],
];
