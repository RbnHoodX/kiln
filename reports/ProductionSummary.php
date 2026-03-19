<?php
declare(strict_types=1);

class ProductionSummary
{
    
    private array $dailyRecords = [];

    
    public function addDay(string $date, int $items, int $defects): void
    {
        $this->dailyRecords[] = [
            'date'    => $date,
            'items'   => $items,
            'defects' => $defects,
        ];
    }

    public function dayCount(): int
    {
        return count($this->dailyRecords);
    }

    
    public function totalItems(): int
    {
        $sum = 0;
        foreach ($this->dailyRecords as $r) {
            $sum += $r['items'];
        }
        return $sum;
    }

    
    public function totalDefects(): int
    {
        $sum = 0;
        foreach ($this->dailyRecords as $r) {
            $sum += $r['defects'];
        }
        return $sum;
    }

    
    public function dailyAverage(): float
    {
        if ($this->dayCount() === 0) {
            return 0.0;
        }
        return round($this->totalItems() / $this->dayCount(), 2);
    }

    
    public function weeklyTotals(): array
    {
        $weeks = [];
        foreach ($this->dailyRecords as $r) {
            $ts = strtotime($r['date']);
            if ($ts === false) {
                continue;
            }
            $week = date('o-\WW', $ts);
            $weeks[$week] = ($weeks[$week] ?? 0) + $r['items'];
        }
        return $weeks;
    }

    
    public function monthlyTotals(): array
    {
        $months = [];
        foreach ($this->dailyRecords as $r) {
            $month = substr($r['date'], 0, 7);
            $months[$month] = ($months[$month] ?? 0) + $r['items'];
        }
        return $months;
    }

    
    public function defectRate(): float
    {
        $total = $this->totalItems();
        if ($total === 0) {
            return 0.0;
        }
        return round(($this->totalDefects() / $total) * 100.0, 2);
    }

    public function summary(): string
    {
        return sprintf(
            '%d days | %d items (%.1f/day) | %d defects (%.1f%%)',
            $this->dayCount(),
            $this->totalItems(),
            $this->dailyAverage(),
            $this->totalDefects(),
            $this->defectRate()
        );
    }
}
