<?php

namespace App\Enums;

enum QuizDifficulty: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';

    /**
     * Get all difficulty levels as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get difficulty level display name.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::EASY => 'Easy',
            self::MEDIUM => 'Medium',
            self::HARD => 'Hard',
        };
    }

    /**
     * Get color for the difficulty level.
     *
     * @return string
     */
    public function color(): string
    {
        return match($this) {
            self::EASY => 'success',
            self::MEDIUM => 'warning',
            self::HARD => 'error',
        };
    }
}
