<?php
declare(strict_types=1);

class GlazeRecipe
{
    private string $name;
    private string $baseMineral;
    private int $firingTemp;
    private float $shrinkagePct;

    public function __construct(string $name, string $baseMineral, int $firingTemp, float $shrinkagePct)
    {
        $this->name = $name;
        $this->baseMineral = $baseMineral;
        $this->firingTemp = $firingTemp;
        $this->shrinkagePct = $shrinkagePct;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBaseMineral(): string
    {
        return $this->baseMineral;
    }

    public function getFiringTemp(): int
    {
        return $this->firingTemp;
    }

    public function getShrinkagePct(): float
    {
        return $this->shrinkagePct;
    }

    
    public function isHighFire(): bool
    {
        return $this->firingTemp > 1200;
    }

    
    public function mixRatio(float $mineralWeight, float $totalBatchWeight): float
    {
        if ($totalBatchWeight <= 0.0) {
            return 0.0;
        }
        $ratio = $mineralWeight / $totalBatchWeight;
        return min(1.0, max(0.0, $ratio));
    }

    
    public function summary(): string
    {
        $level = $this->isHighFire() ? 'high-fire' : 'low-fire';
        return sprintf('%s (%s, %d C, %s)', $this->name, $this->baseMineral, $this->firingTemp, $level);
    }

    
    public function adjustedShrinkage(float $thicknessMm): float
    {
        $factor = 1.0 + ($thicknessMm * 0.05);
        return round($this->shrinkagePct * $factor, 2);
    }
}
