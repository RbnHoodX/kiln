<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Chamber.php';
require_once __DIR__ . '/../src/Firing.php';
require_once __DIR__ . '/../src/FiringLog.php';
require_once __DIR__ . '/../src/Kiln.php';

echo "=== Kiln Data Seeder ===\n\n";

$kiln = new Kiln();

$chamberData = [
    ['name' => 'Main Chamber',  'kind' => 'gas',      'capacity' => 120],
    ['name' => 'Test Chamber',  'kind' => 'electric',  'capacity' => 30],
    ['name' => 'Raku Chamber',  'kind' => 'gas',       'capacity' => 15],
    ['name' => 'Soda Chamber',  'kind' => 'wood',      'capacity' => 80],
    ['name' => 'Salt Chamber',  'kind' => 'gas',       'capacity' => 60],
];

echo "Creating chambers...\n";
foreach ($chamberData as $cd) {
    echo sprintf("  - %s (%s, capacity %d)\n", $cd['name'], $cd['kind'], $cd['capacity']);
}

$scheduleNames = [
    'Bisque Cone 06',
    'Glaze Cone 6 Oxidation',
    'Glaze Cone 10 Reduction',
    'Raku Fast Fire',
    'Slow Cool Crystal',
];

echo "\nSample firing schedules:\n";
foreach ($scheduleNames as $i => $sn) {
    $temp = 900 + $i * 100;
    $duration = 360 + $i * 120;
    echo sprintf("  - %s: peak %d C, %d min\n", $sn, $temp, $duration);
}

$glazes = ['Celadon', 'Tenmoku', 'Shino', 'Ash Glaze', 'Clear Liner'];

echo "\nSample glazes:\n";
foreach ($glazes as $g) {
    echo "  - $g\n";
}

echo "\nSeed data generation complete.\n";
echo "Total chambers: " . count($chamberData) . "\n";
echo "Total schedules: " . count($scheduleNames) . "\n";
echo "Total glazes: " . count($glazes) . "\n";
