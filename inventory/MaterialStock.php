<?php
declare(strict_types=1);

class MaterialStock
{
    private string $name;
    private string $unit;
    private float $quantity;
    private float $reorderPoint;

    public function __construct(string $name, string $unit, float $quantity, float $reorderPoint)
    {
        $this->name = $name;
        $this->unit = $unit;
        $this->quantity = max(0.0, $quantity);
        $this->reorderPoint = max(0.0, $reorderPoint);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getReorderPoint(): float
    {
        return $this->reorderPoint;
    }

    
    public function isLow(): bool
    {
        return $this->quantity <= $this->reorderPoint;
    }

    
    public function consume(float $amount): void
    {
        $this->quantity = max(0.0, $this->quantity - $amount);
    }

    
    public function receive(float $amount): void
    {
        $this->quantity += max(0.0, $amount);
    }

    
    public function orderQuantity(float $targetLevel): float
    {
        if ($this->quantity >= $targetLevel) {
            return 0.0;
        }
        return round($targetLevel - $this->quantity, 2);
    }

    
    public function daysRemaining(float $dailyUsage): float
    {
        if ($dailyUsage <= 0.0) {
            return PHP_FLOAT_MAX;
        }
        return round($this->quantity / $dailyUsage, 1);
    }

    public function describe(): string
    {
        $status = $this->isLow() ? 'LOW' : 'OK';
        return sprintf('%s: %.1f %s (%s, reorder at %.1f)', $this->name, $this->quantity, $this->unit, $status, $this->reorderPoint);
    }
}
