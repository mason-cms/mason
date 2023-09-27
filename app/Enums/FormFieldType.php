<?php

namespace App\Enums;

enum FormFieldType: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case EMAIL = 'email';

    public function label(): string
    {
        return __("forms.fields.types.{$this->value}");
    }
}
