<?php

declare(strict_types=1);

require_once __DIR__ . '/Chamber.php';
require_once __DIR__ . '/Firing.php';
require_once __DIR__ . '/FiringLog.php';

class Kiln
{
    
    private array $chambers = [];
    private FiringLog $log;

    public function __construct()
    {
        $this->log = new FiringLog();
    }

    public function createChamber(string $name, string $kind = 'standard'): Chamber
    {
        if (isset($this->chambers[$name])) {
            throw new RuntimeException("chamber '$name' already exists");
        }
        $chamber = new Chamber($name, $kind);
        $this->chambers[$name] = $chamber;
        return $chamber;
    }

    public function getChamber(string $name): Chamber
    {
        if (!isset($this->chambers[$name])) {
            throw new RuntimeException("chamber '$name' not found");
        }
        return $this->chambers[$name];
    }

    
    public function chambers(): array
    {
        return array_values($this->chambers);
    }

    public function transfer(string $sourceName, string $destName, int $amount, string $note = ''): Firing
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('amount must be positive');
        }
        $source = $this->getChamber($sourceName);
        $dest = $this->getChamber($destName);
        $firing = new Firing($source, $dest, $amount, $note);
        $this->log->record($firing);
        return $firing;
    }

    
    public function logEntries(): array
    {
        return $this->log->entries();
    }

    public function totalTransferred(): int
    {
        $total = 0;
        foreach ($this->log->entries() as $f) {
            $total += $f->amount();
        }
        return $total;
    }
}
