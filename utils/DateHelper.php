<?php
declare(strict_types=1);

class DateHelper
{
    
    public static function formatTimestamp(int $timestamp): string
    {
        return date('Y-m-d\TH:i:s', $timestamp);
    }

    
    public static function formatDate(int $timestamp): string
    {
        return date('Y-m-d', $timestamp);
    }

    
    public static function elapsed(int $start, int $end): string
    {
        $diff = abs($end - $start);
        $hours = intdiv($diff, 3600);
        $minutes = intdiv($diff % 3600, 60);
        $seconds = $diff % 60;
        $parts = [];
        if ($hours > 0) {
            $parts[] = "{$hours}h";
        }
        if ($minutes > 0) {
            $parts[] = "{$minutes}m";
        }
        if ($seconds > 0 || empty($parts)) {
            $parts[] = "{$seconds}s";
        }
        return implode(' ', $parts);
    }

    
    public static function elapsedMinutes(int $start, int $end): float
    {
        return round(abs($end - $start) / 60.0, 2);
    }

    
    public static function parseSchedule(string $schedule): int
    {
        $hours = 0;
        $minutes = 0;
        if (preg_match('/(\d+)h/', $schedule, $m)) {
            $hours = (int) $m[1];
        }
        if (preg_match('/(\d+)m/', $schedule, $m)) {
            $minutes = (int) $m[1];
        }
        return $hours * 60 + $minutes;
    }

    
    public static function toScheduleString(int $totalMinutes): string
    {
        $h = intdiv($totalMinutes, 60);
        $m = $totalMinutes % 60;
        if ($h > 0 && $m > 0) {
            return "{$h}h{$m}m";
        } elseif ($h > 0) {
            return "{$h}h";
        }
        return "{$m}m";
    }

    
    public static function isSameDay(int $a, int $b): bool
    {
        return date('Y-m-d', $a) === date('Y-m-d', $b);
    }

    
    public static function today(): string
    {
        return date('Y-m-d');
    }
}
