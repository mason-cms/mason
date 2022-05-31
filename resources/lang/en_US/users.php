<?php

return [
    'title' => "Users",
    'singular' => "User",
    'plural' => "Users",
    'pagination' => "{0} No users|{1} One user|[2,*] Showing :count users out of :total",
    'no_records' => "There are no users at this moment.",
    'attributes' => [
        'id' => "ID",
        'name' => "Name",
        'email' => "Email",
        'password' => "Password",
        'password_confirmation' => "Password (confirmation)",
        'is_root' => "Root user",
        'created_at' => "Created on",
        'updated_at' => "Updated on",
        'deleted_at' => "Deleted on",
    ],
    'actions' => [
        'create' => [
            'label' => "New User",
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
