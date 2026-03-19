<?php
declare(strict_types=1);

class MathHelper
{
    
    public static function mean(array $values): float
    {
        if (empty($values)) {
            return 0.0;
        }
        return round(array_sum($values) / count($values), 6);
    }

    
    public static function median(array $values): float
    {
        if (empty($values)) {
            return 0.0;
        }
        sort($values);
        $n = count($values);
        $mid = intdiv($n, 2);
        if ($n % 2 === 0) {
            return round(($values[$mid - 1] + $values[$mid]) / 2.0, 6);
        }
        return (float) $values[$mid];
    }

    
    public static function stdDev(array $values): float
    {
        if (count($values) < 2) {
            return 0.0;
        }
        $m = self::mean($values);
        $sumSqDiff = 0.0;
        foreach ($values as $v) {
            $sumSqDiff += ($v - $m) ** 2;
        }
        return round(sqrt($sumSqDiff / count($values)), 6);
    }

    
    public static function clamp(float $value, float $min, float $max): float
    {
        return max($min, min($max, $value));
    }

    
    public static function lerp(float $a, float $b, float $t): float
    {
        return round($a + ($b - $a) * $t, 6);
    }

    
    public static function percentile(array $values, float $p): float
    {
        if (empty($values)) {
            return 0.0;
        }
        sort($values);
        $p = self::clamp($p, 0.0, 100.0);
        $n = count($values);
        $rank = ($p / 100.0) * ($n - 1);
        $lower = (int) floor($rank);
        $upper = (int) ceil($rank);
        if ($lower === $upper) {
            return (float) $values[$lower];
        }
        $frac = $rank - $lower;
        return round($values[$lower] + $frac * ($values[$upper] - $values[$lower]), 6);
    }

    
    public static function sum(array $values): float
    {
        return array_sum($values);
    }
}
