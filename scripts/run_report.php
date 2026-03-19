<?php
declare(strict_types=1);

require_once __DIR__ . '/../reports/FiringReport.php';
require_once __DIR__ . '/../reports/ProductionSummary.php';
require_once __DIR__ . '/../reports/CsvExporter.php';
require_once __DIR__ . '/../utils/Formatter.php';

echo "=== Kiln Report Generator ===\n\n";

$report = new FiringReport();
$report->addFiring('Bisque #42',    999,  480.0, 'success');
$report->addFiring('Glaze #18',    1222,  720.0, 'success');
$report->addFiring('Raku #7',       900,  120.0, 'success');
$report->addFiring('Crystal #3',   1280, 1440.0, 'partial');
$report->addFiring('Soda #11',     1300,  960.0, 'success');

echo "--- Firing Report ---\n";
echo $report->render();
echo "\n";

$summary = new ProductionSummary();
$summary->addDay('2026-03-10', 24, 2);
$summary->addDay('2026-03-11', 30, 1);
$summary->addDay('2026-03-12', 18, 3);
$summary->addDay('2026-03-13', 27, 0);
$summary->addDay('2026-03-14', 22, 1);

echo "--- Production Summary ---\n";
echo $summary->summary() . "\n\n";

$csv = new CsvExporter(['Date', 'Items', 'Defects']);
$csv->addRow(['2026-03-10', '24', '2']);
$csv->addRow(['2026-03-11', '30', '1']);
$csv->addRow(['2026-03-12', '18', '3']);
$csv->addRow(['2026-03-13', '27', '0']);
$csv->addRow(['2026-03-14', '22', '1']);

echo "--- CSV Output ---\n";
echo $csv->export();
echo "\n";

echo "Max peak: " . Formatter::temperature($report->maxPeak()) . "\n";
echo "Total firing time: " . Formatter::duration($report->totalDuration()) . "\n";
echo "Report complete.\n";
