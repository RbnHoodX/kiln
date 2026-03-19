<?php
declare(strict_types=1);

require_once __DIR__ . '/../../clay/ClayBody.php';
require_once __DIR__ . '/../../clay/MoistureContent.php';

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
$clay = new ClayBody('B-Mix', 12.0, 1.5, 1220, 1280);
if (assert_eq($clay->getName(), 'B-Mix', 'clay name')) $passed++;

$total++;
if (assert_eq($clay->isStoneware(), true, 'B-Mix is stoneware')) $passed++;

$total++;
$porcelain = new ClayBody('Grolleg', 14.0, 0.5, 1280, 1350);
if (assert_eq($porcelain->isPorcelain(), true, 'Grolleg is porcelain')) $passed++;

$total++;
$terra = new ClayBody('Terracotta', 7.0, 8.0, 950, 1100);
if (assert_eq($terra->isEarthenware(), true, 'terracotta is earthenware')) $passed++;

$total++;
if (assert_eq($clay->canFireAt(1250), true, 'B-Mix fires at 1250')) $passed++;

$total++;
if (assert_eq($clay->canFireAt(900), false, 'B-Mix cannot fire at 900')) $passed++;

$total++;
$m = new MoistureContent(500.0, 400.0);
if (assert_eq($m->percentage(), 20.0, 'moisture 20%')) $passed++;

$total++;
$dry = new MoistureContent(105.0, 102.0);
if (assert_eq($dry->isDryEnough(), true, 'dry enough for firing')) $passed++;

$total++;
if (assert_eq($m->stage(), 'wet', 'wet stage')) $passed++;

echo "\nClay tests: $passed/$total passed\n";
if ($passed === $total) {
    echo "All Clay tests passed\n";
}
