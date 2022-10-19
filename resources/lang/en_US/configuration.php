<?php

return [
    'title' => "Configuration",

    'general' => [
        'title' => "General",

        'fields' => [
            'siteName' => [
                'label' => "Site Name",
            ],

            'siteDescription' => [
                'label' => "Site Description",
            ],

            'siteTheme' => [
                'label' => "Site Theme",
            ],

            'siteAllowUserRegistration' => [
                'label' => "Allow User Registration?",
            ],

            'siteRestrictUserEmailDomain' => [
                'label' => "Restrict User Email Domain?"
            ],

            'siteAllowedUserEmailDomains' => [
                'label' => "Allowed User Email Domains",
            ],
        ],

        'actions' => [
            'save' => [
                'label' => "Save",
            ],
        ],
    ],
];
