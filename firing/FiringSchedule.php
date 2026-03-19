<?php
declare(strict_types=1);

class FiringSchedule
{
    
    private array $segments = [];

    
    public function addSegment(float $ratePerHour, int $targetTemp, int $holdMinutes): void
    {
        $this->segments[] = [
            'rate'   => $ratePerHour,
            'target' => $targetTemp,
            'hold'   => max(0, $holdMinutes),
        ];
    }

    
    public function getSegments(): array
    {
        return $this->segments;
    }

    public function segmentCount(): int
    {
        return count($this->segments);
    }

    
    public function totalDuration(): float
    {
        $total = 0.0;
        $currentTemp = 25; // room temperature start
        foreach ($this->segments as $seg) {
            $delta = abs($seg['target'] - $currentTemp);
            if ($seg['rate'] > 0) {
                $rampMinutes = ($delta / $seg['rate']) * 60.0;
                $total += $rampMinutes;
            }
            $total += $seg['hold'];
            $currentTemp = $seg['target'];
        }
        return round($total, 2);
    }

    
    public function peakTemperature(): int
    {
        $peak = 0;
        foreach ($this->segments as $seg) {
            if ($seg['target'] > $peak) {
                $peak = $seg['target'];
            }
        }
        return $peak;
    }

    
    public function summary(): string
    {
        $lines = [];
        foreach ($this->segments as $i => $seg) {
            $lines[] = sprintf(
                'Seg %d: %d C/hr -> %d C, hold %d min',
                $i + 1,
                (int) $seg['rate'],
                $seg['target'],
                $seg['hold']
            );
        }
        $lines[] = sprintf('Total: %.0f min | Peak: %d C', $this->totalDuration(), $this->peakTemperature());
        return implode("\n", $lines);
    }
}
