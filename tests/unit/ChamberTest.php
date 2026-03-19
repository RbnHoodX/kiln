<?php
declare(strict_types=1);

require_once __DIR__ . '/../../src/Chamber.php';

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
$ch = new Chamber('Main', 'gas');
if (assert_eq($ch->getName(), 'Main', 'chamber name')) $passed++;

$total++;
if (assert_eq($ch->getKind(), 'gas', 'chamber kind')) $passed++;

$total++;
if (assert_eq($ch->getLevel(), 0, 'initial level')) $passed++;

$total++;
$e = new Chamber('Test', 'electric');
if (assert_eq($e->getKind(), 'electric', 'electric kind')) $passed++;

$total++;
$w = new Chamber('Wood Unit', 'wood');
if (assert_eq($w->getName(), 'Wood Unit', 'wood chamber name')) $passed++;

$total++;
if (assert_eq($w->getLevel(), 0, 'wood initial level')) $passed++;

$total++;
$long = new Chamber('South Wing Reduction Chamber Alpha', 'gas');
if (assert_eq($long->getName(), 'South Wing Reduction Chamber Alpha', 'long name')) $passed++;

echo "\nChamber tests: $passed/$total passed\n";
if ($passed === $total) {
    echo "All Chamber tests passed\n";
}
