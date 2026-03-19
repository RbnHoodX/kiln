<?php
declare(strict_types=1);

require_once __DIR__ . '/../../src/Firing.php';

function assert_eq($actual, $expected, string $msg): bool {
    if ($actual !== $expected) {
        echo "FAIL: $msg (got " . var_export($actual, true) . ", expected " . var_export($expected, true) . ")\n";
        return false;
    }
    return true;
}

$passed = 0;
$total = 0;

$total++;
$f = new Firing('bisque', 999);
if (assert_eq($f->getType(), 'bisque', 'firing type')) $passed++;

$total++;
if (assert_eq($f->getTemperature(), 999, 'firing temperature')) $passed++;

$total++;
$g = new Firing('glaze', 1222);
if (assert_eq($g->getType(), 'glaze', 'glaze type')) $passed++;

$total++;
if (assert_eq($g->getTemperature(), 1222, 'glaze temperature')) $passed++;

$total++;
$h = new Firing('reduction', 1300);
if (assert_eq($h->getTemperature(), 1300, 'high temp')) $passed++;

$total++;
$l = new Firing('lustre', 750);
if (assert_eq($l->getTemperature(), 750, 'low temp')) $passed++;

$total++;
if (assert_eq($l->getType(), 'lustre', 'lustre type')) $passed++;

echo "\nFiring tests: $passed/$total passed\n";
if ($passed === $total) {
    echo "All Firing tests passed\n";
}
