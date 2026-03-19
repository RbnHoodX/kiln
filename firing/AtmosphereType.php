<?php
declare(strict_types=1);

class AtmosphereType
{
    public const OXIDATION = 'oxidation';
    public const REDUCTION = 'reduction';
    public const NEUTRAL   = 'neutral';

    private string $type;
    private float $oxygenPct;

    public function __construct(string $type, float $oxygenPct)
    {
        $this->type = $type;
        $this->oxygenPct = max(0.0, min(100.0, $oxygenPct));
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOxygenPct(): float
    {
        return $this->oxygenPct;
    }

    
    public static function oxidation(): self
    {
        return new self(self::OXIDATION, 21.0);
    }

    
    public static function reduction(): self
    {
        return new self(self::REDUCTION, 5.0);
    }

    
    public static function neutral(): self
    {
        return new self(self::NEUTRAL, 12.0);
    }

    public function isOxidation(): bool
    {
        return $this->type === self::OXIDATION;
    }

    public function isReduction(): bool
    {
        return $this->type === self::REDUCTION;
    }

    
    public function isSafeLevel(): bool
    {
        return match ($this->type) {
            self::OXIDATION => $this->oxygenPct >= 18.0,
            self::REDUCTION => $this->oxygenPct <= 10.0,
            self::NEUTRAL   => $this->oxygenPct >= 8.0 && $this->oxygenPct <= 16.0,
            default         => false,
        };
    }

    public function describe(): string
    {
        $safe = $this->isSafeLevel() ? 'safe' : 'WARNING';
        return sprintf('%s atmosphere (O2: %.1f%%, %s)', $this->type, $this->oxygenPct, $safe);
    }
}
