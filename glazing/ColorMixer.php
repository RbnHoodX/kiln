<?php
declare(strict_types=1);

class ColorMixer
{
    private int $red;
    private int $green;
    private int $blue;
    private float $opacity;

    public function __construct(int $red, int $green, int $blue, float $opacity = 1.0)
    {
        $this->red = max(0, min(255, $red));
        $this->green = max(0, min(255, $green));
        $this->blue = max(0, min(255, $blue));
        $this->opacity = max(0.0, min(1.0, $opacity));
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }

    public function getOpacity(): float
    {
        return $this->opacity;
    }

    
    public function blend(ColorMixer $other, float $ratio): self
    {
        $ratio = max(0.0, min(1.0, $ratio));
        $inv = 1.0 - $ratio;
        return new self(
            (int) round($this->red * $inv + $other->red * $ratio),
            (int) round($this->green * $inv + $other->green * $ratio),
            (int) round($this->blue * $inv + $other->blue * $ratio),
            round($this->opacity * $inv + $other->opacity * $ratio, 2)
        );
    }

    
    public function complementary(): self
    {
        return new self(255 - $this->red, 255 - $this->green, 255 - $this->blue, $this->opacity);
    }

    
    public function toHex(): string
    {
        return sprintf('#%02x%02x%02x', $this->red, $this->green, $this->blue);
    }

    
    public function brightness(): float
    {
        return round(0.299 * $this->red + 0.587 * $this->green + 0.114 * $this->blue, 2);
    }

    
    public function isDark(): bool
    {
        return $this->brightness() < 128.0;
    }
}
