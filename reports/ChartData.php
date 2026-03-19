<?php
declare(strict_types=1);

class ChartData
{
    private string $title;
    
    private array $labels;
    
    private array $series = [];
    private float $yMin;
    private float $yMax;

    
    public function __construct(string $title, array $labels)
    {
        $this->title = $title;
        $this->labels = $labels;
        $this->yMin = 0.0;
        $this->yMax = 100.0;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    
    public function getLabels(): array
    {
        return $this->labels;
    }

    
    public function addSeries(string $name, array $points): void
    {
        $this->series[$name] = $points;
    }

    
    public function getSeries(): array
    {
        return $this->series;
    }

    public function setYRange(float $min, float $max): void
    {
        $this->yMin = $min;
        $this->yMax = $max;
    }

    
    public function getYRange(): array
    {
        return ['min' => $this->yMin, 'max' => $this->yMax];
    }

    
    public function autoRange(): void
    {
        $all = [];
        foreach ($this->series as $points) {
            foreach ($points as $p) {
                $all[] = $p;
            }
        }
        if (empty($all)) {
            return;
        }
        $lo = min($all);
        $hi = max($all);
        $pad = ($hi - $lo) * 0.1;
        $this->yMin = $lo - $pad;
        $this->yMax = $hi + $pad;
    }

    public function seriesCount(): int
    {
        return count($this->series);
    }

    public function labelCount(): int
    {
        return count($this->labels);
    }

    
    public function pointAt(string $seriesName, int $index): ?float
    {
        if (!isset($this->series[$seriesName])) {
            return null;
        }
        return $this->series[$seriesName][$index] ?? null;
    }
}
