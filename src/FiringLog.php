<?php

declare(strict_types=1);

class FiringLog
{
    
    private array $entries = [];
    private int $counter = 0;

    public function record(Firing $firing): Firing
    {
        $this->counter++;
        $firing->setId($this->counter);
        $this->entries[] = $firing;
        $firing->source()->_addFiring($firing);
        $firing->dest()->_addFiring($firing);
        return $firing;
    }

    
    public function entries(): array
    {
        return $this->entries;
    }
}
