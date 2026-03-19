<?php
declare(strict_types=1);

class WedgingLog
{
    
    private array $entries = [];

    
    public function record(string $date, float $weight, string $technique, int $duration): void
    {
        $this->entries[] = [
            'date'      => $date,
            'weight'    => $weight,
            'technique' => $technique,
            'duration'  => max(0, $duration),
        ];
    }

    public function count(): int
    {
        return count($this->entries);
    }

    
    public function getEntries(): array
    {
        return $this->entries;
    }

    
    public function totalWeight(): float
    {
        $sum = 0.0;
        foreach ($this->entries as $e) {
            $sum += $e['weight'];
        }
        return round($sum, 2);
    }

    
    public function totalMinutes(): int
    {
        $sum = 0;
        foreach ($this->entries as $e) {
            $sum += $e['duration'];
        }
        return $sum;
    }

    
    public function averageDuration(): float
    {
        if ($this->count() === 0) {
            return 0.0;
        }
        return round($this->totalMinutes() / $this->count(), 2);
    }

    
    public function byTechnique(string $technique): array
    {
        $result = [];
        foreach ($this->entries as $e) {
            if ($e['technique'] === $technique) {
                $result[] = $e;
            }
        }
        return $result;
    }

    
    public function preferredTechnique(): string
    {
        $counts = [];
        foreach ($this->entries as $e) {
            $t = $e['technique'];
            $counts[$t] = ($counts[$t] ?? 0) + 1;
        }
        if (empty($counts)) {
            return '';
        }
        arsort($counts);
        return array_key_first($counts);
    }
}
