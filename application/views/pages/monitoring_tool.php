<?php defined('BASEPATH') OR exit('No direct script access allowed');
$indicator_count = array_sum(array_map(function ($section) { return count($section['items']); }, $definition['sections']));
?>
<link href="<?= base_url('assets/libs/select2/select2.min.css'); ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/monitoring-tool.css'); ?>" rel="stylesheet">
<style>
.monitoring-table { min-width: 760px; }
.monitoring-table th:first-child { width: 52%; }
.monitoring-table .answer { width: 6%; text-align: center; vertical-align: middle; }
.monitoring-table input[type=radio] { width: 20px; height: 20px; cursor: pointer; }
.monitoring-table textarea { min-height: 88px; }
.monitoring-print-value { display: none; white-space: pre-wrap; overflow-wrap: anywhere; }
@media print {
    .navbar-custom, .left-side-menu, .footer, .modal, .no-print { display: none !important; }
    .content-page { margin: 0 !important; padding: 0 !important; }
    .content, .container-fluid, .card-body { padding: 0 !important; }
    .card { box-shadow: none; border: 0; }
    .monitoring-table { min-width: 0; font-size: 10pt; }
    .table-responsive { overflow: visible; }
    tr, .form-group { break-inside: avoid; }
    thead { display: table-header-group; }
    .monitoring-print-value { display: block; }
    #monitoring-form input.form-control, #monitoring-form textarea, #monitoring-form select, #monitoring-form .select2-container { display: none; }
    #monitoring-form { color: #000; }
    h3 { font-size: 15pt; }
}
</style>
<div class="monitoring-page">
<div class="monitoring-hero no-print">
    <div><h2>Monitoring Tool</h2><p>Monitor project implementation in Last Mile and GIDA schools.</p></div>
    <div class="monitoring-hero-actions"><?php if ($this->session->position === 'region'): ?><a href="<?= base_url('Pages/monitored_schools'); ?>">Monitored Schools</a><?php endif; ?><a href="<?= base_url('Pages/monitoring_tool'); ?>">New assessment</a><?php if ($this->session->position === 'region'): ?><a href="<?= base_url('Pages/monitoring_settings'); ?>"><i class="mdi mdi-settings" aria-hidden="true"></i> Settings</a><?php endif; ?><a href="<?= base_url(); ?>"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Dashboard</a></div>
</div>
<div class="monitoring-summary no-print" aria-label="Assessment summary">
    <div class="monitoring-stat"><span>Indicators · <?= count($definition['sections']); ?> sections</span><strong><?= $indicator_count; ?></strong></div>
    <div class="monitoring-stat stat-yes"><span>Yes responses</span><strong id="summary-yes">0</strong></div>
    <div class="monitoring-stat stat-no"><span>No responses</span><strong id="summary-no">0</strong></div>
    <div class="monitoring-stat stat-open"><span>Unanswered</span><strong id="summary-open"><?= $indicator_count; ?></strong></div>
