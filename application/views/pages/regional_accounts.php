<?php defined('BASEPATH') OR exit('No direct script access allowed');
$roles = array('region' => 'Regional User', 'monitoring_team' => 'Monitoring Team');
$token = $this->session->userdata('regional_accounts_token');
?>
<link href="<?= base_url('assets/css/monitoring-tool.css'); ?>" rel="stylesheet">
<div class="monitoring-page">
    <div class="monitoring-hero"><div><h2>Manage Accounts</h2><p>Manage Regional User and Monitoring Team accounts.</p></div></div>
    <?php if ($message = $this->session->flashdata('regional_accounts_success')): ?><div class="alert alert-success" role="status"><?= html_escape($message); ?></div><?php endif; ?>
    <?php if ($errors): ?><div class="alert alert-danger" role="alert"><?php foreach ($errors as $error): ?><div><?= html_escape($error); ?></div><?php endforeach; ?></div><?php endif; ?>
    <div class="card"><div class="card-body">
        <h4 class="mb-3"><?= $form['id'] ? 'Edit Account' : 'Create Account'; ?></h4>
        <form method="post" action="<?= base_url('Pages/regional_accounts'); ?>">
            <input type="hidden" name="regional_accounts_token" value="<?= html_escape($token); ?>">
            <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
            <input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= html_escape($form['id']); ?>">
            <div class="row">
                <div class="col-md-6 form-group"><label for="account-level">Account Level</label>
                    <?php if ($form['id']): ?>
                        <input type="hidden" name="position" value="<?= html_escape($form['position']); ?>">
                        <input id="account-level" class="form-control" readonly value="<?= html_escape($roles[$form['position']]); ?>">
                    <?php else: ?>
                        <select id="account-level" name="position" class="form-control"><?php foreach ($roles as $value => $label): ?><option value="<?= $value; ?>" <?= $form['position'] === $value ? 'selected' : ''; ?>><?= $label; ?></option><?php endforeach; ?></select>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 form-group"><label for="account-username">Username</label><input id="account-username" name="username" class="form-control" maxlength="45" required value="<?= html_escape($form['username']); ?>" <?= $form['id'] ? 'readonly' : ''; ?>></div>
            </div>
            <div class="row">
                <?php foreach (array('fname' => 'First Name', 'mname' => 'Middle Name (optional)', 'lname' => 'Last Name') as $key => $label): ?>
                    <div class="col-md-4 form-group"><label for="account-<?= $key; ?>"><?= $label; ?></label><input id="account-<?= $key; ?>" name="<?= $key; ?>" class="form-control" maxlength="45" value="<?= html_escape($form[$key]); ?>" <?= $key !== 'mname' ? 'required' : ''; ?>></div>
                <?php endforeach; ?>
            </div>
            <div class="form-group"><label for="account-email">Email Address</label><input type="email" id="account-email" name="email" class="form-control" maxlength="254" required value="<?= html_escape($form['email']); ?>"></div>
            <div class="form-group" id="account-unit-field" <?= $form['position'] === 'monitoring_team' ? '' : 'style="display:none"'; ?>><label for="account-unit">Section/Unit</label><input id="account-unit" name="section_unit" class="form-control" maxlength="255" value="<?= html_escape($form['section_unit']); ?>" <?= $form['position'] === 'monitoring_team' ? 'required' : ''; ?>><small class="form-text text-muted">This account will appear in Monitors and can be assigned to Indicators Groups in Settings.</small></div>
            <?php if (!$form['id']): ?>
                <div class="form-group"><label for="account-password">Password</label><div class="input-group"><input id="account-password" name="account_password" class="form-control" autocomplete="new-password" minlength="12" maxlength="72" required><div class="input-group-append"><button type="button" id="account-generate" class="btn btn-outline-primary">Generate Password</button></div></div><small class="form-text text-muted">Copy the password before saving. Users can sign in with their username or email address.</small></div>
            <?php endif; ?>
            <button class="btn btn-primary" type="submit">Save Account</button>
            <?php if ($form['id']): ?><a class="btn btn-outline-secondary" href="<?= base_url('Pages/regional_accounts'); ?>">Cancel Edit</a><?php endif; ?>
        </form>
    </div></div>
    <div class="card"><div class="card-body">
        <h4>Accounts</h4>
        <div class="form-group"><label for="account-search">Search accounts</label><input type="search" id="account-search" class="form-control" placeholder="Name, email, username, or account level"></div>
        <div class="table-responsive"><table class="table" id="accounts-table">
            <thead><tr><th>Name</th><th>Username / Email</th><th>Account Level</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody><?php foreach ($accounts as $account): ?>
                <tr><td><?= html_escape(trim($account['fname'] . ' ' . $account['mname'] . ' ' . $account['lname'])); ?></td><td><?= html_escape($account['username']); ?><br><?= html_escape($account['email']); ?></td><td><?= $roles[$account['position']]; ?></td><td><?= $account['virified'] == 0 ? 'Active' : 'Inactive'; ?></td>
                <td><a class="btn btn-sm btn-outline-primary mb-1" href="<?= base_url('Pages/regional_accounts') . '?edit=' . (int) $account['id']; ?>">Edit</a>
                    <?php $actions = array('reset' => 'Reset Password');
                    if ((string) $account['id'] !== (string) $this->session->id) {
                        $actions[$account['virified'] == 0 ? 'deactivate' : 'activate'] = $account['virified'] == 0 ? 'Deactivate' : 'Activate';
                        $actions['delete'] = 'Delete';
                    }
                    foreach ($actions as $action => $label): ?>
                    <form method="post" class="d-inline account-action" action="<?= base_url('Pages/regional_accounts'); ?>" data-action="<?= $action; ?>">
                        <input type="hidden" name="regional_accounts_token" value="<?= html_escape($token); ?>">
                        <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
                        <input type="hidden" name="id" value="<?= (int) $account['id']; ?>"><input type="hidden" name="action" value="<?= $action; ?>">
                        <button type="submit" class="btn btn-sm btn-outline-<?= $action === 'delete' ? 'danger' : 'secondary'; ?> mb-1"><?= $label; ?></button>
                    </form>
                    <?php endforeach; ?>
                </td></tr>
            <?php endforeach; ?></tbody>
        </table></div>
        <?php if (!$accounts): ?><p class="text-muted">No accounts found.</p><?php endif; ?>
    </div></div>
</div>
<script>
(function () {
    var level = document.querySelector('select#account-level');
    if (level) level.addEventListener('change', function () {
        var team = this.value === 'monitoring_team';
        document.getElementById('account-unit-field').style.display = team ? '' : 'none';
        document.getElementById('account-unit').required = team;
    });
    var generate = document.getElementById('account-generate');
    if (generate) generate.addEventListener('click', function () {
        var bytes = new Uint8Array(18); window.crypto.getRandomValues(bytes);
        document.getElementById('account-password').value = Array.from(bytes, function (value) { return 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_'[value & 63]; }).join('');
    });
    document.getElementById('account-search').addEventListener('input', function () {
        var query = this.value.toLowerCase();
        document.querySelectorAll('#accounts-table tbody tr').forEach(function (row) { row.hidden = row.textContent.toLowerCase().indexOf(query) === -1; });
    });
    document.querySelectorAll('.account-action').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            var messages = {reset: 'Reset this account’s password? The previous password will stop working.', deactivate: 'Deactivate this account and block access?', activate: 'Activate this account?', delete: 'Permanently delete this account? Its linked monitor and group assignments will be removed. Saved assessments will be retained.'};
            if (!window.confirm(messages[form.dataset.action])) event.preventDefault();
        });
    });
})();
</script>
