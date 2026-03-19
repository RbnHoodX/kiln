<?php
declare(strict_types=1);

class FiringReport
{
    
    private array $rows = [];

    
    public function addFiring(string $name, int $peakTemp, float $durationMinutes, string $result): void
    {
        $this->rows[] = [
            'name'     => $name,
            'peak'     => $peakTemp,
            'duration' => $durationMinutes,
            'result'   => $result,
        ];
    }

    public function count(): int
    {
        return count($this->rows);
    }

    
    public function render(): string
    {
        $header = sprintf("%-20s %8s %10s %10s\n", 'Name', 'Peak C', 'Duration', 'Result');
        $sep = str_repeat('-', 52) . "\n";
        $lines = $header . $sep;
        foreach ($this->rows as $r) {
            $dur = sprintf('%dh %dm', (int) ($r['duration'] / 60), (int) $r['duration'] % 60);
            $lines .= sprintf("%-20s %8d %10s %10s\n", $r['name'], $r['peak'], $dur, $r['result']);
        }
        $lines .= $sep;
        $lines .= $this->summaryLine();
        return $lines;
    }

    
    public function summaryLine(): string
    {
        if (empty($this->rows)) {
            return 'No firings recorded.';
        }
        $peaks = array_column($this->rows, 'peak');
        $avgPeak = array_sum($peaks) / count($peaks);
        $durations = array_column($this->rows, 'duration');
        $avgDur = array_sum($durations) / count($durations);
        return sprintf('Total: %d firings | Avg peak: %d C | Avg duration: %.0f min', count($this->rows), (int) $avgPeak, $avgDur);
    }

    
    public function maxPeak(): int
    {
        if (empty($this->rows)) {
            return 0;
        }
        return max(array_column($this->rows, 'peak'));
    }

    
    public function totalDuration(): float
    {
        return array_sum(array_column($this->rows, 'duration'));
    }
}
