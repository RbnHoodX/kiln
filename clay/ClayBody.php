<?php
declare(strict_types=1);

class ClayBody
{
    private string $name;
    private float $shrinkage;
    private float $absorption;
    private int $firingRangeLow;
    private int $firingRangeHigh;

    public function __construct(
        string $name,
        float $shrinkage,
        float $absorption,
        int $firingRangeLow,
        int $firingRangeHigh
    ) {
        $this->name = $name;
        $this->shrinkage = $shrinkage;
        $this->absorption = $absorption;
        $this->firingRangeLow = $firingRangeLow;
        $this->firingRangeHigh = $firingRangeHigh;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getShrinkage(): float
    {
        return $this->shrinkage;
    }

    public function getAbsorption(): float
    {
        return $this->absorption;
    }

    
    public function getFiringRange(): array
    {
        return ['low' => $this->firingRangeLow, 'high' => $this->firingRangeHigh];
    }

    
    public function isStoneware(): bool
    {
        return $this->firingRangeLow >= 1200 && $this->firingRangeHigh <= 1300;
    }

    
    public function isPorcelain(): bool
    {
        return $this->firingRangeLow >= 1260 && $this->absorption < 1.0;
    }

    
    public function isEarthenware(): bool
    {
        return $this->firingRangeHigh <= 1150;
    }

    
    public function canFireAt(int $temp): bool
    {
        return $temp >= $this->firingRangeLow && $temp <= $this->firingRangeHigh;
    }

    
    public function finishedSizePct(): float
    {
        return round(100.0 - $this->shrinkage, 2);
    }

    public function describe(): string
    {
        $type = 'earthenware';
        if ($this->isPorcelain()) {
            $type = 'porcelain';
        } elseif ($this->isStoneware()) {
            $type = 'stoneware';
        }
        return sprintf('%s (%s, %d-%d C)', $this->name, $type, $this->firingRangeLow, $this->firingRangeHigh);
    }
}
