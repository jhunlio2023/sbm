<?php
$district_groups = array();
foreach ($schools as $school) {
    $district_name = trim((string) $school->district_name);
    $district_key = $district_name !== '' ? 'district_' . $school->district_id : 'unassigned';
    if (!isset($district_groups[$district_key])) {
        $district_groups[$district_key] = array(
            'name' => $district_name !== '' ? $district_name : 'Unassigned District',
            'schools' => array(),
        );
    }
    $district_groups[$district_key]['schools'][] = $school;
}
uasort($district_groups, function ($left, $right) {
    return strnatcasecmp($left['name'], $right['name']);
});
?>
<style>
    .submission-report .report-heading { margin: 18px 0 22px; padding: 26px; border-radius: 16px; background: linear-gradient(135deg, #64142d, #a83255); color: #fff; }
    .submission-report .report-heading h2 { color: #fff; font-size: 25px; margin: 0 0 8px; }
    .submission-report .report-heading p { margin: 0; }
    .submission-report .card { border: 1px solid #e8ecf4; border-radius: 16px; box-shadow: 0 6px 24px rgba(31,45,75,.05); }
    .submission-report .report-overview, .submission-report .report-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .submission-report .report-overview { margin-bottom: 16px; }
    .submission-report .report-overview h4 { margin: 0 0 4px; }
    .submission-report .report-overview p { margin: 0; color: #687086; }
    .submission-report .report-count { padding: 8px 14px; border-radius: 20px; background: #fff1f5; color: #8b1e3f; font-weight: 600; }
    .submission-report .report-toolbar { margin-bottom: 12px; }
    .submission-report .district-card { margin-top: 18px; border: 1px solid #dfe4ed; border-radius: 12px; overflow: hidden; }
    .submission-report .district-header { display: flex; align-items: center; gap: 12px; padding: 14px 18px; background: #f8f9fc; }
    .submission-report .district-toggle { flex: 1; min-width: 0; border: 0; background: transparent; padding: 4px 0; text-align: left; color: #27324a; display: flex; align-items: center; gap: 12px; cursor: pointer; }
    .submission-report .district-toggle:hover { color: #8b1e3f; }
    .submission-report .district-toggle:focus-visible { outline: 2px solid #8b1e3f; outline-offset: 4px; border-radius: 4px; }
    .submission-report .district-heading { font-size: 16px; font-weight: 700; }
    .submission-report .district-chevron { font-size: 23px; color: #8b1e3f; transition: transform .18s; }
    .submission-report .district-toggle[aria-expanded="true"] .district-chevron { transform: rotate(90deg); }
    .submission-report .district-body { padding: 18px; border-top: 1px solid #e8ecf4; }
    .submission-report .district-body[hidden] { display: none !important; }
    .submission-report .district-submission-table { font-size: 13px; }
    .submission-report .district-submission-table th { font-size: 12px; color: #556078; vertical-align: middle; }
    .submission-report .district-submission-table tbody tr:hover { background: #fff8fa; }
    .submission-report .district-submission-table td:first-child { min-width: 190px; }
    .submission-report .badge-success { background: #e4f5eb; color: #20603b; }
    .submission-report .badge-warning { background: #fff2d6; color: #805600; }
    .submission-report .badge-secondary { background: #edf0f5; color: #536078; }
    @media (max-width: 575px) {
        .submission-report .report-heading { padding: 20px; }
        .submission-report .district-header { flex-wrap: wrap; padding: 12px; }
        .submission-report .district-toggle { flex-basis: 100%; }
        .submission-report .district-body { padding: 12px; }
    }
    @media (prefers-reduced-motion: reduce) { .submission-report .district-chevron { transition: none; } }
    .submission-report th { background: #f8f9fc; }
    .submission-report td { vertical-align: middle; }
    .submission-report .detail-link { display: block; color: inherit; }
    .submission-report .detail-link:hover, .submission-report .detail-link:focus { color: #8b1e3f; text-decoration: underline; }
    .submission-report .profile-progress { height: 7px; margin: 6px 0; background: #e8ecf4; border-radius: 4px; overflow: hidden; min-width: 110px; }
    .submission-report .profile-progress span { display: block; height: 100%; background: #8b1e3f; }
    .submission-report .badge { font-size: 12px; padding: 7px 9px; }
    .submission-report small { display: block; margin-top: 5px; }
</style>
<div class="submission-report">
    <div class="report-heading">
        <h2><i class="mdi mdi-chart-line mr-2" aria-hidden="true"></i>Submission Report</h2>
        <p>School submission status grouped by district · Fiscal Year <?= html_escape($this->session->fy); ?></p>
    </div>
    <div class="card"><div class="card-body">
        <div class="report-overview">
            <div><h4>Schools by district</h4><p>Expand a district, then select a school or status to view its details.</p></div>
            <span class="report-count"><?= count($district_groups); ?> districts · <?= count($schools); ?> schools</span>
        </div>
        <p class="text-muted">Profile completion reflects the 13 key fields used on the school dashboard. Workflow statuses reflect records saved for the active fiscal year.</p>
        <?php if (empty($schools)) : ?>
            <p class="text-center py-4">No schools are available for your division.</p>
        <?php else : ?>
            <div class="mb-3">
                <div class="report-toolbar">
                    <div class="btn-group" role="group" aria-label="District visibility">
                        <button type="button" class="btn btn-outline-secondary expand-districts">Expand All</button>
                        <button type="button" class="btn btn-outline-secondary collapse-districts">Collapse All</button>
                    </div>
                <button type="button" class="btn btn-primary print-all-districts"><i class="mdi mdi-printer mr-1" aria-hidden="true"></i>Print All Districts</button>
                </div>
                <small class="text-muted">Printing includes all schools in the selected district or all districts, regardless of search or pagination.</small>
                <p class="text-danger print-error mt-2" role="alert" hidden></p>
            </div>
            <?php $district_index = 0; foreach ($district_groups as $group) :
                $district_index++;
                $panel_id = 'submission-district-' . $district_index;
                $expanded = $district_index === 1;
            ?>
            <section class="district-card">
                <div class="district-header">
                    <button type="button" id="<?= $panel_id; ?>-toggle" class="district-toggle" aria-expanded="<?= $expanded ? 'true' : 'false'; ?>" aria-controls="<?= $panel_id; ?>">
                        <i class="mdi mdi-chevron-right district-chevron" aria-hidden="true"></i>
                        <span class="district-heading"><?= html_escape($group['name']); ?> <span class="badge badge-light"><?= count($group['schools']); ?> schools</span></span>
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm print-district" aria-label="Print <?= html_escape($group['name']); ?>"><i class="mdi mdi-printer mr-1" aria-hidden="true"></i>Print District</button>
                </div>
            <div id="<?= $panel_id; ?>" class="district-body" role="region" aria-labelledby="<?= $panel_id; ?>-toggle" <?= $expanded ? '' : 'hidden'; ?>>
            <div class="table-responsive">
                <table class="table table-bordered table-hover district-submission-table" style="width:100%">
                    <thead><tr>
                        <th>School Name</th>
                        <th>Submission Status<br><small>School Profile Update</small></th>
                        <th>Self-Assessment Checklist Status</th>
                        <th>TA Form Status</th>
                        <th>TANA Scoring Status</th>
                        <th>Priority Ranking</th>
                        <th>Action Plan</th>
                    </tr></thead>
                    <tbody>
                    <?php foreach ($group['schools'] as $school) :
                        $detail_url = base_url('Pages/division_submission_details/' . (int) $school->recID . '/');
                        $detail_types = array('sbm', 'sbm_ta', 'tana', 'tana_summary', 'sgod_action_plan');
                    ?>
                        <tr>
                            <td><a class="detail-link" href="<?= html_escape($detail_url . 'profile'); ?>"><strong><?= html_escape($school->schoolName); ?></strong><small class="text-muted"><?= html_escape($school->schoolID); ?></small></a></td>
                            <td data-order="<?= (int) $school->profile_percentage; ?>">
                                <a class="detail-link" href="<?= html_escape($detail_url . 'profile'); ?>" aria-label="View school profile details">
                                <strong><?= (int) $school->profile_percentage; ?>%</strong>
                                <div class="profile-progress" role="progressbar" aria-label="School profile completion" aria-valuenow="<?= (int) $school->profile_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><span style="width:<?= (int) $school->profile_percentage; ?>%"></span></div>
                                <small class="text-muted"><?= (int) $school->profile_filled; ?> of 13 fields filled</small>
                                </a>
                            </td>
                            <?php foreach ($school->statuses as $index => $status) :
                                $color = in_array($status, array('Finalized', 'Completed', 'Active'), true) ? 'success' : ($status === 'Draft saved' ? 'warning' : 'secondary');
                            ?>
                                <td><a class="detail-link" href="<?= html_escape($detail_url . $detail_types[$index]); ?>" title="View details"><span class="badge badge-<?= $color; ?>"><?= html_escape($status); ?></span>
                                    <?php if ($index === 2) : ?><small class="text-muted"><?= (int) $school->scored; ?> of 42 indicators scored</small><?php endif; ?>
                                    <?php if ($index === 3) : ?><small class="text-muted"><?= (int) $school->priority_count; ?> priorities saved</small><?php endif; ?>
                                    <?php if ($index === 4) : ?><small class="text-muted"><?= (int) $school->action_count; ?> action plan items</small><?php endif; ?>
                                </a></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
            </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </div></div>
</div>

<script>
window.addEventListener('load', function () {
    $('.district-submission-table').DataTable({
        order: [[0, 'asc']],
        pageLength: 10,
        language: { searchPlaceholder: 'Search schools in this district...' }
    });

    function setDistrictExpanded(button, expanded) {
        button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        var panel = document.getElementById(button.getAttribute('aria-controls'));
        panel.hidden = !expanded;
        if (expanded) {
            $(panel).find('table').DataTable().columns.adjust();
        }
    }
    $('.district-toggle').on('click', function () {
        setDistrictExpanded(this, this.getAttribute('aria-expanded') !== 'true');
    });
    $('.expand-districts, .collapse-districts').on('click', function () {
        var expanded = $(this).hasClass('expand-districts');
        $('.district-toggle').each(function () { setDistrictExpanded(this, expanded); });
    });

    function printDistricts(sections) {
        var error = document.querySelector('.print-error');
        error.hidden = true;
        var printWindow = window.open('', '_blank');
        if (!printWindow) {
            error.textContent = 'Allow pop-ups for this site, then click Print again.';
            error.hidden = false;
            return;
        }
        var doc = printWindow.document;
        doc.title = 'Submission Report';
        var style = doc.createElement('style');
        style.textContent = '@page { size: landscape; margin: 12mm; }' +
            'body { font: 11px Arial, sans-serif; color: #111; margin: 20px; }' +
            'h1 { font-size: 20px; margin-bottom: 6px; } h2 { font-size: 15px; margin: 20px 0 10px; }' +
            'table { width: 100%; border-collapse: collapse; table-layout: fixed; }' +
            'th, td { border: 1px solid #777; padding: 7px; text-align: left; vertical-align: top; overflow-wrap: anywhere; }' +
            'th { background: #eee; } th:first-child { width: 21%; }' +
            'a { color: inherit; text-decoration: none; }' +
            'small { display: block; margin-top: 4px; font-size: 10px; }' +
            'thead { display: table-header-group; } tr { break-inside: avoid; }' +
            'section + section { break-before: page; } h2 { break-after: avoid; }' +
            '.profile-progress { display: none; } button { padding: 8px 16px; margin-bottom: 12px; }' +
            '@media print { body { margin: 0; } button { display: none; } }';
        doc.head.appendChild(style);
        var printButton = doc.createElement('button');
        printButton.textContent = 'Print / Save as PDF';
        printButton.onclick = function () { printWindow.print(); };
        doc.body.appendChild(printButton);
        var heading = doc.createElement('h1');
        heading.textContent = 'Submission Report';
        doc.body.appendChild(heading);
        var subtitle = doc.createElement('p');
        subtitle.textContent = document.querySelector('.report-heading p').textContent;
        doc.body.appendChild(subtitle);
        sections.each(function () {
            var section = doc.createElement('section');
            var title = doc.createElement('h2');
            title.textContent = this.querySelector('.district-heading').textContent;
            section.appendChild(title);
            var source = this.querySelector('table');
            var table = doc.createElement('table');
            table.appendChild(source.tHead.cloneNode(true));
            // DataTables removes off-page rows from the DOM; retrieve every row explicitly.
            var body = doc.createElement('tbody');
            $(source).DataTable().rows({ search: 'none', page: 'all', order: 'applied' }).nodes().each(function (row) {
                body.appendChild(row.cloneNode(true));
            });
            table.appendChild(body);
            section.appendChild(table);
            doc.body.appendChild(section);
        });
        printWindow.focus();
        printWindow.setTimeout(function () { printWindow.print(); }, 250);
    }

    $('.print-all-districts').on('click', function () {
        printDistricts($('.submission-report section'));
    });
    $('.print-district').on('click', function () {
        printDistricts($(this).closest('section'));
    });
});
</script>
