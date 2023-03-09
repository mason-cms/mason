<?php

return [
    'title' => "Entries",
    'singular' => "Entry",
    'plural' => "Entries",
    'pagination' => "{0} No entries|{1} One entry|[2,*] Showing :count entries out of :total",
    'noRecords' => "There are no :entryType at this moment.",

    'attributes' => [
        'id' => "ID",
        'name' => "Name",
        'locale' => "Language",
        'title' => "Title",
        'description' => "Description",
        'content' => "Content",
        'author' => "Author",
        'cover' => "Cover image",
        'is_home' => "Homepage",
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
            'label' => "New :entryType",
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

        'publish' => [
            'label' => "Publish",
        ],

        'cancel' => [
            'label' => "Cancel",
        ],
    ],
];
