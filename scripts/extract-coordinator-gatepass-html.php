<?php

declare(strict_types=1);

$f = file_get_contents(__DIR__.'/../resources/views/employee/dashboard.blade.php');

$start = strpos($f, '<!-- DASHBOARD SECTION -->');
$end = strpos($f, '        </section>');
if ($start === false || $end === false) {
    fwrite(STDERR, "markers not found\n");
    exit(1);
}

$chunk = substr($f, $start, $end - $start);
$chunk = str_replace('id="dashboardSection"', 'id="gatepassEmployeeDashboardSection"', $chunk);
$chunk = str_replace('id="historySection"', 'id="gatepassEmployeeHistorySection"', $chunk);
$chunk = str_replace('{{ $employeeFullName ?? auth()->user()?->name }}', '{{ $gatepassEmployeeFullName ?? auth()->user()?->name }}', $chunk);
$chunk = str_replace('{{ $employee?->center }}', '{{ $gatepassEmployee?->center }}', $chunk);
$chunk = str_replace('($equipment ?? collect())', '($gatepassEquipment ?? collect())', $chunk);
$chunk = str_replace('@foreach (($equipment ?? collect())', '@foreach (($gatepassEquipment ?? collect())', $chunk);
$chunk = str_replace('old(\'employee_name\', $employee?->employee_name', 'old(\'employee_name\', $gatepassEmployee?->employee_name', $chunk);
$chunk = str_replace('old(\'center\', $employee?->center', 'old(\'center\', $gatepassEmployee?->center', $chunk);

$toastStart = strpos($f, '<!-- Toast Notification -->');
$toastEnd = strpos($f, '<!-- Floating Help Button -->');
$toast = substr($f, $toastStart, $toastEnd - $toastStart);

$modalStart = strpos($f, '<!-- New Request Modal -->');
$modalEnd = strpos($f, '<script>');
$modals = substr($f, $modalStart, $modalEnd - $modalStart);

$out = "{{-- Embedded employee gatepass UI for coordinator (same API routes as employee dashboard) --}}\n";
$out .= '<div id="gatepassEmployeePanel" class="hidden">'."\n";
$out .= $chunk."\n</div>\n\n".$toast."\n\n".$modals;

$path = __DIR__.'/../resources/views/partials/coordinator-employee-gatepass.blade.php';
file_put_contents($path, $out);
echo "Wrote {$path}\n";
