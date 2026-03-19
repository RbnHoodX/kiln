<?php
declare(strict_types=1);

class ApplicationMethod
{
    public const DIPPING  = 'dipping';
    public const SPRAYING = 'spraying';
    public const BRUSHING = 'brushing';
    public const POURING  = 'pouring';

    
    private const THICKNESS_MAP = [
        self::DIPPING  => 1.2,
        self::SPRAYING => 0.8,
        self::BRUSHING => 1.5,
        self::POURING  => 1.0,
    ];

    private string $method;
    private int $coats;

    public function __construct(string $method, int $coats = 1)
    {
        $this->method = $method;
        $this->coats = max(1, $coats);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getCoats(): int
    {
        return $this->coats;
    }

    
    public static function supported(): array
    {
        return [self::DIPPING, self::SPRAYING, self::BRUSHING, self::POURING];
    }

    
    public function estimatedThickness(): float
    {
        $base = self::THICKNESS_MAP[$this->method] ?? 1.0;
        $total = $base;
        for ($i = 1; $i < $this->coats; $i++) {
            $total += $base * 0.7;
        }
        return round($total, 2);
    }

    
    public static function thicker(string $methodA, string $methodB, int $coats): string
    {
        $a = new self($methodA, $coats);
        $b = new self($methodB, $coats);
        return $a->estimatedThickness() >= $b->estimatedThickness() ? $methodA : $methodB;
    }

    
    public function dryingMinutes(): int
    {
        $baseTimes = [
            self::DIPPING  => 20,
            self::SPRAYING => 10,
            self::BRUSHING => 30,
            self::POURING  => 25,
        ];
        $base = $baseTimes[$this->method] ?? 20;
        return $base + (int) (($this->coats - 1) * $base * 0.4);
    }

    public function describe(): string
    {
        return sprintf('%s (%d coat%s, ~%.1f mm)', $this->method, $this->coats, $this->coats > 1 ? 's' : '', $this->estimatedThickness());
    }
}
