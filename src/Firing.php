<?php

declare(strict_types=1);

class Firing
{
    private int $id = 0;
    private Chamber $source;
    private Chamber $dest;
    private int $amount;
    private string $note;

    public function __construct(Chamber $source, Chamber $dest, int $amount, string $note = '')
    {
        $this->source = $source;
        $this->dest = $dest;
        $this->amount = $amount;
        $this->note = $note;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function source(): Chamber
    {
        return $this->source;
    }

    public function dest(): Chamber
    {
        return $this->dest;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function note(): string
    {
        return $this->note;
    }
}
