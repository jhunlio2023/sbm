<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$monitor_labels = array();
foreach ($monitors as $monitor) {
    $monitor_labels[$monitor['id']] = implode(' ', array_filter(array($monitor['first_name'], $monitor['middle_name'], $monitor['last_name']), 'strlen')) . ' — ' . $monitor['section_unit'];
}
?>
<link href="<?= base_url('assets/libs/select2/select2.min.css'); ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/monitoring-tool.css'); ?>" rel="stylesheet">
<div class="monitoring-page monitoring-settings-page">
<div class="monitoring-hero">
    <div><h2>Monitoring Tool Settings</h2><p>Manage the Domains and indicators used in school monitoring assessments.</p></div>
    <div class="monitoring-hero-actions"><a href="<?= base_url('Pages/monitoring_tool'); ?>"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Monitoring Tool</a></div>
</div>
<div class="monitoring-summary settings-summary">
    <div class="monitoring-stat"><span>Domains</span><strong><?= count($sections); ?></strong></div>
    <div class="monitoring-stat stat-yes"><span>Indicators</span><strong><?= count($indicators); ?></strong></div>
</div>
<?php if ($message = $this->session->flashdata('monitoring_settings_success')): ?><div class="alert alert-success" role="status"><?= html_escape($message); ?></div><?php endif; ?>
<?php if ($errors): ?><div class="alert alert-danger" role="alert"><?php foreach ($errors as $error): ?><div><?= html_escape($error); ?></div><?php endforeach; ?></div><?php endif; ?>
<div class="monitoring-introduction"><strong><i class="mdi mdi-information-outline mr-1" aria-hidden="true"></i> Changes apply to new assessments</strong><p class="mb-0 mt-1">Saved records and forms already opened retain their original indicators and answers. Lower order numbers appear first; entries with the same order appear in creation order.</p></div>
<div class="card"><div class="card-body">
    <div class="monitoring-section-heading"><div><h4 id="editor-heading"><?= $form['id'] ? 'Edit entry' : 'Add an entry'; ?></h4><p class="text-muted mb-0 mt-1">Choose an entry type, enter its details, and set its display order.</p></div><span class="monitoring-badge" id="editor-mode"><?= $form['id'] ? 'Editing' : 'New entry'; ?></span></div>
    <form id="settings-editor" method="post" action="<?= base_url('Pages/monitoring_settings'); ?>">
        <input type="hidden" name="monitoring_token" value="<?= html_escape($this->session->userdata('monitoring_token')); ?>">
        <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
        <input type="hidden" name="id" id="entry-id" value="<?= html_escape($form['id']); ?>">
        <input type="hidden" name="action" id="entry-action" value="<?= $form['id'] ? 'update' : 'create'; ?>">
        <div class="row">
            <div class="col-md-4 form-group"><label for="entry-entity">Entry type</label><select class="form-control" name="entity" id="entry-entity"><option value="indicator" <?= $form['entity'] === 'indicator' ? 'selected' : ''; ?>>Indicator</option><option value="section" <?= $form['entity'] === 'section' ? 'selected' : ''; ?>>Domain</option></select></div>
            <div class="col-md-5 form-group" id="section-field"><label for="entry-section">Domain</label><select name="section_id" id="entry-section" class="form-control"><option value="">Select a Domain</option><?php foreach ($sections as $section): ?><option value="<?= (int) $section['id']; ?>" <?= (string) $form['section_id'] === (string) $section['id'] ? 'selected' : ''; ?>><?= html_escape($section['title']); ?></option><?php endforeach; ?></select></div>
            <div class="col-md-3 form-group"><label for="entry-order">Order</label><input type="number" class="form-control" name="sort_order" id="entry-order" min="0" max="99999" required value="<?= html_escape($form['sort_order']); ?>"></div>
        </div>
        <div class="form-group" id="monitor-field" <?= $form['entity'] === 'section' ? '' : 'style="display:none"'; ?>>
            <label for="entry-monitor">Monitors</label>
            <select name="monitor_id" id="entry-monitor" class="form-control" <?= $form['entity'] === 'section' ? '' : 'disabled'; ?>>
                <option value="">Select a monitor (optional)</option>
                <?php foreach ($monitor_labels as $id => $label): ?>
                    <option value="<?= (int) $id; ?>" <?= (string) $form['monitor_id'] === (string) $id ? 'selected' : ''; ?>><?= html_escape($label); ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (!$monitors): ?><small class="form-text text-muted">No monitors yet. <a href="<?= base_url('Pages/monitors'); ?>">Add a monitor</a> to make it available here.</small><?php endif; ?>
        </div>
        <div class="form-group"><label for="entry-text">Domain title / Indicator text</label><textarea class="form-control" id="entry-text" name="text" rows="3" required maxlength="5000"><?= html_escape($form['text']); ?></textarea></div>
        <div class="monitoring-form-actions"><button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save mr-1" aria-hidden="true"></i>Save entry</button> <button type="button" class="btn btn-outline-secondary" id="new-entry">New entry / Cancel edit</button>
        <a class="btn btn-link" href="<?= base_url('Pages/monitoring_tool'); ?>">Open Monitoring Tool</a></div>
    </form>
