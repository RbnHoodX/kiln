<?php
declare(strict_types=1);

require_once __DIR__ . '/../../glazing/GlazeRecipe.php';
require_once __DIR__ . '/../../glazing/ColorMixer.php';

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
$g = new GlazeRecipe('Celadon', 'feldspar', 1260, 11.5);
if (assert_eq($g->getName(), 'Celadon', 'recipe name')) $passed++;

$total++;
if (assert_eq($g->getBaseMineral(), 'feldspar', 'base mineral')) $passed++;

$total++;
if (assert_eq($g->isHighFire(), true, 'celadon is high fire')) $passed++;

$total++;
$low = new GlazeRecipe('Majolica', 'calcium', 1050, 8.0);
if (assert_eq($low->isHighFire(), false, 'majolica is low fire')) $passed++;

$total++;
$ratio = $g->mixRatio(30.0, 100.0);
if (assert_eq($ratio, 0.3, 'mix ratio 30/100')) $passed++;

$total++;
$c = new ColorMixer(120, 180, 90, 0.9);
if (assert_eq($c->getRed(), 120, 'red channel')) $passed++;

$total++;
$comp = $c->complementary();
if (assert_eq($comp->getRed(), 135, 'complementary red')) $passed++;

$total++;
$white = new ColorMixer(255, 255, 255);
if (assert_eq($white->toHex(), '#ffffff', 'white hex')) $passed++;

$total++;
$dark = new ColorMixer(20, 20, 20);
if (assert_eq($dark->isDark(), true, 'dark color')) $passed++;

echo "\nGlaze tests: $passed/$total passed\n";
if ($passed === $total) {
    echo "All Glaze tests passed\n";
}
