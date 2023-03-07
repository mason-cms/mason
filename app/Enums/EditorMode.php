<?php

namespace App\Enums;

enum EditorMode: string
{
    case WYSIWYG = 'wysiwyg';
    case CODE = 'code';

    public function cssClass(): string
    {
        return match ($this) {
            self::WYSIWYG => 'ck-editor',
            self::CODE => 'ace-editor is-code',
        };
    }
}
