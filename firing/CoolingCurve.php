<?php
declare(strict_types=1);

class CoolingCurve
{
    private float $peakTemp;
    private float $ambientTemp;
    private float $coolingConstant;

    
    public function __construct(float $peakTemp, float $ambientTemp = 25.0, float $coolingConstant = 0.05)
    {
        $this->peakTemp = $peakTemp;
        $this->ambientTemp = $ambientTemp;
        $this->coolingConstant = $coolingConstant;
    }

    public function getPeakTemp(): float
    {
        return $this->peakTemp;
    }

    public function getAmbientTemp(): float
    {
        return $this->ambientTemp;
    }

    
    public function temperatureAt(float $hours): float
    {
        $delta = $this->peakTemp - $this->ambientTemp;
        return round($this->ambientTemp + $delta * exp(-$this->coolingConstant * $hours), 2);
    }

    
    public function timeToTarget(float $targetTemp): ?float
    {
        if ($targetTemp <= $this->ambientTemp || $targetTemp >= $this->peakTemp) {
            return null;
        }
        $delta = $this->peakTemp - $this->ambientTemp;
        $fraction = ($targetTemp - $this->ambientTemp) / $delta;
        $hours = -log($fraction) / $this->coolingConstant;
        return round($hours, 2);
    }

    
    public function isSafeToOpen(float $hours): bool
    {
        return $this->temperatureAt($hours) <= 100.0;
    }

    
    public function curve(float $intervalHours, int $points): array
    {
        $data = [];
        for ($i = 0; $i < $points; $i++) {
            $t = $i * $intervalHours;
            $data[] = ['hour' => $t, 'temp' => $this->temperatureAt($t)];
        }
        return $data;
    }

    
    public function hoursUntilSafe(): ?float
    {
        return $this->timeToTarget(100.0);
    }
}
