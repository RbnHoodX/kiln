<?php
declare(strict_types=1);

class BatchReport
{
    private string $batchId;
    private int $itemCount;
    private int $passCount;
    private int $failCount;

    public function __construct(string $batchId, int $itemCount, int $passCount, int $failCount)
    {
        $this->batchId = $batchId;
        $this->itemCount = max(0, $itemCount);
        $this->passCount = max(0, $passCount);
        $this->failCount = max(0, $failCount);
    }

    public function getBatchId(): string
    {
        return $this->batchId;
    }

    public function getItemCount(): int
    {
        return $this->itemCount;
    }

    public function getPassCount(): int
    {
        return $this->passCount;
    }

    public function getFailCount(): int
    {
        return $this->failCount;
    }

    
    public function yieldPct(): float
    {
        if ($this->itemCount === 0) {
            return 0.0;
        }
        return round(($this->passCount / $this->itemCount) * 100.0, 2);
    }

    
    public function isAcceptable(): bool
    {
        return $this->yieldPct() >= 90.0;
    }

    
    public function unaccounted(): int
    {
        return max(0, $this->itemCount - $this->passCount - $this->failCount);
    }

    
    public function merge(BatchReport $other): self
    {
        return new self(
            $this->batchId . '+' . $other->batchId,
            $this->itemCount + $other->itemCount,
            $this->passCount + $other->passCount,
            $this->failCount + $other->failCount
        );
    }

    public function summary(): string
    {
        return sprintf(
            'Batch %s: %d items, %d pass, %d fail (yield %.1f%%)',
            $this->batchId,
            $this->itemCount,
            $this->passCount,
            $this->failCount,
            $this->yieldPct()
        );
    }
}