</div></div>
<?php if (!$sections): ?><div class="alert alert-info">No Domains yet. Add a Domain, then add its indicators.</div><?php endif; ?>
<?php foreach ($sections as $section): ?>
<div class="card"><div class="card-body">
    <div class="monitoring-section-heading flex-wrap">
        <div><h4><?= html_escape($section['title']); ?></h4><span class="monitoring-badge mt-2">Order <?= (int) $section['sort_order']; ?></span>
            <p class="text-muted mb-0 mt-2">Monitor: <?= html_escape(empty($section['monitor_id']) ? 'Not assigned' : ($monitor_labels[$section['monitor_id']] ?? 'Monitor no longer available')); ?></p>
        </div>
        <div><button type="button" class="btn btn-sm btn-outline-primary edit-entry" data-entity="section" data-id="<?= (int) $section['id']; ?>">Edit Domain</button> <button type="button" class="btn btn-sm btn-outline-danger delete-entry" data-entity="section" data-id="<?= (int) $section['id']; ?>">Delete Domain</button></div>
    </div>
    <div class="table-responsive"><table class="table monitoring-table settings-table"><thead><tr><th scope="col">Order</th><th scope="col">Indicator</th><th scope="col">Actions</th></tr></thead><tbody>
    <?php $count = 0; foreach ($indicators as $indicator): if ($indicator['section_id'] != $section['id']) continue; $count++; ?>
        <tr><td><span class="monitoring-badge"><?= (int) $indicator['sort_order']; ?></span></td><td><?= html_escape($indicator['description']); ?></td><td style="min-width:150px"><button type="button" class="btn btn-sm btn-outline-primary edit-entry" data-entity="indicator" data-id="<?= (int) $indicator['id']; ?>">Edit</button> <button type="button" class="btn btn-sm btn-outline-danger delete-entry" data-entity="indicator" data-id="<?= (int) $indicator['id']; ?>">Delete</button></td></tr>
    <?php endforeach; ?>
    <?php if (!$count): ?><tr><td colspan="3" class="text-muted">No indicators. Add an indicator above and select this Domain.</td></tr><?php endif; ?>
    </tbody></table></div>
</div></div>
<?php endforeach; ?>
<form id="settings-delete" method="post" action="<?= base_url('Pages/monitoring_settings'); ?>">
    <input type="hidden" name="monitoring_token" value="<?= html_escape($this->session->userdata('monitoring_token')); ?>">
    <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
    <input type="hidden" name="action" value="delete"><input type="hidden" name="entity"><input type="hidden" name="id">
</form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var $ = window.jQuery;
    var entries = <?= json_encode(array('section' => $sections, 'indicator' => $indicators), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    $('#settings-editor select').select2({width: '100%'});
    function toggleSection() {
        var indicator = $('#entry-entity').val() === 'indicator';
        $('#section-field').toggle(indicator);
        $('#monitor-field').toggle(!indicator);
        $('#entry-monitor').prop('disabled', indicator);
        $('#editor-mode').text($('#entry-id').val() ? 'Editing' : 'New entry');
        $('#entry-section').prop('required', indicator);
        $('#entry-text').attr('maxlength', indicator ? 5000 : 255);
    }
    $('#entry-entity').on('change', function () {
        $('#entry-monitor').val('').trigger('change.select2');
        $('#entry-id').val(''); $('#entry-action').val('create'); $('#editor-heading').text('Add an entry'); toggleSection();
    });
    $('.edit-entry').on('click', function () {
        var entity = this.dataset.entity, id = this.dataset.id;
        var entry = entries[entity].find(function (item) { return String(item.id) === id; });
        $('#entry-entity').val(entity).trigger('change.select2');
        $('#entry-id').val(id); $('#entry-action').val('update');
        $('#entry-section').val(entry.section_id || '').trigger('change.select2');
        $('#entry-monitor').val(entry.monitor_id || '').trigger('change.select2');
        $('#entry-order').val(entry.sort_order); $('#entry-text').val(entry.description || entry.title);
        $('#editor-heading').text('Edit ' + (entity === 'section' ? 'Domain' : 'Indicator')); toggleSection();
        document.getElementById('settings-editor').scrollIntoView({behavior: 'smooth'}); $('#entry-text').trigger('focus');
    });
    $('#new-entry').on('click', function () {
        $('#entry-monitor').val('').trigger('change.select2');
        $('#entry-id').val(''); $('#entry-action').val('create'); $('#entry-text').val(''); $('#entry-order').val('1'); $('#editor-heading').text('Add an entry'); toggleSection();
    });
    $('.delete-entry').on('click', function () {
        var entity = this.dataset.entity;
        if (!window.confirm('Delete this ' + (entity === 'section' ? 'Domain' : 'Indicator') + '? Saved monitoring records will be preserved.')) return;
        var form = document.getElementById('settings-delete'); form.elements.entity.value = entity; form.elements.id.value = this.dataset.id; form.submit();
    });
    toggleSection();
});
</script>
