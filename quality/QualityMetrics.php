<?php
declare(strict_types=1);

class QualityMetrics
{
    
    private array $records = [];

    
    public function addRecord(string $grade, int $defectCount): void
    {
        $this->records[] = ['grade' => $grade, 'defects' => $defectCount];
    }

    public function totalInspected(): int
    {
        return count($this->records);
    }

    
    public function passCount(): int
    {
        $count = 0;
        foreach ($this->records as $r) {
            if ($r['grade'] !== 'reject') {
                $count++;
            }
        }
        return $count;
    }

    
    public function passRate(): float
    {
        if ($this->totalInspected() === 0) {
            return 0.0;
        }
        return round(($this->passCount() / $this->totalInspected()) * 100.0, 2);
    }

    
    public function defectFrequency(): float
    {
        if ($this->totalInspected() === 0) {
            return 0.0;
        }
        $total = 0;
        foreach ($this->records as $r) {
            $total += $r['defects'];
        }
        return round($total / $this->totalInspected(), 2);
    }

    
    public function meanGrade(): float
    {
        if ($this->totalInspected() === 0) {
            return 0.0;
        }
        $scoreMap = ['A' => 4, 'B' => 3, 'C' => 2, 'reject' => 0];
        $sum = 0;
        foreach ($this->records as $r) {
            $sum += $scoreMap[$r['grade']] ?? 0;
        }
        return round($sum / $this->totalInspected(), 2);
    }

    
    public function gradeDistribution(): array
    {
        $dist = ['A' => 0, 'B' => 0, 'C' => 0, 'reject' => 0];
        foreach ($this->records as $r) {
            $g = $r['grade'];
            $dist[$g] = ($dist[$g] ?? 0) + 1;
        }
        return $dist;
    }

    public function summary(): string
    {
        return sprintf(
            'Inspected: %d | Pass rate: %.1f%% | Defect freq: %.2f | Mean grade: %.2f',
            $this->totalInspected(),
            $this->passRate(),
            $this->defectFrequency(),
            $this->meanGrade()
        );
    }
}
