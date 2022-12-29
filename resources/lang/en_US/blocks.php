<?php

return [
    'title' => "Blocks",
    'singular' => "Block",
    'plural' => "Blocks",
    'untitled' => "Untitled Block",

    'pagination' => "{0} No blocks|{1} One block|[2,*] Showing :count blocks out of :total",
    'noRecords' => "There are no blocks at this moment.",
    'mustSelect' => "Please select a location and language to see blocks.",

    'attributes' => [
        'id' => "ID",
        'location' => "Location",
        'locale' => "Language",
        'title' => "Title",
        'content' => "Content",
        'editor_mode' => "Editor mode",
        'rank' => "Rank",
        'created_at' => "Created on",
        'updated_at' => "Updated on",
        'deleted_at' => "Deleted on",
    ],

    'actions' => [
        'create' => [
            'label' => "New Block",
        ],

        'view' => [
            'label' => "View",
        ],

        'edit' => [
            'title' => "Edit Block",
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
];
