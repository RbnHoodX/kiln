<?php
declare(strict_types=1);

class ConeChart
{
    
    private const MAP = [
        '022' =>  585,
        '020' =>  626,
        '018' =>  696,
        '016' =>  769,
        '014' =>  834,
        '012' =>  884,
        '010' =>  900,
        '08'  =>  945,
        '06'  =>  999,
        '04'  => 1063,
        '02'  => 1101,
        '01'  => 1117,
        '1'   => 1136,
        '2'   => 1142,
        '3'   => 1152,
        '4'   => 1168,
        '5'   => 1186,
        '6'   => 1222,
        '7'   => 1240,
        '8'   => 1263,
        '9'   => 1280,
        '10'  => 1305,
        '11'  => 1315,
        '12'  => 1326,
        '13'  => 1346,
    ];

    
    public static function lookup(string $cone): ?int
    {
        return self::MAP[$cone] ?? null;
    }

    
    public static function nearestCone(int $temperature): string
    {
        $best = '';
        $bestDiff = PHP_INT_MAX;
        foreach (self::MAP as $cone => $temp) {
            $diff = abs($temp - $temperature);
            if ($diff < $bestDiff) {
                $bestDiff = $diff;
                $best = $cone;
            }
        }
        return $best;
    }

    
    public static function allCones(): array
    {
        return array_keys(self::MAP);
    }

    
    public static function range(): array
    {
        $temps = array_values(self::MAP);
        return ['low' => min($temps), 'high' => max($temps)];
    }

    
    public static function conesInRange(int $minTemp, int $maxTemp): array
    {
        $result = [];
        foreach (self::MAP as $cone => $temp) {
            if ($temp >= $minTemp && $temp <= $maxTemp) {
                $result[] = $cone;
            }
        }
        return $result;
    }
}
