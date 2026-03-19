<?php
declare(strict_types=1);

class RecycleBlend
{
    private float $reclaimWeight;
    private float $freshWeight;
    private float $reclaimMoisture;
    private float $freshMoisture;

    
    public function __construct(float $reclaimWeight, float $freshWeight, float $reclaimMoisture, float $freshMoisture)
    {
        $this->reclaimWeight = max(0.0, $reclaimWeight);
        $this->freshWeight = max(0.0, $freshWeight);
        $this->reclaimMoisture = max(0.0, min(100.0, $reclaimMoisture));
        $this->freshMoisture = max(0.0, min(100.0, $freshMoisture));
    }

    public function totalWeight(): float
    {
        return round($this->reclaimWeight + $this->freshWeight, 2);
    }

    
    public function reclaimRatio(): float
    {
        $total = $this->totalWeight();
        if ($total <= 0.0) {
            return 0.0;
        }
        return round($this->reclaimWeight / $total, 4);
    }

    
    public function blendedMoisture(): float
    {
        $total = $this->totalWeight();
        if ($total <= 0.0) {
            return 0.0;
        }
        $weighted = ($this->reclaimWeight * $this->reclaimMoisture + $this->freshWeight * $this->freshMoisture) / $total;
        return round($weighted, 2);
    }

    
    public function waterAdjustment(float $targetMoisturePct): float
    {
        $total = $this->totalWeight();
        $currentWater = $total * ($this->blendedMoisture() / 100.0);
        $desiredDry = $total - $currentWater;
        $targetTotal = $desiredDry / (1.0 - $targetMoisturePct / 100.0);
        return round($targetTotal - $total, 3);
    }

    
    public function isSafeRatio(): bool
    {
        return $this->reclaimRatio() <= 0.30;
    }

    
    public function dryWeight(): float
    {
        $rDry = $this->reclaimWeight * (1.0 - $this->reclaimMoisture / 100.0);
        $fDry = $this->freshWeight * (1.0 - $this->freshMoisture / 100.0);
        return round($rDry + $fDry, 3);
    }

    public function describe(): string
    {
        return sprintf(
            'Blend: %.1fkg reclaim + %.1fkg fresh = %.1fkg (%.1f%% moisture, reclaim ratio %.0f%%)',
            $this->reclaimWeight,
            $this->freshWeight,
            $this->totalWeight(),
            $this->blendedMoisture(),
            $this->reclaimRatio() * 100
        );
    }
}
