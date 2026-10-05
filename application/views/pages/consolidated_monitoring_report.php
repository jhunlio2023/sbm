<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= $thematic_report ? 'Division Thematic Monitoring Report' : 'Consolidated Monitoring Report'; ?> — <?= html_escape($division_report ? ($report['school']['division'] ?: 'Unspecified division') : $target->school_name); ?></title>
<style>
body{margin:0;background:#eef1f5;color:#111;font-family:Arial,Helvetica,sans-serif}.toolbar{padding:14px 24px;font:14px Arial,Helvetica,sans-serif;background:#fff;border-bottom:1px solid #dce2e9}.toolbar-inner{max-width:1222px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}.toolbar a,.toolbar button{box-sizing:border-box;display:inline-flex;align-items:center;justify-content:center;min-height:42px;padding:10px 16px;border-radius:8px;font:inherit;font-weight:600;text-decoration:none;transition:background .15s,color .15s}.toolbar-back{color:#344256;gap:8px}.toolbar-back:hover{background:#f0f3f7}.report-switcher{display:flex;gap:4px;padding:4px;border:1px solid #dce2e9;border-radius:12px;background:#f5f7fa}.report-switcher a{color:#526174}.report-switcher a:hover{background:#e7edf5;color:#183d6b}.report-switcher a[aria-current="page"]{background:#fff;color:#174d89;box-shadow:0 1px 4px #162d4926}.toolbar .print-button{border:1px solid #174d89;background:#174d89;color:white;cursor:pointer;gap:8px}.toolbar .print-button:hover{background:#113b6b}.toolbar a:focus-visible,.toolbar button:focus-visible{outline:3px solid #568ed0;outline-offset:3px}@media screen and (max-width:600px){.toolbar{padding:12px}.toolbar-inner{gap:10px}.report-switcher{order:3;width:100%}.report-switcher a{flex:1;padding:10px 8px}}.report{max-width:1150px;margin:24px auto;padding:36px;background:white}.letterhead{display:block;width:100%;max-height:180px;object-fit:contain;margin:0 auto 14px}h1{text-align:center;font-size:25px;margin:20px 0}.metadata{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:24px;margin-bottom:10px;line-height:1.5}.metadata>span{min-width:0;overflow-wrap:anywhere}.school{margin:12px 0;line-height:1.5;overflow-wrap:anywhere}table{border-collapse:collapse;width:100%;table-layout:fixed}th,td{border:1px solid #222;padding:10px;vertical-align:top;overflow-wrap:anywhere}th{text-align:center}th:first-child{width:22%}th:last-child{width:14%}td{white-space:pre-wrap;font-size:14px}td p{margin:0 0 10px}td p:last-child{margin-bottom:0}.prepared{margin-top:22px}.prepared-signatory{padding-top:22mm;white-space:pre-wrap;break-inside:avoid}.explanation{font:13px Arial,sans-serif;color:#555}.domain{font-weight:bold}
@page{size:A4 landscape;margin:12mm}@media print{body{background:white}.toolbar,.explanation{display:none}.report{margin:0;padding:0;max-width:none}.letterhead{max-height:35mm}thead{display:table-header-group}tr{break-inside:avoid}h1{font-size:20pt}td{font-size:10pt}.prepared{break-inside:avoid}.metadata{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8mm;margin-bottom:3mm;font-size:11pt;break-inside:avoid;break-after:avoid}.school{margin:3mm 0;font-size:11pt;break-inside:avoid;break-after:avoid}}
@media screen and (max-width:700px){.report{padding:14px}.metadata{display:block}table{min-width:700px}.report-table{overflow:auto}}
.division-metadata{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:18px 36px;margin:24px 0;padding:20px 0;border-bottom:1px solid #aeb6bf;font-family:Arial,Helvetica,sans-serif;break-inside:avoid;break-after:avoid}.division-metadata>div{min-width:0}.division-metadata dt{margin:0 0 6px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#485361}.division-metadata dd{margin:0;font-size:17px;font-weight:600;line-height:1.4;overflow-wrap:anywhere}
@media print{.division-metadata{gap:4mm 10mm;margin:5mm 0;padding:4mm 0;border-bottom:.5pt solid #777}.division-metadata dt{font-size:8pt;color:#333;margin-bottom:1.5mm}.division-metadata dd{font-size:12pt;color:#111}}
@media screen and (max-width:480px){.division-metadata{grid-template-columns:1fr;gap:16px}}
.division-report .report-table{font-family:Arial,Helvetica,sans-serif}
.thematic-table thead th{width:50%}.thematic-table .theme-heading th{width:auto;text-align:left;font-size:14px;letter-spacing:.2px}.thematic-table .theme-heading{break-after:avoid}.thematic-table td{line-height:1.5}
</style></head><body>
<nav class="toolbar" aria-label="Report navigation">
<div class="toolbar-inner">
<a class="toolbar-back" href="<?= base_url('Pages/monitored_schools'); ?>"><span aria-hidden="true">&larr;</span> Monitored Schools</a>
<?php if ($division_report): ?>
<div class="report-switcher" role="group" aria-label="Report type">
<a href="<?= base_url('Pages/consolidated_division_monitoring_report?record_id=' . (int) $target->id); ?>"<?= !$thematic_report ? ' aria-current="page"' : ''; ?>>Consolidated Report</a>
<a href="<?= base_url('Pages/thematic_division_monitoring_report?record_id=' . (int) $target->id); ?>"<?= $thematic_report ? ' aria-current="page"' : ''; ?>>Thematic Report</a>
</div>
<?php endif; ?>
<button class="print-button" type="button" onclick="window.print()"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 9V3h12v6M6 18H3V9h18v9h-3M6 14h12v7H6z"/><path d="M17 12h1"/></svg>Print / Save PDF</button>
</div>
</nav>
<main class="report<?= $division_report ? ' division-report' : ''; ?>">
<?php if ($letterhead): ?><img class="letterhead" src="<?= html_escape(base_url($letterhead)); ?>" alt="Regional letterhead"><?php endif; ?>
<h1><?= $thematic_report ? 'Division Thematic Monitoring Report' : ($division_report ? 'Division Consolidated Monitoring Report' : 'Consolidated Monitoring Report'); ?></h1>
<?php if ($division_report): ?>
<dl class="division-metadata" aria-label="Division report details">
<div><dt>Division</dt><dd><?= html_escape($report['school']['division'] ?: 'Unspecified division'); ?></dd></div>
<div><dt>Date</dt><dd><?= html_escape($report_date); ?></dd></div>
<div><dt>Monitored schools</dt><dd><?= (int) $report['school_count']; ?></dd></div>
<div><dt>School year</dt><dd><?= html_escape($target->school_year); ?></dd></div>
</dl>
<?php else: ?>
<div class="metadata"><span><strong>Division:</strong> <?= html_escape($report['school']['division'] ?? ''); ?></span><span><strong>District:</strong> <?= html_escape($report['school']['district'] ?? ''); ?></span><span><strong>Date:</strong> <?= html_escape($report_date); ?></span></div>
<p class="school"><strong>School:</strong> <?= html_escape($target->school_name); ?><br><strong>School Year:</strong> <?= html_escape($target->school_year); ?></p>
<?php endif; ?>
<?php if ($thematic_report): ?>
<div class="report-table"><table class="thematic-table"><thead><tr><th scope="col">Best Practices</th><th scope="col">Issues/Concerns</th></tr></thead><tbody>
<?php foreach ($report['domains'] as $domain): ?>
<tr class="theme-heading"><th colspan="2"><?= html_escape($domain['title']); ?></th></tr>
<tr><?php foreach (array('best_practices', 'issues_concerns') as $key): ?><td><?php foreach ($domain[$key] as $note): ?><p><?= html_escape($note); ?></p><?php endforeach; ?><?php if (!$domain[$key]): ?><p>None recorded.</p><?php endif; ?></td><?php endforeach; ?></tr>
<?php endforeach; ?>
<?php if (!$report['domains']): ?><tr><td colspan="2">No domains recorded for this division and school year.</td></tr><?php endif; ?>
</tbody></table></div>
<?php else: ?>
<div class="report-table"><table><thead><tr><th>Domains</th><th>Best Practices</th><th>Issues/Concerns</th><th>Actions Taken</th><th>Status</th></tr></thead><tbody>
<?php foreach ($report['domains'] as $domain): ?><tr><td class="domain"><?= html_escape($domain['title']); ?></td><?php foreach (array('best_practices', 'issues_concerns', 'action_taken', 'status_remarks') as $key): ?><td><?php foreach ($domain[$key] as $note): ?><p><?= html_escape($note); ?></p><?php endforeach; ?></td><?php endforeach; ?></tr><?php endforeach; ?>
<?php if (!$report['domains']): ?><tr><td colspan="5">No domains recorded for this <?= $division_report ? 'division' : 'school'; ?> and school year.</td></tr><?php endif; ?>
</tbody></table></div>
<?php endif; ?>
<div class="prepared"><strong>Prepared by:</strong><div class="prepared-signatory"><?= html_escape($prepared_by); ?></div></div>
</main></body></html>
