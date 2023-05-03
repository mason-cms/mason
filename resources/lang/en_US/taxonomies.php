<?php

return [
    'title' => "Taxonomies",
    'singular' => "Taxonomy",
    'plural' => "Taxonomies",
    'pagination' => "{0} No taxonomies|{1} One taxonomy|[2,*] Showing :count taxonomies out of :total",
    'noRecords' => "There are no :taxonomyType at this moment.",

    'attributes' => [
        'id' => "ID",
        'name' => "Name",
        'title' => "Title",
        'description' => "Description",
        'cover' => "Cover Image",
        'locale' => "Language",
        'original' => "Original",
        'translations' => "Translations",
        'parent' => "Parent",
        'created_at' => "Created on",
        'updated_at' => "Updated on",
        'deleted_at' => "Deleted on",
    ],

    'actions' => [
        'create' => [
            'label' => "New :taxonomyType",
        ],

        'view' => [
            'label' => "View",
        ],

        'edit' => [
            'label' => "Edit",
        ],

        'editOriginal' => [
            'label' => "Edit original",
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
