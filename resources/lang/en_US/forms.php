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
        'confirmation_message' => "Confirmation message",
        'send_to' => "Send to",
        'redirect_to' => "Redirect to",
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

        'submit' => [
            'label' => "Submit",
            'success' => "Form has been submitted successfully.",
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
            'placeholder' => "Placeholder",
            'default_value' => "Default value",
            'class' => "Class",
            'rules' => "Rules",
            'options' => "Options",
            'columns' => "Columns",
            'rank' => "Rank",
            'created_at' => "Created on",
            'updated_at' => "Updated on",
            'deleted_at' => "Deleted on",
        ],

        'help' => [
            'rules' => "In the Laravel validation format",
            'options' => "Enter one option per line in the value:label format",
        ],

        'types' => [
            'text' => "Text",
            'number' => "Number",
            'email' => "Email",
            'tel' => "Phone Number",
            'textarea' => "Textarea",
            'file' => "File",
            'select' => "Select",
            'checkboxes' => "Checkboxes",
            'radios' => "Radios",
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
            'input' => "Input",
            'user_agent' => "Browser",
            'user_ip' => "IP Address",
            'referrer_url' => "Page",
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
