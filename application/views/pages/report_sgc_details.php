<?php
$district_summary = array();
foreach ($records as $school) {
    $key = json_encode(array($school->division_id, $school->district_id));
    if (!isset($district_summary[$key])) {
        $district_summary[$key] = array(
            'division' => $school->division_name,
            'district' => trim((string) $school->district_name) !== '' ? $school->district_name : 'Unassigned District',
            'count' => 0
        );
    }
    $district_summary[$key]['count']++;
}
?>
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a class="btn btn-outline-secondary mb-3" href="<?= base_url('Pages/report_sgc'); ?>">&larr; Back to SGC Report</a>
                <h3><?= html_escape($title); ?></h3>
                <p><?= number_format(count($records)); ?> matching schools</p>
                <?php if ($show_count_note) : ?>
                    <p class="text-muted">This list shows existing school records. The summary uses configured division school totals, so its Not Yet Responded count may differ.</p>
                <?php endif; ?>
                <?php if ($records) : ?>
                    <div class="table-responsive">
                        <table id="sgc-details-table" class="table table-striped" style="width:100%">
                            <thead><tr><th>No.</th><th>School ID</th><th>School Name</th><th>Division</th><th>District</th><th>SGC Status</th></tr></thead>
                            <tbody>
                                <?php foreach ($records as $index => $school) : ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= html_escape($school->schoolID); ?></td>
                                        <td><?= html_escape($school->schoolName); ?></td>
                                        <td><?= html_escape($school->division_name); ?></td>
                                        <td><?= html_escape(trim((string) $school->district_name) !== '' ? $school->district_name : 'Unassigned District'); ?></td>
                                        <td><?= html_escape($status_label); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-muted py-4">No schools match this SGC status.</p>
                <?php endif; ?>
                <section class="mt-4" aria-labelledby="sgc-district-summary-title">
                    <h4 id="sgc-district-summary-title">Summary per District</h4>
                    <p class="text-muted">School counts for <?= html_escape($status_label); ?> across all results, regardless of table searches or pagination.</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead><tr><th scope="col">Division</th><th scope="col">District</th><th scope="col" class="text-right">School Count</th></tr></thead>
                            <tbody>
                                <?php foreach ($district_summary as $district) : ?>
                                    <tr>
                                        <td><?= html_escape($district['division']); ?></td>
                                        <th scope="row"><?= html_escape($district['district']); ?></th>
                                        <td class="text-right"><?= number_format($district['count']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (!$district_summary) : ?>
                                    <tr><td colspan="3" class="text-center text-muted">No districts have schools matching this status.</td></tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot><tr><th colspan="2" scope="row">Total</th><td class="text-right font-weight-bold"><?= number_format(count($records)); ?></td></tr></tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('load', function () {
    $('#sgc-details-table').DataTable({
        pageLength: 20,
        lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
        order: [[0, 'asc']],
        language: { search: '_INPUT_', searchPlaceholder: 'Search schools...' }
    });
});
</script>
