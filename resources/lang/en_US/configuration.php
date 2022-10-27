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

            'sentryDsn' => [
                'label' => "Sentry DSN",
                'help' => "Enter your Sentry DSN if you wish to use Sentry for error monitoring"
            ],
        ],

        'actions' => [
            'title' => "Actions",

            'save' => [
                'label' => "Save",
            ],

            'updateApp' => [
                'label' => "Update Mason CMS",
            ],

            'updateTheme' => [
                'label' => "Update Theme",
            ],
        ],
    ],
];
