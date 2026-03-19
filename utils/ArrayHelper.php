<?php
declare(strict_types=1);

class ArrayHelper
{
    
    public static function groupBy(array $items, string $key): array
    {
        $groups = [];
        foreach ($items as $item) {
            $k = (string) ($item[$key] ?? '');
            $groups[$k][] = $item;
        }
        return $groups;
    }

    
    public static function partition(array $items, callable $predicate): array
    {
        $pass = [];
        $fail = [];
        foreach ($items as $item) {
            if ($predicate($item)) {
                $pass[] = $item;
            } else {
                $fail[] = $item;
            }
        }
        return [$pass, $fail];
    }

    
    public static function flatten(array $arrays): array
    {
        $result = [];
        foreach ($arrays as $arr) {
            if (is_array($arr)) {
                foreach ($arr as $item) {
                    $result[] = $item;
                }
            } else {
                $result[] = $arr;
            }
        }
        return $result;
    }

    
    public static function unique(array $items): array
    {
        return array_values(array_unique($items));
    }

    
    public static function chunk(array $items, int $size): array
    {
        if ($size <= 0) {
            return [$items];
        }
        return array_chunk($items, $size);
    }

    
    public static function pick(array $item, array $keys): array
    {
        $result = [];
        foreach ($keys as $k) {
            if (array_key_exists($k, $item)) {
                $result[$k] = $item[$k];
            }
        }
        return $result;
    }

    
    public static function sumField(array $items, string $field): float
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += (float) ($item[$field] ?? 0);
        }
        return $total;
    }
}
