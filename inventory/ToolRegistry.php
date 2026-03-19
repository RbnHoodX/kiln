<?php
declare(strict_types=1);

class ToolRegistry
{
    
    private array $tools = [];

    
    public function register(string $name, string $condition, string $lastMaintenance, string $location): void
    {
        $this->tools[$name] = [
            'condition'       => $condition,
            'lastMaintenance' => $lastMaintenance,
            'location'        => $location,
        ];
    }

    public function count(): int
    {
        return count($this->tools);
    }

    
    public function find(string $name): ?array
    {
        return $this->tools[$name] ?? null;
    }

    
    public function updateCondition(string $name, string $condition): void
    {
        if (isset($this->tools[$name])) {
            $this->tools[$name]['condition'] = $condition;
        }
    }

    
    public function recordMaintenance(string $name, string $date): void
    {
        if (isset($this->tools[$name])) {
            $this->tools[$name]['lastMaintenance'] = $date;
            if ($this->tools[$name]['condition'] === 'poor') {
                $this->tools[$name]['condition'] = 'fair';
            }
        }
    }

    
    public function needsMaintenance(): array
    {
        $result = [];
        foreach ($this->tools as $name => $info) {
            if ($info['condition'] === 'poor') {
                $result[] = $name;
            }
        }
        return $result;
    }

    
    public function atLocation(string $location): array
    {
        $result = [];
        foreach ($this->tools as $name => $info) {
            if ($info['location'] === $location) {
                $result[] = $name;
            }
        }
        return $result;
    }

    
    public function allNames(): array
    {
        return array_keys($this->tools);
    }
}
