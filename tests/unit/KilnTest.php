<?php
declare(strict_types=1);

require_once __DIR__ . '/../../src/Kiln.php';

function assert_eq($actual, $expected, string $msg): bool {
    if ($actual !== $expected) {
        echo "FAIL: $msg (got " . var_export($actual, true) . ", expected " . var_export($expected, true) . ")\n";
        return false;
    }
    return true;
}

function assert_true($actual, string $msg): bool {
    if ($actual !== true) {
        echo "FAIL: $msg (expected true, got " . var_export($actual, true) . ")\n";
        return false;
    }
    return true;
}

$passed = 0;
$total = 0;

$total++;
$k = new Kiln();
if (assert_eq($k->chamberCount(), 0, 'initial chamber count')) $passed++;

$total++;
$k->addChamber('Main', 'gas');
if (assert_eq($k->chamberCount(), 1, 'after add chamber')) $passed++;

$total++;
$k->addChamber('Test', 'electric');
if (assert_eq($k->chamberCount(), 2, 'after second chamber')) $passed++;

$total++;
$ch = $k->findChamber('Main');
if (assert_true($ch !== null, 'find main chamber')) $passed++;

$total++;
if ($ch !== null) {
    if (assert_eq($ch->getName(), 'Main', 'found chamber name')) $passed++;
} else {
    echo "FAIL: chamber was null\n";
}

$total++;
$result = $k->transfer('Main', 'Test', 5);
if (assert_true($result, 'transfer success')) $passed++;

$total++;
$k2 = new Kiln();
$k2->addChamber('A', 'gas');
$k2->addChamber('B', 'electric');
$k2->addChamber('C', 'wood');
if (assert_eq($k2->chamberCount(), 3, 'three chambers')) $passed++;

echo "\nKiln tests: $passed/$total passed\n";
if ($passed === $total) {
    echo "All Kiln tests passed\n";
}
