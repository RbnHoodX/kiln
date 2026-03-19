<?php
declare(strict_types=1);

class MoistureContent
{
    private float $wetWeight;
    private float $dryWeight;

    
    public function __construct(float $wetWeight, float $dryWeight)
    {
        $this->wetWeight = max(0.0, $wetWeight);
        $this->dryWeight = max(0.0, $dryWeight);
    }

    public function getWetWeight(): float
    {
        return $this->wetWeight;
    }

    public function getDryWeight(): float
    {
        return $this->dryWeight;
    }

    
    public function percentage(): float
    {
        if ($this->wetWeight <= 0.0) {
            return 0.0;
        }
        return round(($this->wetWeight - $this->dryWeight) / $this->wetWeight * 100.0, 2);
    }

    
    public function waterWeight(): float
    {
        return round(max(0.0, $this->wetWeight - $this->dryWeight), 2);
    }

    
    public function isWorkable(): bool
    {
        $pct = $this->percentage();
        return $pct >= 18.0 && $pct <= 25.0;
    }

    
    public function isDryEnough(): bool
    {
        return $this->percentage() < 5.0;
    }

    
    public function estimatedDryingHours(float $targetPct = 5.0, float $ratePerHour = 2.0): float
    {
        $current = $this->percentage();
        if ($current <= $targetPct || $ratePerHour <= 0.0) {
            return 0.0;
        }
        return round(($current - $targetPct) / $ratePerHour, 2);
    }

    
    public function stage(): string
    {
        $pct = $this->percentage();
        if ($pct >= 20.0) {
            return 'wet';
        } elseif ($pct >= 8.0) {
            return 'leather-hard';
        }
        return 'bone-dry';
    }

    public function describe(): string
    {
        return sprintf('%.1fg wet / %.1fg dry = %.1f%% moisture (%s)', $this->wetWeight, $this->dryWeight, $this->percentage(), $this->stage());
    }
}
