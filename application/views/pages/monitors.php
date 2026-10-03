<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?= base_url('assets/css/monitoring-tool.css'); ?>" rel="stylesheet">
<div class="monitoring-page monitoring-settings-page">
    <div class="monitoring-hero">
        <div><h2>Monitors</h2><p>Manage monitoring personnel and their section or unit.</p></div>
        <div class="monitoring-hero-actions"><a href="<?= base_url('Pages/monitoring_tool'); ?>">Monitoring Tool</a></div>
    </div>
    <?php if ($message = $this->session->flashdata('monitors_success')): ?>
        <div class="alert alert-success" role="status"><?= html_escape($message); ?></div>
    <?php endif; ?>
    <?php if ($errors): ?>
        <div class="alert alert-danger" role="alert"><?php foreach ($errors as $error): ?><div><?= html_escape($error); ?></div><?php endforeach; ?></div>
    <?php endif; ?>
    <div class="card"><div class="card-body">
        <h4 class="mb-3"><?= $form['id'] ? 'Edit Monitor' : 'Add Monitor'; ?></h4>
        <form method="post" action="<?= base_url('Pages/monitors'); ?>">
            <input type="hidden" name="monitoring_token" value="<?= html_escape($this->session->userdata('monitoring_token')); ?>">
            <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
            <input type="hidden" name="id" value="<?= html_escape($form['id']); ?>">
            <input type="hidden" name="action" value="<?= $form['id'] ? 'update' : 'create'; ?>">
            <div class="row">
                <?php foreach ($fields as $key => $label): ?>
                <div class="<?= in_array($key, array('section_unit', 'email'), true) ? 'col-12' : 'col-md-4'; ?> form-group">
                    <label for="monitor-<?= $key; ?>"><?= html_escape($label); ?><?= $key === 'middle_name' ? ' (optional)' : ' *'; ?></label>
                    <input type="<?= $key === 'email' ? 'email' : 'text'; ?>" class="form-control" id="monitor-<?= $key; ?>" name="<?= $key; ?>" value="<?= html_escape($form[$key]); ?>" maxlength="<?= $key === 'section_unit' ? 255 : ($key === 'email' ? 254 : 100); ?>" <?= $key !== 'middle_name' ? 'required' : ''; ?>>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label for="account-password">Account Password</label>
                <div class="input-group">
                    <input type="text" id="account-password" name="account_password" class="form-control" autocomplete="new-password" minlength="12" maxlength="72">
                    <div class="input-group-append"><button type="button" id="generate-password" class="btn btn-outline-primary">Generate Password</button></div>
                </div>
                <small class="form-text text-muted">Sign-in uses the email address. Account level: Monitoring Team. Copy the generated password before saving. For an existing account, leave blank to keep its password.</small>
            </div>
            <button type="submit" class="btn btn-primary"><?= $form['id'] ? 'Save Changes' : 'Add Monitor'; ?></button>
            <?php if ($form['id']): ?><a class="btn btn-outline-secondary" href="<?= base_url('Pages/monitors'); ?>">Cancel Edit</a><?php endif; ?>
        </form>
    </div></div>
    <div class="card"><div class="card-body">
        <h4 class="mb-3">Monitors <span class="badge badge-light"><?= count($monitors); ?></span></h4>
        <div class="table-responsive"><table class="table monitoring-table">
            <thead><tr><?php foreach ($fields as $label): ?><th scope="col"><?= html_escape($label); ?></th><?php endforeach; ?><th scope="col">Actions</th></tr></thead>
            <tbody>
                <?php foreach ($monitors as $monitor): ?>
                <tr>
                    <?php foreach ($fields as $key => $label): ?><td><?= html_escape($monitor[$key]); ?></td><?php endforeach; ?>
                    <td class="text-nowrap">
                        <a class="btn btn-sm btn-outline-primary" href="<?= base_url('Pages/monitors') . '?edit=' . (int) $monitor['id']; ?>">Edit</a>
                        <form class="d-inline monitor-delete" method="post" action="<?= base_url('Pages/monitors'); ?>">
                            <input type="hidden" name="monitoring_token" value="<?= html_escape($this->session->userdata('monitoring_token')); ?>">
                            <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
                            <input type="hidden" name="id" value="<?= (int) $monitor['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (!$monitors): ?><tr><td colspan="6" class="text-muted">No monitors yet. Add a monitor using the form above.</td></tr><?php endif; ?>
            </tbody>
        </table></div>
    </div></div>
</div>
<script>
document.getElementById('generate-password').addEventListener('click', function () {
    var bytes = new Uint8Array(18);
    window.crypto.getRandomValues(bytes);
    document.getElementById('account-password').value = Array.from(bytes, function (value) {
        return 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_'[value & 63];
    }).join('');
});
document.querySelectorAll('.monitor-delete').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!window.confirm('Delete this monitor and disable their account? This cannot be undone.')) event.preventDefault();
    });
});
</script>
