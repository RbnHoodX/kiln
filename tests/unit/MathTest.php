<?php
declare(strict_types=1);

require_once __DIR__ . '/../../utils/MathHelper.php';

function assert_eq($actual, $expected, string $msg): bool {
    if ($actual !== $expected) {
        echo "FAIL: $msg (got " . var_export($actual, true) . ", expected " . var_export($expected, true) . ")\n";
        return false;
    }
    return true;
}

function assert_near(float $actual, float $expected, float $epsilon, string $msg): bool {
    if (abs($actual - $expected) > $epsilon) {
        echo "FAIL: $msg (got $actual, expected $expected +/- $epsilon)\n";
        return false;
    }
    return true;
}

$passed = 0;
$total = 0;

$total++;
if (assert_near(MathHelper::mean([2.0, 4.0, 6.0]), 4.0, 0.001, 'mean [2,4,6]')) $passed++;

$total++;
if (assert_eq(MathHelper::mean([]), 0.0, 'mean empty')) $passed++;

$total++;
if (assert_near(MathHelper::median([3.0, 1.0, 2.0]), 2.0, 0.001, 'median [3,1,2]')) $passed++;

$total++;
if (assert_near(MathHelper::median([1.0, 2.0, 3.0, 4.0]), 2.5, 0.001, 'median [1,2,3,4]')) $passed++;

$total++;
$sd = MathHelper::stdDev([2.0, 4.0, 4.0, 4.0, 5.0, 5.0, 7.0, 9.0]);
if (assert_near($sd, 2.0, 0.01, 'stddev')) $passed++;

$total++;
if (assert_eq(MathHelper::clamp(5.0, 0.0, 10.0), 5.0, 'clamp within')) $passed++;

$total++;
if (assert_eq(MathHelper::clamp(-1.0, 0.0, 10.0), 0.0, 'clamp below')) $passed++;

$total++;
if (assert_near(MathHelper::lerp(0.0, 10.0, 0.5), 5.0, 0.001, 'lerp 0.5')) $passed++;

$total++;
$p50 = MathHelper::percentile([10.0, 20.0, 30.0, 40.0, 50.0], 50.0);
if (assert_near($p50, 30.0, 0.001, 'percentile 50')) $passed++;

echo "\nMath tests: $passed/$total passed\n";
if ($passed === $total) {
    echo "All Math tests passed\n";
}