</div>
<?php if ($message = $this->session->flashdata('monitoring_success')): ?>
<div class="alert alert-success no-print" role="status"><?= html_escape($message); ?></div>
<?php endif; ?>
<?php if ($errors): ?><div class="alert alert-danger no-print" role="alert"><?php foreach (array_unique($errors) as $error): ?><div><?= html_escape($error); ?></div><?php endforeach; ?></div><?php endif; ?>
<?php if (!$definition['sections']): ?><div class="alert alert-info">No Indicators Groups are available. Contact a Region user to assign your groups and indicators.</div><?php endif; ?>
<div class="card"><div class="card-body">
    <h3 class="text-center monitoring-document-title"><?= html_escape($definition['title']); ?></h3>
    <form id="monitoring-form" method="post" action="<?= html_escape(base_url('Pages/monitoring_tool' . ($record ? '/' . $record->id : ''))); ?>">
        <input type="hidden" name="definition_snapshot" value="<?= html_escape($definition_snapshot); ?>">
        <input type="hidden" name="definition_signature" value="<?= html_escape($definition_signature); ?>">
        <input type="hidden" name="monitoring_token" value="<?= html_escape($this->session->userdata('monitoring_token')); ?>">
        <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
        <div class="monitoring-section-heading"><h4><i class="mdi mdi-school mr-2" aria-hidden="true"></i>School information</h4><span class="monitoring-badge no-print"><?= $record ? 'Saved record' : 'New assessment'; ?></span></div>
        <div class="row">
        <?php foreach ($fields as $key => $label): if (in_array($key, array('prepared_by', 'conformed_by'), true)) continue; ?>
            <div class="col-md-6 form-group"><label for="mt-<?= $key; ?>"><?= html_escape($label); ?><?= in_array($key, array('school_name', 'school_year', 'division', 'district'), true) ? ' *' : ''; ?></label>
            <?php if (in_array($key, array('division', 'district', 'school_name'), true)):
                $id_key = array('division' => 'division_id', 'district' => 'district_id', 'school_name' => 'school_rec_id')[$key]; ?>
            <select class="form-control" id="mt-<?= $key; ?>" name="<?= $id_key; ?>" required><option value="">Select <?= html_escape($label); ?></option></select>
            <?php if (!empty($values[$key])): ?><small class="text-muted no-print">Previously saved: <?= html_escape($values[$key]); ?></small><?php endif; ?>
            <?php else: ?>
            <input class="form-control" id="mt-<?= $key; ?>" name="<?= $key; ?>" maxlength="<?= $key === 'school_year' ? 30 : 255; ?>" value="<?= html_escape(isset($values[$key]) ? $values[$key] : ''); ?>" <?= in_array($key, array('school_name', 'school_year'), true) ? 'required' : ''; ?>>
            <?php endif; ?></div>
        <?php endforeach; ?>
        </div>
        <fieldset class="form-group"><legend class="font-16">Level</legend>
            <?php foreach (array('Elementary', 'IS', 'JHS', 'SHS') as $level): ?>
            <label class="mr-3"><input type="checkbox" name="levels[]" value="<?= $level; ?>" <?= in_array($level, isset($values['levels']) ? $values['levels'] : array(), true) ? 'checked' : ''; ?>> <?= $level; ?></label>
            <?php endforeach; ?>
        </fieldset>
        <div class="monitoring-introduction"><h5>About this monitoring tool</h5>
        <?php foreach ($definition['introduction'] as $paragraph): ?><p><?= html_escape($paragraph); ?></p><?php endforeach; ?>
        </div>
        <p class="text-muted no-print">You may save an incomplete record and return to it later. Required fields are marked *.</p>
        <?php if (!$definition['sections']): ?><div class="alert alert-info">No indicators are available for this assessment. Contact a Region user for assistance.</div><?php endif; ?>
        <?php $index = 0; foreach ($definition['sections'] as $group_index => $section): ?>
        <section class="monitoring-indicator-section" aria-label="<?= html_escape($section['title']); ?>">
        <div class="monitoring-section-heading"><h4><?= html_escape($section['title']); ?></h4><span class="monitoring-badge no-print"><?= count($section['items']); ?> indicators</span></div>
        <div class="table-responsive"><table class="table table-bordered monitoring-table">
            <thead class="thead-light"><tr><th scope="col">Items</th><th scope="col" class="answer">Yes</th><th scope="col" class="answer">No</th><th scope="col">Remarks</th></tr></thead>
            <tbody><?php foreach ($section['items'] as $item): ?>
            <tr><td id="item-<?= $index; ?>"><?= ($index + 1) . '. ' . html_escape($item); ?><button type="button" class="btn btn-link btn-sm d-block no-print clear-answer" data-item="<?= $index; ?>">Clear answer</button></td>
                <?php foreach (array('yes', 'no') as $answer): ?><td class="answer"><input type="radio" name="answers[<?= $index; ?>]" value="<?= $answer; ?>" aria-label="<?= ucfirst($answer); ?>, item <?= $index + 1; ?>" aria-describedby="item-<?= $index; ?>" <?= isset($values['answers'][$index]) && $values['answers'][$index] === $answer ? 'checked' : ''; ?>></td><?php endforeach; ?>
                <td><textarea class="form-control" name="remarks[<?= $index; ?>]" maxlength="5000" aria-label="Remarks for item <?= $index + 1; ?>"><?= html_escape(isset($values['remarks'][$index]) ? $values['remarks'][$index] : ''); ?></textarea></td>
            </tr><?php $index++; endforeach; ?></tbody>
        </table></div>
        <div class="row mt-3">
            <?php foreach (array('best_practices' => 'Best Practices', 'issues_concerns' => 'Issues/Concerns', 'action_taken' => 'Action Taken', 'status_remarks' => 'Status') as $key => $label): ?>
                <div class="col-md-6 form-group">
                    <label for="group-<?= (int) $group_index; ?>-<?= $key; ?>"><?= html_escape($label); ?></label>
                    <textarea id="group-<?= (int) $group_index; ?>-<?= $key; ?>" class="form-control" name="group_notes[<?= (int) $group_index; ?>][<?= $key; ?>]" rows="4" maxlength="5000"><?= html_escape($values['group_notes'][$group_index][$key] ?? ''); ?></textarea>
                </div>
            <?php endforeach; ?>
        </div>
        </section>
        <?php endforeach; ?>
        <p class="font-weight-bold monitoring-total" id="monitoring-totals" aria-live="polite"></p>
        <div class="monitoring-section-heading"><h4>Assistance and signatories</h4></div>
        <div class="form-group"><label for="technical-assistance">Technical Assistance Needed</label><textarea id="technical-assistance" name="technical_assistance" class="form-control" rows="5" maxlength="10000"><?= html_escape(isset($values['technical_assistance']) ? $values['technical_assistance'] : ''); ?></textarea></div>
        <div class="row">
        <?php foreach (array('prepared_by', 'conformed_by') as $key): ?>
            <div class="col-md-6 form-group"><label for="mt-<?= $key; ?>"><?= html_escape($fields[$key]); ?></label><input id="mt-<?= $key; ?>" class="form-control" name="<?= $key; ?>" maxlength="255" value="<?= html_escape(isset($values[$key]) ? $values[$key] : ''); ?>" <?= $key === 'prepared_by' ? 'readonly' : ''; ?>></div>
        <?php endforeach; ?>
        </div>
        <div class="no-print monitoring-form-actions"><button class="btn btn-primary" type="submit"><i class="mdi mdi-content-save mr-1" aria-hidden="true"></i>Save monitoring record</button> <button id="monitoring-print" class="btn btn-outline-secondary" type="button"><i class="mdi mdi-printer mr-1" aria-hidden="true"></i>Print / Save PDF</button><span id="monitoring-status" class="ml-2 text-muted" role="status"></span></div>
    </form>
