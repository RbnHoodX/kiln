<?php
declare(strict_types=1);

class GlazeCalculator
{
    private float $sio2;
    private float $al2o3;
    private float $fluxTotal;

    public function __construct(float $sio2, float $al2o3, float $fluxTotal)
    {
        $this->sio2 = $sio2;
        $this->al2o3 = $al2o3;
        $this->fluxTotal = $fluxTotal;
    }

    public function getSio2(): float
    {
        return $this->sio2;
    }

    public function getAl2o3(): float
    {
        return $this->al2o3;
    }

    public function getFluxTotal(): float
    {
        return $this->fluxTotal;
    }

    
    public function silicaAluminaRatio(): float
    {
        if ($this->al2o3 <= 0.0) {
            return 0.0;
        }
        return round($this->sio2 / $this->al2o3, 4);
    }

    
    public function fluxFraction(float $totalMoles): float
    {
        if ($totalMoles <= 0.0) {
            return 0.0;
        }
        return round($this->fluxTotal / $totalMoles, 4);
    }

    
    public function unityFormula(): array
    {
        if ($this->fluxTotal <= 0.0) {
            return ['sio2' => 0.0, 'al2o3' => 0.0, 'flux' => 0.0];
        }
        $factor = 1.0 / $this->fluxTotal;
        return [
            'sio2'  => round($this->sio2 * $factor, 4),
            'al2o3' => round($this->al2o3 * $factor, 4),
            'flux'  => 1.0,
        ];
    }

    
    public function thermalExpansion(): float
    {
        $base = 7.0;
        $silicaContrib = $this->sio2 * -0.5;
        $aluminaContrib = $this->al2o3 * 0.3;
        $fluxContrib = $this->fluxTotal * 1.2;
        return round($base + $silicaContrib + $aluminaContrib + $fluxContrib, 4);
    }

    
    public function crazeRisk(): string
    {
        $exp = $this->thermalExpansion();
        if ($exp > 9.0) {
            return 'high';
        } elseif ($exp > 7.0) {
            return 'moderate';
        }
        return 'low';
    }
}
