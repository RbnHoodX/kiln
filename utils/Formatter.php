<?php
declare(strict_types=1);

class Formatter
{
    
    public static function number(float $value, int $decimals = 2): string
    {
        return number_format($value, $decimals, '.', '');
    }

    
    public static function temperature(int $tempC): string
    {
        return $tempC . ' C';
    }

    
    public static function temperatureFancy(int $tempC): string
    {
        return $tempC . "\u{00B0}C";
    }

    
    public static function percentage(float $value, int $decimals = 1): string
    {
        return number_format($value, $decimals, '.', '') . '%';
    }

    
    public static function padRight(string $text, int $width): string
    {
        return str_pad($text, $width, ' ', STR_PAD_RIGHT);
    }

    
    public static function padLeft(string $text, int $width): string
    {
        return str_pad($text, $width, ' ', STR_PAD_LEFT);
    }

    
    public static function duration(float $minutes): string
    {
        $h = (int) floor($minutes / 60);
        $m = (int) round($minutes - $h * 60);
        if ($h > 0) {
            return sprintf('%dh %dm', $h, $m);
        }
        return sprintf('%dm', $m);
    }

    
    public static function weight(float $value, string $unit = 'kg'): string
    {
        return self::number($value) . ' ' . $unit;
    }

    
    public static function truncate(string $text, int $maxLen): string
    {
        if (mb_strlen($text) <= $maxLen) {
            return $text;
        }
        return mb_substr($text, 0, $maxLen - 3) . '...';
    }

    
    public static function separator(int $length = 40, string $char = '-'): string
    {
        return str_repeat($char, $length);
    }
}
