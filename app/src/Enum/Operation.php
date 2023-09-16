<?php

namespace App\Enum;

enum Operation: string
{
    case PLUS = "+";
    case MINUS = "-";
    case MULTIPLE = "*";
    case DIVIDE = "/";

    public static function FromString(string $str): Operation
    {
        return match ($str) {
            '+' => Operation::PLUS,
            '-' => Operation::MINUS,
            '*' => Operation::MULTIPLE,
            '/' => Operation::DIVIDE,
        };
    }
}