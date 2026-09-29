<div class="card mt-3"><div class="card-body">
    <a class="btn btn-outline-primary mb-3" href="<?= base_url('Pages/division_submission_report'); ?>">Back to Submission Report</a>
    <h3><?= html_escape($title); ?></h3>
    <p><strong><?= html_escape($school->schoolName); ?></strong> (<?= html_escape($school->schoolID); ?>) · Fiscal Year <?= html_escape($this->session->fy); ?></p>
    <?php if (!$rows) : ?>
        <div class="alert alert-info">No <?= html_escape(strtolower($title)); ?> records have been saved for this school in the active fiscal year.</div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead><tr><?php foreach ($headers as $header) : ?><th><?= html_escape($header); ?></th><?php endforeach; ?></tr></thead>
                <tbody><?php foreach ($rows as $row) : ?><tr>
                    <?php foreach ($row as $value) : ?><td style="white-space:pre-line; min-width:120px"><?= trim((string) $value) !== '' ? html_escape($value) : 'Not provided'; ?></td><?php endforeach; ?>
                </tr><?php endforeach; ?></tbody>
            </table>
        </div>
    <?php endif; ?>
</div></div>
