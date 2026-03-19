<?php
declare(strict_types=1);

class Validator
{
    
    public static function isPositive(float $value): bool
    {
        return $value > 0.0;
    }

    
    public static function isInRange(float $value, float $min, float $max): bool
    {
        return $value >= $min && $value <= $max;
    }

    
    public static function isValidName(string $name): bool
    {
        if ($name === '') {
            return false;
        }
        return (bool) preg_match('/^[a-zA-Z0-9 _\-]+$/', $name);
    }

    
    public static function requireNotNull(mixed $value, string $label = 'value'): void
    {
        if ($value === null) {
            throw new \InvalidArgumentException("$label must not be null");
        }
    }

    
    public static function requireNotBlank(string $value, string $label = 'value'): void
    {
        if (trim($value) === '') {
            throw new \InvalidArgumentException("$label must not be blank");
        }
    }

    
    public static function isValidTemperature(int $temp): bool
    {
        return $temp >= 0 && $temp <= 1500;
    }

    
    public static function isValidPercentage(float $pct): bool
    {
        return $pct >= 0.0 && $pct <= 100.0;
    }

    
    public static function allNonEmpty(array $items): bool
    {
        foreach ($items as $item) {
            if (trim($item) === '') {
                return false;
            }
        }
        return true;
    }

    
    public static function isOneOf(string $value, array $allowed): bool
    {
        return in_array($value, $allowed, true);
    }
}
