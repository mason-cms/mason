<?php

namespace App\Enums;

enum FormFieldType: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case EMAIL = 'email';
    case TEL = 'tel';
    case TEXTAREA = 'textarea';
    case FILE = 'file';
    case SELECT = 'select';
    case CHECKBOXES = 'checkboxes';
    case RADIOS = 'radios';

    public function label(): string
    {
        return __("forms.fields.types.{$this->value}");
    }
}
