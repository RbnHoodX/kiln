<?php
declare(strict_types=1);

class DefectType
{
    public const CRACK    = 'crack';
    public const PINHOLE  = 'pinhole';
    public const CRAWLING = 'crawling';
    public const BLOATING = 'bloating';
    public const WARPING  = 'warping';
    public const DUNTING  = 'dunting';
    public const SHIVERING = 'shivering';
    public const BLISTERING = 'blistering';

    
    private const SEVERITY = [
        self::PINHOLE    => 1,
        self::CRAWLING   => 2,
        self::WARPING    => 2,
        self::SHIVERING  => 3,
        self::BLISTERING => 3,
        self::BLOATING   => 4,
        self::CRACK      => 4,
        self::DUNTING     => 5,
    ];

    
    public static function all(): array
    {
        return [
            self::CRACK,
            self::PINHOLE,
            self::CRAWLING,
            self::BLOATING,
            self::WARPING,
            self::DUNTING,
            self::SHIVERING,
            self::BLISTERING,
        ];
    }

    
    public static function severity(string $code): int
    {
        return self::SEVERITY[$code] ?? 0;
    }

    
    public static function isCritical(string $code): bool
    {
        return self::severity($code) >= 4;
    }

    
    public static function filterCritical(array $codes): array
    {
        $result = [];
        foreach ($codes as $c) {
            if (self::isCritical($c)) {
                $result[] = $c;
            }
        }
        return $result;
    }

    
    public static function totalSeverity(array $codes): int
    {
        $sum = 0;
        foreach ($codes as $c) {
            $sum += self::severity($c);
        }
        return $sum;
    }

    
    public static function isValid(string $code): bool
    {
        return in_array($code, self::all(), true);
    }
}
