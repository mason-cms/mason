<?php

return [
    'title' => "Forms",
    'singular' => "Form",
    'plural' => "Forms",
    'untitled' => "Untitled Form",

    'pagination' => "{0} No form|{1} One form|[2,*] Showing :count forms out of :total",
    'noRecords' => "There are no forms at this moment.",

    'attributes' => [
        'id' => "ID",
        'name' => "Name",
        'title' => "Title",
        'description' => "Description",
        'locale' => "Language",
        'original' => "Original",
        'translations' => "Translations",
        'created_at' => "Created on",
        'updated_at' => "Updated on",
        'deleted_at' => "Deleted on",
    ],

    'actions' => [
        'create' => [
            'label' => "New Form",
        ],

        'view' => [
            'label' => "View",
        ],

        'edit' => [
            'title' => "Edit Form",
            'label' => "Edit",
        ],

        'destroy' => [
            'label' => "Delete",
        ],

        'save' => [
            'label' => "Save",
        ],

        'cancel' => [
            'label' => "Cancel",
        ],
    ],

    'fields' => [
        'title' => "Fields",
        'singular' => "Field",
        'plural' => "Fields",

        'attributes' => [
            'name' => "Name",
            'type' => "Type",
            'label' => "Label",
            'description' => "Description",
            'rank' => "Rank",
            'created_at' => "Created on",
            'updated_at' => "Updated on",
            'deleted_at' => "Deleted on",
        ],

        'types' => [
            'text' => "Text",
            'number' => "Number",
            'email' => "Email",
        ],

        'actions' => [
            'create' => [
                'label' => "New Field",
            ],

            'view' => [
                'label' => "View",
            ],

            'edit' => [
                'title' => "Edit Field",
                'label' => "Edit",
            ],

            'destroy' => [
                'label' => "Delete",
            ],

            'save' => [
                'label' => "Save",
            ],
        ],
    ],

    'submissions' => [
        'title' => "Submissions",
        'singular' => "Submission",
        'plural' => "Submissions",

        'attributes' => [
            'created_at' => "Created on",
            'updated_at' => "Updated on",
            'deleted_at' => "Deleted on",
        ],

        'actions' => [
            'view' => [
                'label' => "View",
            ],

            'destroy' => [
                'label' => "Delete",
            ],

            'save' => [
                'label' => "Save",
            ],
        ],
    ],
];
