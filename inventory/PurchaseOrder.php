<?php
declare(strict_types=1);

class PurchaseOrder
{
    private string $supplier;
    
    private array $lineItems = [];
    private string $status;

    
    public function __construct(string $supplier, string $status = 'draft')
    {
        $this->supplier = $supplier;
        $this->status = $status;
    }

    public function getSupplier(): string
    {
        return $this->supplier;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    
    public function addItem(string $item, float $qty, float $unitCost): void
    {
        $this->lineItems[] = [
            'item'     => $item,
            'qty'      => $qty,
            'unitCost' => $unitCost,
        ];
    }

    
    public function itemCount(): int
    {
        return count($this->lineItems);
    }

    
    public function getItems(): array
    {
        return $this->lineItems;
    }

    
    public function totalCost(): float
    {
        $sum = 0.0;
        foreach ($this->lineItems as $li) {
            $sum += $li['qty'] * $li['unitCost'];
        }
        return round($sum, 2);
    }

    
    public function totalQuantity(): float
    {
        $sum = 0.0;
        foreach ($this->lineItems as $li) {
            $sum += $li['qty'];
        }
        return $sum;
    }

    public function isOpen(): bool
    {
        return in_array($this->status, ['draft', 'submitted'], true);
    }

    public function submit(): void
    {
        if ($this->status === 'draft') {
            $this->status = 'submitted';
        }
    }

    public function receive(): void
    {
        if ($this->status === 'submitted') {
            $this->status = 'received';
        }
    }

    public function summary(): string
    {
        return sprintf(
            'PO to %s: %d items, $%.2f total (%s)',
            $this->supplier,
            $this->itemCount(),
            $this->totalCost(),
            $this->status
        );
    }
}
