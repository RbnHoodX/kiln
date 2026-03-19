<?php
declare(strict_types=1);

class SupplierInfo
{
    private string $name;
    private string $contact;
    private int $leadTimeDays;
    
    private array $materials;

    
    public function __construct(string $name, string $contact, int $leadTimeDays, array $materials)
    {
        $this->name = $name;
        $this->contact = $contact;
        $this->leadTimeDays = max(0, $leadTimeDays);
        $this->materials = $materials;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function getLeadTimeDays(): int
    {
        return $this->leadTimeDays;
    }

    
    public function getMaterials(): array
    {
        return $this->materials;
    }

    
    public function supplies(string $material): bool
    {
        return in_array($material, $this->materials, true);
    }

    
    public function materialCount(): int
    {
        return count($this->materials);
    }

    
    public function isFastShipper(): bool
    {
        return $this->leadTimeDays <= 7;
    }

    
    public function estimatedDelivery(string $orderDate): string
    {
        $ts = strtotime($orderDate);
        if ($ts === false) {
            return '';
        }
        return date('Y-m-d', $ts + $this->leadTimeDays * 86400);
    }

    
    public function sharedMaterials(SupplierInfo $other): array
    {
        return array_values(array_intersect($this->materials, $other->materials));
    }

    public function describe(): string
    {
        return sprintf(
            '%s (%s) — %d materials, %d-day lead time',
            $this->name,
            $this->contact,
            $this->materialCount(),
            $this->leadTimeDays
        );
    }
}
