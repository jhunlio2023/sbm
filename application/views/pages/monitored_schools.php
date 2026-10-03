<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?= base_url('assets/css/monitoring-tool.css'); ?>" rel="stylesheet">
<link href="<?= base_url('assets/libs/select2/select2.min.css'); ?>" rel="stylesheet">
<style>
.monitored-details dd { white-space:pre-wrap; overflow-wrap:anywhere; }
.monitored-records-table { min-width:1100px; }
@media print {
 .navbar-custom,.left-side-menu,.footer,.modal,.no-print { display:none!important; }
 .content-page { margin:0!important; padding:0!important; }
 .content,.container-fluid { padding:0!important; }
 .table-responsive { overflow:visible; }
 @page { size:A4; margin:15mm; }
 tr, .monitored-details > div { break-inside:avoid; }
 thead { display:table-header-group; }
 h4, h5 { break-after:avoid; }
 .monitoring-page { color:#000; font-size:10pt; }
 .monitoring-page .table { width:100%; table-layout:fixed; }
 .monitoring-page .table th, .monitoring-page .table td { padding:7px; overflow-wrap:anywhere; color:#000; }
 .monitored-details > div { width:50%; flex:0 0 50%; max-width:50%; }
 .monitoring-page .card { overflow:visible; }
 .monitoring-page .table th:first-child { width:55%; }
 .monitoring-page .table th:nth-child(2) { width:15%; }
}
</style>
<div class="monitoring-page">
<div class="monitoring-hero no-print"><div><h2><?= $detail ? 'Monitoring Record Details' : 'Monitored Schools'; ?></h2><p><?= $team_user ? 'View the schools you monitored, your responses, and technical assistance needs.' : 'School assessments, responses, and technical assistance needs across regional monitoring records.'; ?></p></div><div class="monitoring-hero-actions"><a href="<?= base_url('Pages/monitoring_tool'); ?>">New assessment</a><?php if ($detail): ?><a href="<?= base_url('Pages/monitored_schools'); ?>">All monitored schools</a><?php endif; ?></div></div>
<?php if (!$detail):
$division_options = array();
foreach ($records as $entry) {
    $division_name = trim($entry->details['division'] ?? '');
    $division_options[$division_name] = $division_name !== '' ? $division_name : 'Unspecified division';
}
asort($division_options, SORT_NATURAL | SORT_FLAG_CASE);
?>
<div class="monitoring-summary">
 <div class="monitoring-stat"><span>Monitored schools</span><strong id="directory-school-count"><?= $school_count; ?></strong></div>
 <div class="monitoring-stat stat-no"><span>Assessments</span><strong id="directory-assessment-count"><?= count($records); ?></strong></div>
 <div class="monitoring-stat stat-yes"><span>All indicators answered</span><strong id="directory-complete-count"><?= $complete; ?></strong></div>
 <div class="monitoring-stat stat-open"><span>Incomplete assessments</span><strong id="directory-incomplete-count"><?= count($records) - $complete; ?></strong></div>
</div>
<div class="card"><div class="card-body">
<div class="monitoring-section-heading"><div><h4>School Monitoring Directory</h4><p class="text-muted mb-0 mt-1">Monitored by lists everyone who submitted an assessment for the same school and school year.</p></div></div>
<div class="row no-print"><div class="col-md-5 form-group">
<label for="directory-division">Division</label>
<select id="directory-division" class="form-control"><option value="">All divisions</option>
<?php foreach ($division_options as $value => $label): ?><option value="<?= html_escape('division:' . $value); ?>"><?= html_escape($label); ?></option><?php endforeach; ?>
</select></div></div>
<div class="table-responsive"><table id="monitored-schools-table" class="table monitored-records-table"><thead><tr><th>School / Year</th><th>Division / District</th><th>Level</th><th>School Head / Contact</th><th>Responses</th><th>Status</th><th>Monitored by</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($records as $record): $v = $record->details; ?>
<tr data-division="<?= html_escape('division:' . trim($v['division'] ?? '')); ?>" data-school="<?= html_escape(!empty($v['school_rec_id']) ? 'id:' . $v['school_rec_id'] : 'name:' . json_encode(array($v['division'] ?? '', $v['district'] ?? '', $record->school_name))); ?>" data-complete="<?= $record->complete ? '1' : '0'; ?>">
<td><strong><?= html_escape($record->school_name); ?></strong><br><?= html_escape($record->school_year); ?><br><small>Record #<?= (int) $record->id; ?></small></td>
<td><?= html_escape($v['division'] ?? '—'); ?><br><small><?= html_escape($v['district'] ?? '—'); ?></small></td>
<td><?= html_escape(implode(', ', $v['levels'] ?? array())); ?></td>
<td><?= html_escape($v['school_head'] ?? '—'); ?><br><small><?= html_escape($v['school_contact'] ?? ''); ?></small></td>
<td><div class="directory-responses"><span class="record-response response-yes">Yes <?= $record->yes; ?></span><span class="record-response response-no">No <?= $record->no; ?></span></div><small><?= $record->unanswered; ?> unanswered / <?= $record->total; ?></small></td>
<td><span class="record-response <?= $record->complete ? 'response-yes' : 'response-open'; ?>"><?= $record->complete ? 'All answered' : 'Incomplete'; ?></span></td>
<td><ul class="directory-monitors" aria-label="Monitors for this school and school year"><?php foreach ($record->monitor_names as $monitor_name): ?><li><i class="mdi mdi-account-outline" aria-hidden="true"></i><span><?= html_escape($monitor_name); ?></span></li><?php endforeach; ?></ul></td>
<td><div class="directory-actions"><?php if (!$team_user): ?><a class="btn btn-sm btn-outline-primary" href="<?= base_url('Pages/consolidated_monitoring_report/' . $record->id); ?>" target="_blank" rel="noopener">Consolidated Report</a><?php endif; ?> <a class="btn btn-sm btn-outline-primary" href="<?= base_url('Pages/monitored_schools/' . $record->id); ?>">Details</a> <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('Pages/monitored_schools/' . $record->id) . '?print=1'; ?>" target="_blank" rel="noopener" aria-label="<?= html_escape('Print monitoring tool for ' . $record->school_name); ?>"><i class="mdi mdi-printer" aria-hidden="true"></i> Print</a><?php if ((string) $record->created_by === (string) $this->session->username): ?> <a class="btn btn-sm btn-link" href="<?= base_url('Pages/monitoring_tool/' . $record->id); ?>">Edit</a><?php endif; ?></div></td>
</tr><?php endforeach; ?>
</tbody></table></div></div></div>
<?php else:
$record = $records[0]; $v = $record->details;
$answered = $record->yes + $record->no;
$progress = $record->total > 0 ? (int) round($answered / $record->total * 100) : 0;
?>
<div class="record-detail">
<section class="card record-overview"><div class="card-body">
<div class="record-heading">
<div><div class="record-eyebrow">School assessment · Record #<?= (int) $record->id; ?></div><h3><?= html_escape($record->school_name); ?></h3><p class="text-muted mb-0">School Year <?= html_escape($record->school_year); ?> <span aria-hidden="true">·</span> <?= html_escape(implode(', ', $v['levels'] ?? array()) ?: 'School level not recorded'); ?></p></div>
<div class="record-actions no-print"><button class="btn btn-outline-primary" type="button" onclick="window.print()"><i class="mdi mdi-printer mr-1" aria-hidden="true"></i>Print / Save PDF</button><?php if ((string) $record->created_by === (string) $this->session->username): ?><a class="btn btn-primary" href="<?= base_url('Pages/monitoring_tool/' . $record->id); ?>">Edit assessment</a><?php endif; ?></div>
</div>
<div class="record-completion"><div><span class="record-response <?= $record->complete ? 'response-yes' : 'response-open'; ?>"><?= $record->complete ? 'All indicators answered' : 'Incomplete assessment'; ?></span><span><?= $answered; ?> of <?= $record->total; ?> indicators answered</span></div><strong><?= $progress; ?>%</strong></div>
<progress class="record-progress" max="100" value="<?= $progress; ?>" aria-label="Indicators answered"><?= $progress; ?>%</progress>
</div></section>
<div class="monitoring-summary record-summary">
<div class="monitoring-stat"><span>Total indicators</span><strong><?= $record->total; ?></strong></div>
<div class="monitoring-stat stat-yes"><span>Yes responses</span><strong><?= $record->yes; ?></strong></div>
<div class="monitoring-stat stat-no"><span>No responses</span><strong><?= $record->no; ?></strong></div>
<div class="monitoring-stat stat-open"><span>Unanswered</span><strong><?= $record->unanswered; ?></strong></div>
</div>
<section class="card"><div class="card-body">
<div class="monitoring-section-heading"><h4>School &amp; monitoring information</h4></div>
<dl class="record-info monitored-details">
<?php foreach (array('division'=>'Division', 'district'=>'District', 'school_head'=>'School Head', 'school_contact'=>'School Head Contact', 'cluster_head'=>'PSDS/Cluster Head', 'cluster_contact'=>'PSDS/Cluster Head Contact', 'prepared_by'=>'Prepared by', 'conformed_by'=>'Conformed (School Head)') as $key=>$label): ?>
<div><dt><?= html_escape($label); ?></dt><dd><?= html_escape(($v[$key] ?? '') !== '' ? $v[$key] : 'Not recorded'); ?></dd></div>
<?php endforeach; ?>
</dl>
<div class="record-audit"><span><strong>Recorded by</strong> <?= html_escape($record->created_by); ?></span><span><strong>Created</strong> <?= html_escape($record->created_at); ?></span><span><strong>Last updated</strong> <?= html_escape($record->updated_at); ?></span></div>
</div></section>
<section class="card record-assistance"><div class="card-body"><div class="monitoring-section-heading"><h4><i class="mdi mdi-information-outline mr-1" aria-hidden="true"></i>Technical Assistance Needed</h4></div><p class="record-text mb-0"><?= html_escape(($v['technical_assistance'] ?? '') !== '' ? $v['technical_assistance'] : 'No technical assistance needs recorded.'); ?></p></div></section>
<div class="record-assessment-heading"><div class="record-eyebrow">Assessment responses</div><h4><?= html_escape($record->definition['title']); ?></h4><p class="text-muted">Review each domain’s indicators, remarks, and monitoring notes.</p></div>
<?php if (!$record->definition['sections']): ?><div class="alert alert-info">No domains were recorded for this assessment.</div><?php endif; ?>
<?php $index = 0; foreach ($record->definition['sections'] as $group_index => $section): ?>
<section class="card record-domain"><div class="card-body">
<div class="monitoring-section-heading"><h4><?= html_escape($section['title']); ?></h4><span class="monitoring-badge"><?= count($section['items']); ?> indicators</span></div>
<div class="table-responsive"><table class="table record-response-table"><caption class="sr-only"><?= html_escape($section['title']); ?> — indicators, responses, and remarks</caption><thead><tr><th scope="col">Indicator</th><th scope="col">Response</th><th scope="col">Remarks</th></tr></thead><tbody>
<?php foreach ($section['items'] as $item): $answer = $v['answers'][$index] ?? ''; ?>
<tr><td><div class="record-indicator"><span class="record-number"><?= $index + 1; ?></span><span><?= html_escape($item); ?></span></div></td><td><span class="record-response <?= $answer === 'yes' ? 'response-yes' : ($answer === 'no' ? 'response-no' : 'response-open'); ?>"><?= $answer === 'yes' ? 'Yes' : ($answer === 'no' ? 'No' : 'Unanswered'); ?></span></td><td class="record-text"><?php if (($v['remarks'][$index] ?? '') !== ''): ?><?= html_escape($v['remarks'][$index]); ?><?php else: ?><span class="text-muted">No remarks</span><?php endif; ?></td></tr>
<?php $index++; endforeach; ?></tbody></table></div>
<h5 class="record-notes-title">Domain notes</h5>
<dl class="record-notes">
<?php foreach (array('best_practices' => 'Best Practices', 'issues_concerns' => 'Issues/Concerns', 'action_taken' => 'Action Taken', 'status_remarks' => 'Status') as $key => $label): ?>
<div><dt><?= html_escape($label); ?></dt><dd class="record-text"><?= html_escape(($v['group_notes'][$group_index][$key] ?? '') !== '' ? $v['group_notes'][$group_index][$key] : 'None recorded.'); ?></dd></div>
<?php endforeach; ?>
</dl>
</div></section>
<?php endforeach; ?>
</div><?php endif; ?>
</div>
<?php if (!$detail): ?><script>
document.addEventListener('DOMContentLoaded', function () {
 var $ = window.jQuery;
 var divisionFilter = $('#directory-division');
 divisionFilter.select2({width:'100%'});
 $.fn.dataTable.ext.search.push(function (settings, data, index) {
   if (settings.nTable.id !== 'monitored-schools-table') return true;
   var selected = divisionFilter.val();
   return !selected || settings.aoData[index].nTr.getAttribute('data-division') === selected;
 });
 var table = $('#monitored-schools-table').DataTable({pageLength: 10, order:[], columnDefs:[{targets:7,orderable:false,searchable:false}], language:{emptyTable:'No monitoring assessments have been saved yet.',search:'Search assessments:'}});
 function updateSummary() {
   var schools = new Set(), assessments = 0, complete = 0;
   table.rows({search:'applied'}).nodes().each(function (row) {
     schools.add(row.getAttribute('data-school')); assessments++;
     if (row.getAttribute('data-complete') === '1') complete++;
   });
   $('#directory-school-count').text(schools.size);
   $('#directory-assessment-count').text(assessments);
   $('#directory-complete-count').text(complete);
   $('#directory-incomplete-count').text(assessments - complete);
 }
 divisionFilter.on('change', function () { table.draw(); });
 table.on('draw', updateSummary);
 updateSummary();
 $('#monitored-schools-table_length select').select2({minimumResultsForSearch:Infinity,width:'80px'});
});
</script><?php endif; ?>

<?php if ($detail && $this->input->get('print') === '1'): ?>
<script>
window.addEventListener('load', function () {
    document.title = <?= json_encode('GIDA Monitoring Tool - ' . $record->school_name . ' - ' . $record->school_year, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(function () { window.print(); });
    } else {
        window.print();
    }
});
</script>
<?php endif; ?>
