<?php

namespace App\Enums;

enum CourseStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public static function values(): array
    {
        return array_map(
            fn (CourseStatus $status) => $status->value,
            self::cases()
        );
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(
                fn (CourseStatus $status) => [$status->value => ucfirst(strtolower(($status->name)))]
            )->all();
    }
}
