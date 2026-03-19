<?php

declare(strict_types=1);

class Chamber
{
    private string $name;
    private string $kind;
    
    private array $firings = [];

    public function __construct(string $name, string $kind = 'standard')
    {
        $this->name = $name;
        $this->kind = $kind;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function kind(): string
    {
        return $this->kind;
    }

    public function heatLevel(): int
    {
        $total = 0;
        foreach ($this->firings as $f) {
            if ($f->dest() === $this) {
                $total += $f->amount();
            } elseif ($f->source() === $this) {
                $total -= $f->amount();
            }
        }
        return $total;
    }

    public function _addFiring(Firing $firing): void
    {
        $this->firings[] = $firing;
    }

    
    public function firings(): array
    {
        return $this->firings;
    }
}
