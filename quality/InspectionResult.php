<?php
declare(strict_types=1);

class InspectionResult
{
    private string $item;
    
    private array $defects;
    private string $grade;
    private string $timestamp;

    
    public function __construct(string $item, array $defects, string $grade, string $timestamp)
    {
        $this->item = $item;
        $this->defects = $defects;
        $this->grade = $grade;
        $this->timestamp = $timestamp;
    }

    public function getItem(): string
    {
        return $this->item;
    }

    
    public function getDefects(): array
    {
        return $this->defects;
    }

    public function getGrade(): string
    {
        return $this->grade;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function defectCount(): int
    {
        return count($this->defects);
    }

    public function isPassing(): bool
    {
        return $this->grade !== 'reject';
    }

    public function hasDefect(string $defectCode): bool
    {
        return in_array($defectCode, $this->defects, true);
    }

    
    public static function autoGrade(int $defectCount): string
    {
        return match (true) {
            $defectCount === 0 => 'A',
            $defectCount === 1 => 'B',
            $defectCount === 2 => 'C',
            default            => 'reject',
        };
    }

    
    public function score(): int
    {
        return match ($this->grade) {
            'A'      => 4,
            'B'      => 3,
            'C'      => 2,
            default  => 0,
        };
    }

    public function summary(): string
    {
        $defStr = empty($this->defects) ? 'none' : implode(', ', $this->defects);
        return sprintf('[%s] %s — grade %s, defects: %s', $this->timestamp, $this->item, $this->grade, $defStr);
    }
}
