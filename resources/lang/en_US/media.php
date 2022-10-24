<?php

return [
    'title' => "Media",
    'singular' => "Media",
    'plural' => "Media",
    'pagination' => "{0} No media|{1} One media|[2,*] Showing :count media out of :total",
    'noRecords' => "There are no media at this moment.",

    'attributes' => [
        'id' => "ID",
        'title' => "Title",
        'locale' => "Language",
        'parent' => "Parent",
        'file' => "File",
        'storage_key' => "Storage Key",
        'content_type' => "Content Type",
        'filesize' => "File Size",
        'created_at' => "Created on",
        'updated_at' => "Updated on",
        'deleted_at' => "Deleted on",
    ],

    'actions' => [
        'create' => [
            'label' => "New Media",
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

        'cancel' => [
            'label' => "Cancel",
        ],
    ],
];
