<?php

declare(strict_types=1);

$f = file_get_contents(__DIR__.'/../resources/views/employee/dashboard.blade.php');
$start = strpos($f, '<script>');
$end = strrpos($f, '</script>');
if ($start === false || $end === false) {
    fwrite(STDERR, "Could not find script block\n");
    exit(1);
}

$s = trim(substr($f, $start + strlen('<script>'), $end - $start - strlen('<script>')));

$s = str_replace(
    "const navDashboard = document.getElementById('navDashboard');",
    "const coordinatorGpNavRequest = document.getElementById('navGatepassRequest');",
    $s
);
$s = str_replace(
    "const navHistory = document.getElementById('navHistory');",
    "const coordinatorGpNavHistory = document.getElementById('navGatepassHistory');",
    $s
);
$s = str_replace(
    "const dashboardSection = document.getElementById('dashboardSection');",
    "const coordinatorGpDashboardSection = document.getElementById('gatepassEmployeeDashboardSection');",
    $s
);
$s = str_replace(
    "const historySection = document.getElementById('historySection');",
    "const coordinatorGpHistorySection = document.getElementById('gatepassEmployeeHistorySection');",
    $s
);

$s = str_replace('navDashboard', 'coordinatorGpNavRequest', $s);
$s = str_replace('navHistory', 'coordinatorGpNavHistory', $s);
$s = str_replace('dashboardSection', 'coordinatorGpDashboardSection', $s);
$s = str_replace('historySection', 'coordinatorGpHistorySection', $s);

$s = str_replace('function showDashboardSection()', 'function coordinatorGpShowMyRequestsPanel()', $s);
$s = str_replace('function showHistorySection()', 'function coordinatorGpShowHistoryPanel()', $s);

$s = str_replace(
    'function activateDashboardButton() {
            coordinatorGpNavRequest.classList.add',
    'function activateDashboardButton() {
            if (!coordinatorGpNavRequest || !coordinatorGpNavHistory) {
                return;
            }
            coordinatorGpNavRequest.classList.add',
    $s
);
$s = str_replace(
    'function activateHistoryButton() {
            coordinatorGpNavHistory.classList.add',
    'function activateHistoryButton() {
            if (!coordinatorGpNavRequest || !coordinatorGpNavHistory) {
                return;
            }
            coordinatorGpNavHistory.classList.add',
    $s
);

$s = str_replace(
    'function coordinatorGpShowMyRequestsPanel() {

            coordinatorGpDashboardSection.classList.remove(\'hidden\');',
    'function coordinatorGpShowMyRequestsPanel() {
            if (!coordinatorGpDashboardSection || !coordinatorGpHistorySection || !pageTitle || !newRequestBtn) {
                return;
            }

            coordinatorGpDashboardSection.classList.remove(\'hidden\');',
    $s
);
$s = str_replace(
    'function coordinatorGpShowHistoryPanel() {

            coordinatorGpDashboardSection.classList.add(\'hidden\');',
    'function coordinatorGpShowHistoryPanel() {
            if (!coordinatorGpDashboardSection || !coordinatorGpHistorySection || !pageTitle || !newRequestBtn) {
                return;
            }

            coordinatorGpDashboardSection.classList.add(\'hidden\');',
    $s
);

$s = str_replace(
    'function openRequestModal() {
            const modal = document.getElementById(\'requestModal\');

            modal.classList.remove',
    'function openRequestModal() {
            const modal = document.getElementById(\'requestModal\');
            if (!modal) {
                return;
            }

            modal.classList.remove',
    $s
);
$s = str_replace(
    'function closeRequestModal() {

            const modal = document.getElementById(\'requestModal\');

            modal.classList.add',
    'function closeRequestModal() {

            const modal = document.getElementById(\'requestModal\');
            if (!modal) {
                return;
            }

            modal.classList.add',
    $s
);

$s = str_replace('showDashboardSection()', 'coordinatorGpShowMyRequestsPanel()', $s);
$s = str_replace('showHistorySection()', 'coordinatorGpShowHistoryPanel()', $s);

$s = str_replace(
    "addEventListener('click', showDashboardSection)",
    "addEventListener('click', coordinatorGpShowMyRequestsPanel)",
    $s
);
$s = str_replace(
    "addEventListener('click', showHistorySection)",
    "addEventListener('click', coordinatorGpShowHistoryPanel)",
    $s
);

// Coordinator main script wires sidebar; avoid duplicate listeners on gatepass nav
$s = preg_replace(
    '/\s*coordinatorGpNavRequest\.addEventListener\([^)]+\)\s*;\s*coordinatorGpNavHistory\.addEventListener\([^)]+\)\s*;\s*/',
    "\n",
    $s
);

// Remove initial DOMContentLoaded that calls coordinatorGpShowMyRequestsPanel + employeeWire (coordinator calls lazy init)
$s = preg_replace(
    '/document\.addEventListener\(\'DOMContentLoaded\',\s*function\s*\(\)\s*\{\s*coordinatorGpShowMyRequestsPanel\(\);\s*employeeWireDashboardFilters\(\);\s*employeeLoadDashboard\(\'All\'\);/s',
    "document.addEventListener('DOMContentLoaded', function () {\n        /* coordinator: gatepass init deferred */\n        employeeWireDashboardFilters();\n        /* employeeLoadDashboard called when opening Gatepass tab */",
    $s,
    1
);

// Coordinator/admin embed: poll a bit slower than the standalone employee page.
$s = str_replace(
    'const EMPLOYEE_DASHBOARD_POLL_MS = 2000;',
    'const EMPLOYEE_DASHBOARD_POLL_MS = 3000;',
    $s
);

$outDir = __DIR__.'/../storage/framework';
if (! is_dir($outDir)) {
    mkdir($outDir, 0755, true);
}

$exports = <<<'JS'

        window.openRequestModal = openRequestModal;
        window.closeRequestModal = closeRequestModal;
        window.openProfileModal = openProfileModal;
        window.closeProfileModal = closeProfileModal;
        window.coordinatorGpShowMyRequestsPanel = coordinatorGpShowMyRequestsPanel;
        window.coordinatorGpShowHistoryPanel = coordinatorGpShowHistoryPanel;
        window.employeeRemoveSelectedEquipment = employeeRemoveSelectedEquipment;
        window.coordinatorGatepassLazyInit = function () {
            if (window.__coordinatorGatepassLazyInited) {
                return;
            }
            window.__coordinatorGatepassLazyInited = true;
            employeeLoadDashboard('All');
        };

JS;

$out = "(function () {\n".$s."\n".$exports."\n})();\n";

$partialDir = __DIR__.'/../resources/views/partials';
if (! is_dir($partialDir)) {
    mkdir($partialDir, 0755, true);
}
$partialPath = $partialDir.'/coordinator-gatepass-employee-snippet.js';
file_put_contents($partialPath, $out);
file_put_contents($outDir.'/coordinator-gatepass-employee-snippet.js', $out);

echo 'Wrote '.strlen($out)." bytes to partial and storage\n";
