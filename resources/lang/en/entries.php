<?php

return [
    'title' => "Entries",
    'singular' => "Entry",
    'plural' => "Entries",
    'attributes' => [
        'id' => "ID",
        'name' => "Name",
        'locale' => "Language",
        'title' => "Title",
        'body' => "Body",
        'author' => "Author",
        'published_at' => "Published on",
        'status' => "Status",
        'created_at' => "Created on",
        'updated_at' => "Updated on",
        'deleted_at' => "Deleted on",
    ],
    'statuses' => [
        'draft' => "Draft",
        'published' => "Published",
        'scheduled' => "Scheduled",
    ],
    'actions' => [
        'create' => [
            'label' => "New Entry",
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
];