</div></div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('monitoring-form'), dirty = false;
    function totals() {
        var yes = form.querySelectorAll('input[type=radio][value=yes]:checked').length;
        var no = form.querySelectorAll('input[type=radio][value=no]:checked').length;
        document.getElementById('summary-yes').textContent = yes;
        document.getElementById('summary-no').textContent = no;
        document.getElementById('summary-open').textContent = <?= $index; ?> - yes - no;
        document.getElementById('monitoring-totals').textContent = 'Total: Yes ' + yes + ' · No ' + no + ' · Unanswered ' + (<?= $index; ?> - yes - no) + ' / <?= $index; ?> items';
    }
    function changed() { dirty = true; document.getElementById('monitoring-status').textContent = 'Unsaved changes'; totals(); }
    form.addEventListener('input', changed);
    form.addEventListener('change', changed);
    form.addEventListener('submit', function () { dirty = false; });
    form.querySelectorAll('.clear-answer').forEach(function (button) {
        button.addEventListener('click', function () {
            form.querySelectorAll('input[name="answers[' + button.dataset.item + ']"]').forEach(function (input) { input.checked = false; });
            changed();
        });
    });
    var $ = window.jQuery;
    var directories = <?= json_encode(array('divisions' => $divisions, 'districts' => $districts, 'schools' => $schools), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var selected = <?= json_encode(array('division' => $values['division_id'] ?? '', 'district' => $values['district_id'] ?? '', 'school' => $values['school_rec_id'] ?? ''), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var division = $('#mt-division'), district = $('#mt-district'), school = $('#mt-school_name');
    function options(select, rows, key, label, value, enabled, placeholder) {
        select.empty().append(new Option(placeholder, ''));
        rows.forEach(function (row) { select.append(new Option(row[label], row[key])); });
        select.prop('disabled', !enabled).val(value || '').trigger('change.select2');
    }
    function districts(value) {
        options(district, directories.districts.filter(function (row) { return String(row.division_id) === division.val(); }), 'id', 'description', value, !!division.val(), 'Select District');
    }
    function schools(value) {
        options(school, directories.schools.filter(function (row) { return String(row.district_id) === district.val() && String(row.division_id) === division.val(); }), 'recID', 'schoolName', value, !!district.val(), 'Select School');
    }
    options(division, directories.divisions, 'id', 'description', selected.division, true, 'Select Division');
    districts(selected.district); schools(selected.school);
    $('#monitoring-form select').select2({width: '100%'});
    division.on('change', function () { districts(''); schools(''); changed(); });
    district.on('change', function () { schools(''); changed(); });
    school.on('change', changed);
    window.addEventListener('beforeunload', function (event) { if (dirty) { event.preventDefault(); event.returnValue = ''; } });
    function printValues() {
        form.querySelectorAll('.monitoring-print-value').forEach(function (element) { element.remove(); });
        form.querySelectorAll('input.form-control, textarea, select').forEach(function (input) {
            var value = document.createElement('div'); value.className = 'monitoring-print-value'; value.textContent = (input.tagName === 'SELECT' ? (input.value && input.selectedOptions[0] ? input.selectedOptions[0].text : '') : input.value) || '____________________'; input.insertAdjacentElement('afterend', value);
        });
    }
    window.addEventListener('beforeprint', printValues);
    document.getElementById('monitoring-print').addEventListener('click', function () { printValues(); window.print(); });
    totals();
});
</script>
