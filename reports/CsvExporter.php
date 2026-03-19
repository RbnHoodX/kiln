<?php
declare(strict_types=1);

class CsvExporter
{
    private string $delimiter;
    private string $enclosure;
    
    private array $headers;
    
    private array $rows = [];

    
    public function __construct(array $headers, string $delimiter = ',', string $enclosure = '"')
    {
        $this->headers = $headers;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    
    public function addRow(array $values): void
    {
        $this->rows[] = array_map('strval', $values);
    }

    public function rowCount(): int
    {
        return count($this->rows);
    }

    
    private function quoteField(string $field): string
    {
        $needsQuoting = str_contains($field, $this->delimiter)
            || str_contains($field, $this->enclosure)
            || str_contains($field, "\n");
        if (!$needsQuoting) {
            return $field;
        }
        $escaped = str_replace($this->enclosure, $this->enclosure . $this->enclosure, $field);
        return $this->enclosure . $escaped . $this->enclosure;
    }

    
    private function buildLine(array $fields): string
    {
        return implode($this->delimiter, array_map([$this, 'quoteField'], $fields));
    }

    
    public function export(): string
    {
        $lines = [];
        $lines[] = $this->buildLine($this->headers);
        foreach ($this->rows as $row) {
            $lines[] = $this->buildLine($row);
        }
        return implode("\n", $lines) . "\n";
    }

    
    public function writeTo(string $filePath): int
    {
        $content = $this->export();
        $bytes = file_put_contents($filePath, $content);
        return $bytes !== false ? $bytes : 0;
    }

    
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
