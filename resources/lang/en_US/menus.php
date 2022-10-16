<?php

return [
    'title' => "Menus",
    'singular' => "Menu",
    'plural' => "Menus",
    'pagination' => "{0} No menus|{1} One menu|[2,*] Showing :count menus out of :total",
    'noRecords' => "There are no menus at this moment.",

    'attributes' => [
        'id' => "ID",
        'location' => "Location",
        'name' => "Name",
        'title' => "Title",
        'locale' => "Language",
        'created_at' => "Created on",
        'updated_at' => "Updated on",
        'deleted_at' => "Deleted on",
    ],

    'actions' => [
        'create' => [
            'label' => "New Menu",
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

    'advancedOptions' => [
        'title' => "Advanced options",
    ],

    'items' => [
        'title' => "Menu Items",
        'singular' => "Menu Item",
        'plural' => "Menu Items",

        'attributes' => [
            'id' => "ID",
            'menu' => "Menu",
            'parent' => "Parent",
            'target' => "Target",
            'href' => "Link (URL)",
            'title' => "Title",
            'created_at' => "Created on",
            'updated_at' => "Updated on",
            'deleted_at' => "Deleted on",
        ],

        'meta' => [
            'class' => "Class",
            'rel' => "Rel",
            'target' => "Target",
        ],

        'actions' => [
            'create' => [
                'label' => "Add Menu Item",
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

        'alerts' => [
            'differs_from_target' => "Details for this menu item differs from the target",
            'href_differs_from_target' => "The URL differs from the target's URL: :target_url",
            'title_differs_from_target' => "The title differs from the target's title: :target_title",
        ],
    ],
];
